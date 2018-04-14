<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:09
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Advertisement;
use App\Http\Model\AdvertisementMedia;
use App\Http\Model\AdvertisementUserCity;
use App\Http\Model\City;
use App\Http\Model\System;
use App\Http\Model\User;
use App\Http\Model\UserAsset;
use Excel;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;

class AdvertisementController extends BaseController
{

    public function getAdvertisementList(Request $request)
    {
        $user_id = $request->input('user_id');
        $keyword = $request->input('keyword');

        $db = DB::table('advertisements as ad')
                    ->leftJoin('advertisement_user_cities as auc', 'auc.advertisement_id', '=', 'ad.id')
                    ->leftJoin('cities as c', 'auc.city_id', '=', 'c.id')
                    ->leftJoin('users as u', 'auc.id', '=', 'u.id')
                    ->where('auc.user_id', '=', $user_id);

        if ($keyword){
            $db = $db->where('ad.content', 'like', "%{$keyword}%");
        }
        $count = $db->count();
        $advertisement_list = $db->select('ad.*', 'c.city_name', 'u.nickname')
            ->get();

        foreach ($advertisement_list as &$res){
            $media = DB::table('media as m')
                ->leftJoin('advertisement_media as am','am.media_id', '=', 'm.id')
                ->where('am.advertisement_id', '=', $res->id)
                ->get();
            $res->media = $media ? $media : array();
        }
        return array('code' => 0, 'msg' => '', 'count' => $count, 'data' => $advertisement_list);
    }


}