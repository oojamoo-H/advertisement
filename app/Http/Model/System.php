<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/11
 * Time: 10:31
 */

namespace App\Http\Model;


class System extends BaseModel
{
    protected $fillable = ['key', 'value', 'show_name', 'description'];
}