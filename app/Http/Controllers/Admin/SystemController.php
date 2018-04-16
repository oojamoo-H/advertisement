<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/14
 * Time: 19:17
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\System;
use App\Http\Model\UserAdmin;
use Illuminate\Http\Request;

class SystemController extends BaseController
{
    public function index()
    {
        $system = System::all();
        $user = UserAdmin::all();
        return view('admin.setting', array('system' => $system->toArray(), 'user' => $user->toArray()));
    }

    public function systemSave(Request $request){
        $param = $request->input();
        System::where('id', $param['id'])->update(array('value' => $param['value']));
    }

    public function saveAdminPassword(Request $request){
        $id = $request->input('id');
        $password = trim($request->input('password'));

        if (! $id){
            return $this->Error(-1, 'Id Not found');
        }

        if (! $password) {
            return $this->Error(-1, 'Password Not found');
        }

        UserAdmin::find($id)->update(array('password' => md5($password)));

        return $this->Success();
    }
}