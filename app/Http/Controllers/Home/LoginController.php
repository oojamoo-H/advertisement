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
    public function login(Request $request){
        $username = $request->input('input');
        $password = $request->input('password');

        if (! User::where(array('username' => $username, 'password' => md5($password), 'is_active' => 1))){
            return $this->Error(-1, 'Please Register First');
        }
    }

    /**
     * api-Logout
     */
    public function logout(){}
}