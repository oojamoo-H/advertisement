<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 13:02
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{


    protected $response = array(
        'code' => 1,
        'data' => array(),
        'msg'  => 'ok'
    );

    protected function Success($data = array()){
        $this->response['data'] = $data;
        return $this->response;
    }

    protected function Error($status, $msg){
        $this->response['code'] = $status;
        $this->response['msg'] = $msg;
        return $this->response;
    }
}