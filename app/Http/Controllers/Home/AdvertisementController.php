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
use App\Http\Model\User;
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
        $parent_city = $request->input('parent_city') ? $request->input('parent_city') : 9;
        $sub_city = $request->input('sub_city');
        $sub_cities = array();
        $cities = City::where('parent_id', 0)->select(array('id', 'city_name'))->get()->toArray();

        if (! $sub_city){
            $sub_city = $cities[0]['id'];

            if ($sub_cities = City::where('parent_id', $parent_city)->select(array('id', 'city_name'))->get()->toArray()){
                $sub_city = $sub_cities[0]['id'];
            }
        }


        $advertisement_list = City::with('advertisement.media', 'advertisement.user')->where('id', $sub_city)->select(array('id', 'city_name'))->first()->toArray();
        return $this->Success(array('cities' => $cities, 'advertisement_list' => $advertisement_list, 'sub_cities' => $sub_cities));
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
        $content = $request->input('content');
        $title = $request->input('title');
        $city_id = $request->input('city_id');
        $user_id = $request->input('user_id');
        $media_ids = $request->input('media_ids');
        // Begin transaction to handle the advertisement, user and media data
        DB::beginTransaction();
        try{
            //First insert advertisement data into database
            $advertisementModel = new Advertisement();
            $advertisementModel->title = $title;
            $advertisementModel->content = $content;
            $advertisementModel->save();

            //Then insert the advertisement and media relationships into database
            $media_ids = explode(':', $media_ids);
            $media = array_map(function($v) use ($advertisementModel){
                return array('media_id' => $v, 'advertisement_id' => $advertisementModel->id);
            }, $media_ids);
            AdvertisementMedia::create($media);

            //Last insert the advertisement, city and user relationships into database
            AdvertisementUserCity::create(array('user_id' => $user_id, 'city_id' => $city_id, 'advertisement_id' => $advertisementModel->id));

        } catch(Exception $e){
            DB::rollBack();
            return $this->Error(-1, $e->getMessage());
        }

        return $this->Success();
    }

}