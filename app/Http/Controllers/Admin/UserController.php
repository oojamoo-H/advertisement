<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 14:09
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Model\UserAsset;
use App\Http\Model\UserAuth;
use Illuminate\Http\Request;
use DB;


class UserController extends BaseController
{
    public function index()
    {
        return view('admin.user');
    }

    /**
     * api - Get All Users
     * @param Request $request
     * @return array
     */
    public function getUserList(Request $request){
        $user_name = $request->input('username');
        $limit = $request->input('limit');
        $db = DB::table('users');
        $count = User::count();
        if (trim($user_name)){
            $db->where('users.username', 'like', "%{$user_name}%");
            $count = User::where('username', 'like', "%{$user_name}%")->count();
        }

        $result = $db->select(DB::raw(
            'pre_users.id, pre_users.username, pre_users.created_at, pre_user_assets.point, pre_users.is_active, pre_users.status, pre_user_auths.auth_code as code, pre_user_auths.expire_in as expire'))
            ->leftJoin('user_assets', 'users.id', '=', 'user_assets.user_id')
            ->leftJoin('user_auths', 'users.id', '=', 'user_auths.user_id')
            ->paginate($limit)->toArray();
        return array('code' => 0, 'msg' => 'ok', 'count' => $count, 'data' => $result['data']);
    }

    /**
     * api - Generate Auth Code
     * @param Request $request
     * @return array
     */
    public function generateCode(Request $request){
        if (! $user_id = $request->input('id')){
            return $this->Error(-1, 'Param Not Found');
        }
        $code = $this->checkCode(strtoupper(generate_user_auth_code()));

        if (! $user_auth = UserAuth::where('user_id', $user_id)->first()){
            $user_auth = new UserAuth();
            $user_auth->user_id = $user_id;
        }
        $user_auth->auth_code = $code;
        $user_auth->save();
        return $this->Success($code);
    }

    /**
     * api - Set User Point
     * @param Request $request
     * @return array
     */
    public function updatePoint(Request $request){
        $point = $request->input('point');
        $user_id = $request->input('id');

        if (trim($point) === ""){
            return $this->Error(-1, 'Param Not Found');
        }

        if (! $user_id){
            return $this->Error(-1, 'Param Not Found');
        }

        if (! $asset = UserAsset::where('user_id', $user_id)->first()){
            $asset = new UserAsset();
            $asset->user_id = $user_id;
        }

        $asset->point = $point;
        $asset->save();
        return $this->Success();
    }

    /**
     * func - Check for duplicate code to keep code unique
     * @param $code
     * @return string
     */
    protected function checkCode($code){
        if (UserAuth::where('auth_code', '=', $code)->first()){
            $code = strtoupper(generate_user_auth_code());
            $this->checkCode($code);
        } else {
            return $code;
        }
    }
}