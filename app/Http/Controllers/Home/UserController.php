<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:10
 */

namespace App\Http\Controllers\Home;


use App\Http\Model\Advertisement;
use App\Http\Model\AdvertisementUserCity;
use App\Http\Model\System;
use App\Http\Model\User;
use App\Http\Model\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    /**
     * api - Register
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $username = trim($request->input('username'));
        $password = trim($request->input('password'));
        $nickname = trim($request->input('nickname'));
        $mobile = trim($request->input('mobile'));
        $confirm_password = trim($request->input('confirm_password'));
        $auth_code = trim($request->input('code'));

        // If username is empty return invalid
        if (!$username) {
            return $this->Error(-1, 'Username Is Empty');
        }

        if (!$nickname) {
            return $this->Error(-1, 'Nickname Is Empty');
        }

        if (!$mobile) {
            return $this->Error(-1, 'Mobile Is Empty');
        }

        if (strlen($nickname) > 12) {
            return $this->Error(-1, 'Too long for nickname');
        }

        if (!is_email($username)) {
            return $this->Error(-1, 'Wrong email format');
        }

        if (!is_mobile($mobile)) {
            return $this->Error(-1, 'Wrong mobile format');
        }


        // If password is empty return invalid
        if (!$password) {
            return $this->Error(-1, 'Password Is Empty');
        }

        if (strlen($password) < 6) {
            return $this->Error(-1, 'Password is too short');
        }

        if (strlen($password) > 12) {
            return $this->Error(-1, 'Password is too long');
        }

        // If confirm_password is wrong return invalid

        if ($password !== $confirm_password) {
            return $this->Error(-1, 'Password Is Not Matched');
        }


        // If auth_code is empty return invalid
        if (!$auth_code) {
            return $this->Error(-1, 'Auth Code Not Found');
        }


        if (User::where('nickname', $nickname)->first()) {
            return $this->Error(-1, 'Nickname has been used');
        }

        $user = User::where(array('username' => $username))->first();

        // If this user has been activated return invalid
        if ($user->is_active) {
            return $this->Error(-1, 'This Username Has Been Used');
        }

        // If the auth code is wrong return invalid
        if (!UserAuth::where(array('user_id' => $user['id'], 'auth_code' => strtolower($auth_code)))->first()) {
            return $this->Error(-1, 'Auth Code is Wrong');
        }

        //Update user to activate
        $user->password = $password;
        $user->is_active = 1;
        $user->nickname = $nickname;
        $user->mobile = $mobile;
        $user->save();
        //Finish
        return $this->Success($user);
    }

    /**
     * api - Activate
     * @param Request $request
     * @return array
     */
    public function registerTemp(Request $request)
    {
        $username = trim($request->input('username'));

        // If username is empty return invalid
        if (!$username) {
            return $this->Error(-1, 'Please entry username first to get code');
        }

        if (!is_email($username)) {
            return $this->Error(-1, 'Wrong email format');
        }

        $user = User::where(array('username' => $username))->first();
        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->password = '';
            $user->is_active = 0;
            $user->status = 0;
            if(!$user->save()){
                return $this->Error(-1, 'System Error!');
            }
        }

        $user = $user->toArray();
        if ($user['is_active']) {
            return $this->Error(-1, 'This user has been activated');
        }
        $code = $this->saveUserCode($user);
        //$this->sendRegisterEmail($user,$code);
        $path = base_path()."/artisan email:send '{$user['nickname']}' '{$user['username']}' '{$code}'&";
        pclose(popen("/usr/bin/php ".$path, "r"));
        return $this->Success(array('userId' => $user['id']));
    }

    public function getServiceTel()
    {
        $tel = System::where('key', 'service_tel')->select('value')->first();
        return $this->Success($tel);
    }

    function myAdList(Request $request)
    {
        $token = session()->get('home_user');
        $user = session()->get('home_' . $token);

        $ad_ids = AdvertisementUserCity::where('user_id', $user['id'])
            ->pluck('advertisement_id')
            ->toArray();
        $ad = Advertisement::whereIn('id', $ad_ids)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();

        return view('home.my-ad-list', array('result' => $ad));
    }

    private function saveUserCode($user)
    {
        $code = $this->getCode();
        if (! $user_auth = UserAuth::where('user_id', $user['id'])->first()){
            $user_auth = new UserAuth();
            $user_auth->user_id = $user['id'];
        }
        $user_auth->auth_code = $code;
        $user_auth->save();
        return $code;
    }

    private function sendRegisterEmail($user,$code)
    {
        $params = array(
            'code' => $code,
            'uname'  => $user['nickname']
        );
        Mail::alwaysTo($user['username']);
        $flag = Mail::send('reg_email',$params,function($message){
            $message->subject('EscortBabe Account Verification');
        });
        return $flag;
    }

    private function getCode()
    {
        $code = '';
        while(true){
            $code = strtoupper(generate_user_auth_code());
            if (!UserAuth::where('auth_code', '=', $code)->first()){
                break;
            }
        }
        return $code;
    }
}