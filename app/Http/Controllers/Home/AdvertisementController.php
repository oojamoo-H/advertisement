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
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);

        return view('home.index', array('user' => $user));
    }

    public function getIndexContent(Request $request)
    {
        $parent_city = $request->input('parent_city') ? $request->input('parent_city') : 0;
        $sub_city = $request->input('sub_city');
        $orderBy = $request->input('orderby');

        $parent_cities = City::where('parent_id', 0)->select(array('id', 'city_name'))->get()->toArray();
        $sub_cities = array();


        if ($parent_city != 0){
            if ($sub_cities_result = City::where('parent_id', $parent_city)->select(array('id', 'city_name'))->get()){
                $sub_cities = $sub_cities_result->toArray();
            }
        }

        $sub_city = $sub_city ? $sub_city : $parent_city;

        $db = DB::table('cities as c')
            ->select('ad.id as advertisement_id', 'u.id as user_id', 'ad.title', 'ad.content')
            ->leftjoin('advertisement_user_cities as auc','auc.city_id','=','c.id')
            ->join('users as u', 'u.id', '=', 'auc.user_id')
            ->join('advertisements as ad', 'ad.id', '=', 'auc.advertisement_id')
            ->where('c.id', '=', $sub_city);


        if ($orderBy == 'date'){
            $db->orderBy('ad.created_at', 'desc');
        }

        if ($results = $db->get()){
            foreach ($results as &$res){
                $media = DB::table('media as m')
                    ->join('advertisement_media as am','am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $image = array(); $video = array();
                if ($media){
                    foreach ($media as $m){
                        if ($m->media_type == 'image'){
                            array_push($image, $m);
                        }

                        if ($m->media_type == 'video'){
                            array_push($video, $m);
                        }
                    }
                }
                $res->image = $image;
                $res->video = $video;
            }
        } else {
            $results = array();
        }

        return $this->Success(array('cities' => $parent_cities, 'advertisement_list' => $results, 'sub_cities' => $sub_cities));
    }


    public function getTop(){

        $user_top = DB::table('user_assets as ua')
            ->join('advertisement_user_cities as auc', 'auc.user_id', '=', 'ua.user_id')
            ->orderBy('ua.point', 'desc')
            ->limit(5)
            ->get();
        if ($user_top){
            $user_top = $user_top->toArray();
            foreach ($user_top as &$top){
                $media = DB::table('media as m')
                    ->select('m.media_url', 'am.advertisement_id')
                    ->join('advertisement_media as am','am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $top->advertisement_id)
                    ->where('m.media_type', '=', 'image')
                    ->orderBy('m.created_at', 'desc')
                    ->first();
                $top->media = $media ? $media : array();
            }
        } else {
            $user_top = array();
        }

        return $this->Success($user_top);
    }


    public function searchAdvertisement(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = DB::table('advertisements as ad')
            ->leftjoin('advertisement_user_cities as auc','auc.advertisement_id','=','ad.id')
            ->join('users as u', 'u.id', '=','auc.user_id')
            ->where('ad.content', 'like', "%{$keyword}%")
            ->get();
        if ($results){
            $results = $results->toArray();
            foreach ($results as &$res){
                $media = DB::table('media as m')
                    ->join('advertisement_media as am','am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $image = array(); $video = array();
                if ($media){
                    foreach ($media as $m){
                        if ($m->media_type == 'image'){
                            array_push($image, $m);
                        }

                        if ($m->media_type == 'video'){
                            $video = $m;
                        }
                    }
                }
                $res->image = $image;
                $res->video = $video;
            }
        } else {
            $results = array();
        }

        return $this->Success(array('advertisement_list' => $results));

    }

    public function detail(Request $request)
    {
        $ad_id = $request->input('ad_id');
        if ($ad_detail = Advertisement::with('media')->where('id', $ad_id)->first()){
            $other_detail = DB::table('advertisement_user_cities as auc')
                            ->join('users as u', 'auc.user_id', '=', 'u.id')
                            ->where('auc.advertisement_id', '=', $ad_detail->id)
                            ->select('u.id', 'u.username')
                            ->first();
            $user_ad = User::with('advertisement', 'city')->select('id', 'nickname')->where('id', $other_detail->id)->first();
            return view('home.detail', array('detail' => $ad_detail, 'user_ad' => $user_ad));
        } else {
            return view('home.no-data');

        }
    }

    public function search(Request $request)
    {

    }

    /**
     * Ad Post Page
     */
    public function postAd()
    {
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);
        return view('home.post', array('user' => $user));
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