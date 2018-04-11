<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:10
 */

namespace App\Http\Controllers\Home;


use App\Http\Model\System;
use App\Http\Model\User;
use App\Http\Model\UserAuth;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * api - Register
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        if (! $username){
            return $this->Error(-1, 'Username Is Empty');
        }

        if (! $password){
            return $this->Error(-1, 'Password Is Empty');
        }

        if (! $password !== $confirm_password){
            return $this->Error(-1, 'Password Is Not Matched');
        }

        if ($user = User::where('username', trim($username))->first()){
            return $this->Error(-1, 'This Username Has Been Used');
        }

        $user = new User();
        $user->username = $user;
        $user->password = md5($password);
        $user->is_active = 0;
        $user->status = 0;
        $result = $user->save();
        return $this->Success();
    }

    /**
     * api - Activate
     * @param Request $request
     * @return array
     */
    public function activate(Request $request){
        $auth_code = $request->input('code');
        $user_id = $request->input('id');

        if (! $auth_code || $user_id){
            return $this->Error(-1, 'Param Not Found');
        }

        if (! $auth = UserAuth::where(array('user_id' => $user_id, 'auth_code' => $auth_code))->fisrt()->toArray()){
            return $this->Error(-1, 'Auth Code Error');
        }

        /**
         * 此处激活码超时设定暂时不用
         */
        $expire = System::where('key', 'code_expire')->select('value')->first();
        if (time() > strtotime($auth['updated_at']) + $expire['value']){
            //#TODO
        }

        $user = User::find($user_id);
        $user->is_active = 1;
        $user->save();
        return $this->Success();
    }
}