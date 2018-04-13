<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:00
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\UserAdmin;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    private $gt_captcha_id = 'YourId';

    public function index(){
        return view('admin.login');
    }

    public function login(Request $request){
        $challenge = $request->input('geetest_challenge');
        $validate = $request->input('geetest_validate');

        if(!$challenge || md5($challenge) != $validate){
            return $this->Error(-1, 'Please validate first');
        }

        $username = $request->input('username');
        $password = $request->input('password');

        if (! $user = UserAdmin::where(array('username' => $username, 'password' => md5($password)))->select(array('id', 'username'))->first()){
            return $this->Error(-1, 'Wrong account or password');
        }
        $token = generate_user_token($user['id'], 'admin_user_token', true);
        $request->session()->put('admin_user', $token);
        return $this->Success($user);
    }

    public function logout(Request $request)
    {
        if($request->session()->has('admin_user')){
            $request->session()->forget('admin_user');
        }

        return $this->Success();
    }

    public function gt(){
        $rnd1           = md5(rand(0, 100));
        $rnd2           = md5(rand(0, 100));
        $challenge      = $rnd1 . substr($rnd2, 0, 2);
        $result         = array(
            'success'   => 0,
            'gt'        => $this->gt_captcha_id,
            'challenge' => $challenge,
            'new_captcha'=>1
        );
        return $this->Success($result);
    }
}