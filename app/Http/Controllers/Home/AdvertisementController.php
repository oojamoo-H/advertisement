<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:09
 */

namespace App\Http\Controllers\Home;

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

    public function index()
    {
        return view('home.index');
    }

    public function getIndexContent(Request $request)
    {
        $parent_city = $request->input('parent_city') ? $request->input('parent_city') : 0;
        $sub_city = $request->input('sub_city');

        $parent_cities = City::where('parent_id', 0)->select(array('id', 'city_name'))->get()->toArray();
        $sub_cities = array();

        if ($parent_city != 0){
            if ($sub_cities_result = City::where('parent_id', $parent_city)->select(array('id', 'city_name'))->get()){
                $sub_cities = $sub_cities_result->toArray();
            }
        }

        $sub_city = $sub_city ? $sub_city : $parent_city;

        $results = DB::table('cities as c')
            ->select('ad.id as advertisement_id', 'u.id as user_id', 'ad.title', 'ad.content')
            ->leftjoin('advertisement_user_cities as auc','auc.city_id','=','c.id')
            ->join('users as u', 'u.id', '=', 'auc.user_id')
            ->join('advertisements as ad', 'ad.id', '=', 'auc.advertisement_id')
            ->where('c.id', '=', $sub_city)
            ->get();

        if ($results){
            $results = $results->toArray();
            foreach ($results as &$res){
                $media = DB::table('media as m')
                    ->join('advertisement_media as am','am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $res->media = $media ? $media : array();
            }
        } else {
            $results = array();
        }

        return $this->Success(array('cities' => $parent_cities, 'advertisement_list' => $results, 'sub_cities' => $sub_cities));
    }


    public function getAdvertisement(Request $request)
    {
        $city_id = $request->input('city_id') ? $request->input('city_id') : 1;
        $advertisement_list = City::with('advertisement.media')->where('id', $city_id)->get()->toArray();

    }

    public function detail(Request $request)
    {
        $ad_id = $request->input('ad_id');
        $user_id = $request->input('user_id');
        $ad_detail = Advertisement::with('media')->where('id', $ad_id)->first()->toArray();
        $user_ad = User::with('advertisement', 'city')->where('id', $user_id)->first()->toArray();
        return view('home.detail', array('detail' => $ad_detail, 'user_ad' => $user_ad));
    }

    public function search()
    {

    }

    /**
     * Ad Post Page
     */
    public function postAd()
    {
        return view('home.post');
    }


    public function saveAd(Request $request)
    {
        $session_token = $request->headers->get('x-session-token');
        $content = $request->input('content');
        $title = $request->input('title');
        $parent_city_id = $request->input('parent_city_id');
        $sub_city_id = $request->input('sub_city_id');
        $user= $request->session()->get('home_' . $session_token);
        $media_ids = $request->input('media_ids');

        if (! $session_token){
            return $this->Error(-1,'Please Login First');
        }

        if (! $title){
            return $this->Error(-1,'Please entry title');
        }

        if (! $content){
            return $this->Error(-1,'Please entry content');
        }

        if (! $parent_city_id){
            return $this->Error(-1,'Please select city');
        }

        if (! $user_assets = UserAsset::where('user_id', $user['id'])->first()){
            return $this->Error(-1, 'Please buy credit first');
        }

        if (! $sub_city_id){
            $sub_city_id = $parent_city_id;
        }

        // Begin transaction to handle the advertisement, user and media data
        DB::beginTransaction();
        try{
            //First insert advertisement data into database
            $advertisementModel = new Advertisement();
            $advertisementModel->title = $title;
            $advertisementModel->content = $content;
            $advertisementModel->save();

            //Then insert the advertisement and media relationships into database
            if ($media_ids){
                $now = date('y-m-d H:i:s');
                $media_ids = explode('|', $media_ids);
                $media = array_map(function($v) use ($advertisementModel, $now){
                    return array(
                        'media_id' => $v,
                        'advertisement_id' => $advertisementModel->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    );
                }, $media_ids);

                DB::table('advertisement_media')->insert($media);
            }

            //Last insert the advertisement, city and user relationships into database
            AdvertisementUserCity::create(array('user_id' => $user['id'], 'city_id' => $sub_city_id, 'advertisement_id' => $advertisementModel->id));
            $point_consume = System::where('key', 'point_consume')->first()->toArray();

            $user_assets->point = $user_assets->point - $point_consume['value'];
            $user_assets->save();
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return $this->Error(-1, $e->getMessage());
        }

        return $this->Success();
    }

}