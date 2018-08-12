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
use App\Http\Model\FriendlyLinks;
use App\Http\Model\Media;
use App\Http\Model\System;
use App\Http\Model\User;
use App\Http\Model\UserAsset;
use Excel;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\Mail;

class AdvertisementController extends BaseController
{

    public function index()
    {
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);
        if ($user) {
            $user['point'] = 0;

            if ($userAsset = UserAsset::where('user_id', $user['id'])->first()) {
                $user['point'] = $userAsset->point;
            }
        }
        if($this->isMobile()) {
            return view('home.index', array('user' => $user));
        }else{
            return view('pc.index', array('user' => $user));
        }
    }

        public function getIndexContent(Request $request)
    {
        $data = array();
        $parent_city = $request->input('parent_city') ? $request->input('parent_city') : 0;
        $sub_city = $request->input('sub_city');
        $orderBy = $request->input('orderby');

        if (!$parent_city) {
            $parent_cities = City::where('parent_id', 0)->select(array('id', 'city_name'))->get()->toArray();
            $data['cities'] = $parent_cities;
        }

        $sub_cities = array();
        if ($parent_city != 0) {
            if ($sub_cities_result = City::where('parent_id', $parent_city)->select(array('id', 'city_name'))->get()) {
                $sub_cities = $sub_cities_result->toArray();
                $data['sub_cities'] = $sub_cities;
            }
        }

        $db = DB::table('cities as c')
            ->select('ad.title', 'ad.id as advertisement_id', 'u.id as user_id', 'ad.title', 'ad.content', 'ad.count','ad.created_at')
            ->leftjoin('advertisement_user_cities as auc', 'auc.city_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'auc.user_id')
            ->join('advertisements as ad', 'ad.id', '=', 'auc.advertisement_id');

        if ($sub_city) {
            $db->where('auc.city_id', '=', $sub_city);
        } else if ($parent_city != 0) {
            if ($sub_cities) {
                $sub_cities_for_ad = array_map(function ($city) {
                    return $city['id'];
                }, $sub_cities);
                $db->whereIn('auc.city_id', $sub_cities_for_ad);
            } else {
                $db->where('auc.city_id', '=', $parent_city);
            }
        }


        if ($orderBy == 'date') {
            $db->orderBy('ad.created_at', 'asc');
        } else {
            $db->orderBy('ad.created_at', 'desc');
        }

        if ($results = $db->get()) {
            foreach ($results as &$res) {
                $media = DB::table('media as m')
                    ->join('advertisement_media as am', 'am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $image = array();
                $video = array();
                if ($media) {
                    foreach ($media as $m) {
                        if ($m->media_type == 'image') {
                            array_push($image, $m);
                        }

                        if ($m->media_type == 'video') {
                            array_push($video, $m);
                        }
                    }
                }
                $res->image = $image;
                $res->video = $video;
                $res->created_at = date('j M,G A',strtotime($res->created_at));
            }
        } else {
            $results = array();
        }
        $data['advertisement_list'] = $results;


        $db = DB::table('cities as c')
            ->select('ad.title', 'ad.id as advertisement_id', 'u.id as user_id', 'ad.title', 'ad.content', 'ad.count','ad.created_at')
            ->leftjoin('advertisement_user_cities as auc', 'auc.city_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'auc.user_id')
            ->join('advertisements as ad', 'ad.id', '=', 'auc.advertisement_id')
            ->orderBy('ad.count', 'desc')
            ->limit(10);
        if ($results = $db->get()) {
            foreach ($results as &$res) {
                $media = DB::table('media as m')
                    ->join('advertisement_media as am', 'am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $image = array();
                $video = array();
                if ($media) {
                    foreach ($media as $m) {
                        if ($m->media_type == 'image') {
                            array_push($image, $m);
                        }

                        if ($m->media_type == 'video') {
                            array_push($video, $m);
                        }
                    }
                }
                $res->image = $image;
                $res->video = $video;
                $res->created_at = date('j M,G A',strtotime($res->created_at));
            }
        } else {
            $results = array();
        }
        $data['top_advertisement'] = $results;


        return $this->Success($data);
    }

    public function getTop()
    {

        $user_top = DB::table('user_assets as ua')
            ->orderBy('ua.point', 'desc')
            ->limit(5)
            ->get();
        $advertisement = array();
        if ($user_top) {
            foreach ($user_top as $u) {
                $result = DB::table('advertisement_media as am')
                    ->select('am.advertisement_id', 'm.media_url', 'm.is_cover')
                    ->join('advertisement_user_cities as auc', 'auc.advertisement_id', '=', 'am.advertisement_id')
                    ->join('media as m', 'm.id', '=', 'am.media_id')
                    ->where('auc.user_id', '=', $u->user_id)
                    ->where('m.is_cover', '=', 1)
                    ->orderBy('auc.created_at', 'desc')
                    ->first();
                if ($result) {
                    array_push($advertisement, $result);
                }
            }
        }
        return $this->Success($advertisement);
    }


    public function searchAdvertisement(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = DB::table('advertisements as ad')
            ->leftjoin('advertisement_user_cities as auc', 'auc.advertisement_id', '=', 'ad.id')
            ->join('users as u', 'u.id', '=', 'auc.user_id')
            ->where('ad.content', 'like', "%{$keyword}%")
            ->orWhere('ad.title', 'like', "%{$keyword}%")
            ->orderBy('ad.created_at', 'desc')
            ->get();
        if ($results) {
            $results = $results->toArray();
            foreach ($results as &$res) {
                $media = DB::table('media as m')
                    ->join('advertisement_media as am', 'am.media_id', '=', 'm.id')
                    ->where('am.advertisement_id', '=', $res->advertisement_id)
                    ->get();
                $image = array();
                $video = array();
                if ($media) {
                    foreach ($media as $m) {
                        if ($m->media_type == 'image') {
                            array_push($image, $m);
                        }

                        if ($m->media_type == 'video') {
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
        $ad_detail = Advertisement::find($ad_id);

        if (!$ad_detail) {
            return view('home.no-data');
        }

        DB::table('advertisements')->where('id',$ad_id)->increment('count');
        $ad_detail->count += 1;

        $media = DB::table('advertisement_media as am')
            ->select('m.media_url', 'm.media_type')
            ->join('media as m', 'am.media_id', '=', 'm.id')
            ->where('am.advertisement_id', '=', $ad_id)
            ->get();
        $ad_detail->media = $media ? $media->toArray() : array();

        $other_detail = DB::table('advertisement_user_cities as auc')
            ->join('users as u', 'auc.user_id', '=', 'u.id')
            ->where('auc.advertisement_id', '=', $ad_detail->id)
            ->select('u.id', 'u.username')
            ->first();
        $user_ad = User::with('advertisement', 'city')->select('id', 'nickname')->where('id', $other_detail->id)->first();
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);
        if ($user) {
                $user['point'] = 0;

                if ($userAsset = UserAsset::where('user_id', $user['id'])->first()) {
                    $user['point'] = $userAsset->point;
                }
        }
        if($this->isMobile()) {
            return view('home.detail', array('detail' => $ad_detail->toArray(), 'user_ad' => $user_ad->toArray()));
        }else{
            return view('pc.detail', array('detail' => $ad_detail->toArray(), 'user_ad' => $user_ad->toArray(),'user'=>$user));
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        return view('pc.search',array('keyword'=>$keyword));
    }

    /**
     * Ad Post Page
     */
    public function postAd(Request $request)
    {
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);
        $id = $request->input('ad_id');
        $repost = $request->input('repost');
        $user['point'] = 0;

        if ($userAsset = UserAsset::where('user_id', $user['id'])->first()) {
            $user['point'] = $userAsset->point;
        }
        $ad_detail = array();
        $title = 'Post Ad';
        if ($id) {
            $title = 'Edit Ad';
            //content
            $ad_detail['ad'] = Advertisement::find($id)->toArray();
            $auc = AdvertisementUserCity::where('advertisement_id', $id)->first();
            $city = City::with('children')->where('id', $auc->city_id)->select('id', 'city_name', 'parent_id')->first();
            $ad_detail['city']['city'] = $city->toArray();
            if($city->parent_id) {
                $city_parent = City::with('children')->where('id', $city->parent_id)->select('id', 'city_name', 'parent_id')->first();
                $ad_detail['city']['parent'] = $city_parent->toArray();
            }
            //media
            $media = DB::table('advertisement_media as am')
                ->select('m.id', 'm.media_url', 'm.media_type', 'm.is_cover')
                ->join('media as m', 'am.media_id', '=', 'm.id')
                ->where('am.advertisement_id', '=', $id)
                ->get()->toArray();

            foreach ($media as $v) {
                if ($v->media_type == 'image' && $v->is_cover == 1) {
                    $ad_detail['media']['image']['cover'] = $v;
                } elseif ($v->media_type == 'image') {
                    $ad_detail['media']['image']['list'][] = $v;
                } elseif ($v->media_type == 'video') {
                    $ad_detail['media']['video'] = $v;
                }
            }
            if ($repost) {
                $id = 0;
                $title = 'Repost Ad';
            }
        }
        //var_dump($ad_detail['media']);die();
        return view('home.post', array('user' => $user, 'id' => $id, 'detail' => $ad_detail, 'title' => $title));
    }


    public function saveAd(Request $request)
    {
        $session_token = $request->headers->get('x-session-token');
        $content = $request->input('content');
        $title = $request->input('title');
        $parent_city_id = $request->input('parent_city_id');
        $sub_city_id = $request->input('sub_city_id');
        $user = $request->session()->get('home_' . $session_token);
        $media_ids = $request->input('media_ids');
        $id = $request->input('id');

        if (!$session_token) {
            return $this->Error(-1, 'Please Login First');
        }

        if (!$title) {
            return $this->Error(-1, 'Please entry title');
        }

        if (!$content) {
            return $this->Error(-1, 'Please entry content');
        }

        if (!$parent_city_id) {
            return $this->Error(-1, 'Please select city');
        }

        if (!$user_assets = UserAsset::where('user_id', $user['id'])->first()) {
            return $this->Error(-1, 'Please buy credit first');
        }

        if (!$sub_city_id) {
            $sub_city_id = $parent_city_id;
        }

        // Begin transaction to handle the advertisement, user and media data
        if ($id) {
            $advertisementModel = Advertisement::find($id);
        } else {
            $advertisementModel = new Advertisement();
        }
        $advertisementModel->title = $title;
        $advertisementModel->content = str_replace("\n", '<br>', $content);

        DB::beginTransaction();
        try {
            //First insert advertisement data into database
            $advertisementModel->save();

            //Then insert the advertisement and media relationships into database
            if ($media_ids) {
                DB::table('advertisement_media')->where('advertisement_id', $advertisementModel->id)->delete();
                $now = date('y-m-d H:i:s');
                $media_ids = explode('|', $media_ids);
                $media = array_map(function ($v) use ($advertisementModel, $now) {
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
            DB::table('advertisement_user_cities')->where('advertisement_id', $advertisementModel->id)->delete();
            AdvertisementUserCity::create(array('user_id' => $user['id'], 'city_id' => $sub_city_id, 'advertisement_id' => $advertisementModel->id));

            if (!$id) {
                $point_consume = System::where('key', 'point_consume')->first()->toArray();
                $user_new_point = $user_assets->point - $point_consume['value'];

                if ($user_new_point < 0) {
                    return $this->Error(-1, 'Point Not Enough');
                }
                $user_assets->point = $user_new_point;
                $user_assets->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->Error(-1, $e->getMessage());
        }

        return $this->Success();
    }

    public function emailToFriend(Request $request)
    {
        $email = $request->input('email');
        if(!is_email($email)){
            return $this->Error(-1,'email is error!');
        }
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);
        if($user){
            $user = User::find($user['id']);
        }
        $params = array(
            'uname'  => $user['nickname'] ?: ''
        );
        Mail::alwaysTo($email);
        $flag = Mail::send('email_to_friend',$params,function($message){
            $message->subject('EscortPie Email To Friend');
        });
        return $this->Success($flag ? 1 : 0);
    }

}