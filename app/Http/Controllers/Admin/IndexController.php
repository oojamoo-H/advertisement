<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:19
 */

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return view('admin.index');
    }
}