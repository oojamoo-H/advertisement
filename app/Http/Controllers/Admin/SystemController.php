<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/14
 * Time: 19:17
 */

namespace App\Http\Controllers\Admin;


use App\Http\Model\FriendlyLinks;
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

    public function systemSave(Request $request)
    {
        $param = $request->input();
        System::where('id', $param['id'])->update(array('value' => $param['value']));
    }

    public function saveAdminPassword(Request $request)
    {
        $id = $request->input('id');
        $password = trim($request->input('password'));

        if (!$id) {
            return $this->Error(-1, 'Id Not found');
        }

        if (!$password) {
            return $this->Error(-1, 'Password Not found');
        }

        UserAdmin::find($id)->update(array('password' => md5($password)));

        return $this->Success();
    }

    public function friendlyLinksSetting()
    {
        return view('admin.friendly-links');
    }

    public function getFriendlyLinksList(Request $request)
    {
        $status = $request->input('status');
        $limit = $request->input('limit');
        $query = FriendlyLinks::class;
        $count = $query::count();
        if ($status) {
            $query::where('status', '=', (int)$status);
            $count = FriendlyLinks::where('status', '=', (int)$status)->count();
        }

        $result = $query::paginate($limit)->toArray();
        return array('code' => 0, 'msg' => 'ok', 'count' => $count, 'data' => $result['data']);
    }

    public function friendlyLinkDetail(Request $request)
    {
        $id = $request->input('id');
        $link_detail = array();
        $id && $link_detail = FriendlyLinks::find($id)->toArray();

        return view('admin.friendly-links-detail', array('detail' => $link_detail));
    }

    public function saveFriendlyLink(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $is_url = $request->input('is_url');
        $url = $request->input('url');
        $content = $request->input('content');
        $status = $request->input('status');
        $sort = $request->input('sort');

        if($id){
            $model = FriendlyLinks::find($id);
        }else{
            $model = new FriendlyLinks();
        }
        $model->name = $name;
        $model->is_url = (int)$is_url;
        $model->url = $url ?: '';
        $model->content = $content ?: '';
        $model->status = (int)$status;
        $model->sort = (int)$sort;
        if($model->save()) {
            return $this->Success();
        }else{
            return $this->Error(-1,'system error');
        }
    }
}