<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 19:23
 */

namespace App\Http\Model;

class User extends BaseModel
{
    public function assets()
    {
        return $this->hasOne('App\Http\Model\UserAsset');
    }

    public function advertisement()
    {
        return $this->hasManyThrough('App\Http\Model\Advertisement', 'App\Http\Model\AdvertisementUserCity', 'user_id', 'id');
    }

    public function city(){
        return $this->hasManyThrough('App\Http\Model\City', 'App\Http\Model\AdvertisementUserCity', 'user_id', 'id');

    }
}