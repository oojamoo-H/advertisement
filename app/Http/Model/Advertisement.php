<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/12
 * Time: 13:50
 */

namespace App\Http\Model;


class Advertisement extends BaseModel
{
    public function media(){
        return $this->hasManyThrough('App\Http\Model\Media', 'App\Http\Model\AdvertisementMedia','advertisement_id', 'id');
    }

    public function city(){
        return $this->hasManyThrough('App\Http\Model\City', 'App\Http\Model\AdvertisementUserCity','advertisement_id', 'id');
    }

    public function user()
    {
        return $this->hasManyThrough('App\Http\Model\User', 'App\Http\Model\AdvertisementUserCity','advertisement_id', 'id');
    }
}