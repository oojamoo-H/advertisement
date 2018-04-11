<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 12:56
 */

namespace App\Http\Controllers\Home;

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
        $this->response['status'] = $status;
        $this->response['msg'] = $msg;
        return $this->response;
    }
}