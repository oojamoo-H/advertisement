<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 13:13
 */

namespace App\Http\Controllers\Home;


use App\Http\Model\User;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     * Login Page
     */
    public function index()
    {
        return view('home.login');
    }

    /**
     * api-Login
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = md5($request->input('password'));

        if (! $username){
            return $this->Error(-1, 'Username is empty');
        }

        if (! $password){
            return $this->Error(-1, 'Password is empty');
        }

        if (! $user = User::where(array('username' => $username, 'password' => $password))->select(array('id', 'username', 'is_active'))->first()){
            return $this->Error(-1, 'Please Register First');
        }

        if (! $user->is_active){
            return $this->Error(-2, 'Please contact customer service to activate');
        }

        $token = generate_user_token($user['id']);
        $request->session()->put('home_user', $token);
        $request->session()->put('home_' . $token, $user->toArray());
        return $this->Success($user->toArray());
    }

    /**
     * api-Logout
     */
    public function logout()
    {

    }
}