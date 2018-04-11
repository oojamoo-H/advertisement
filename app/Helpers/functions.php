<?php
/**
 * Created by PhpStorm.
 * User: huangchengwen
 * Date: 2018/4/10
 * Time: 15:50
 */

if (!function_exists('generate_user_auth_code')){
    function generate_user_auth_code($length = 6){
        return str_random($length);
    }
}
