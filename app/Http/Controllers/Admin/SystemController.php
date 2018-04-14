<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/14
 * Time: 19:17
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\System;
use Illuminate\Http\Request;

class SystemController extends BaseController
{
    public function index()
    {
        $system = System::all();
        return view('admin.setting', array('system' => $system->toArray()));
    }

    public function systemSave(Request $request){
        $param = $request->input();
        System::where('id', $param['id'])->update(array('value' => $param['value']));
    }
}