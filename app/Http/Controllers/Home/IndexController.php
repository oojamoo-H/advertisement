<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 12:58
 */

namespace App\Http\Controllers\Home;


class IndexController extends BaseController
{
    /**
     * 投放广告首页
     */
    public function index()
    {
        return view('home.index');
    }
}