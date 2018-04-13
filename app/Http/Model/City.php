<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/11
 * Time: 22:33
 */

namespace App\Http\Model;


class City extends BaseModel
{
    public function advertisement()
    {
        return $this->hasManyThrough('App\Http\Model\Advertisement', 'App\Http\Model\AdvertisementUserCity', 'city_id', 'id');
    }
}