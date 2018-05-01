<?php
/**
 * Created by PhpStorm.
 * User: YJRen
 * Date: 2018/5/1
 * Time: 13:29
 */

namespace App\Http\Controllers\Home;

use App\Http\Model\Advertisement;
use App\Http\Model\AdvertisementUserCity;
use App\Http\Model\City;
use App\Http\Model\FriendlyLinks;
use App\Http\Model\System;
use App\Http\Model\User;
use App\Http\Model\UserAsset;
use Excel;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;

class SystemController extends BaseController
{
    public function getFriendlyLinks()
    {
        $friendly_links = FriendlyLinks::select('id', 'name', 'is_url', 'url')->where('status', '1')->orderBy('sort', 'desc')->get()->toArray();

        foreach ($friendly_links as &$v) {
            if ($v['is_url'] != 1) {
                $v['url'] = '/sys/friendLink?id=' . $v['id'];
            }
        }
        return $this->Success($friendly_links);
    }

    public function friendLink(Request $request)
    {
        $id = $request->input('id');
        $friendly_link = FriendlyLinks::where([
            ['id', $id],
            ['status', 1],
            ['is_url', 0]
        ])->first()->toArray();
        return view('home.friendly-link',['result'=>$friendly_link]);
    }
}