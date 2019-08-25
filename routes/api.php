<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//
//Route::namespace('Wechat')->prefix('wechat')->group(function (){
//    Route::any('/', 'WechatController@index');
//    Route::any('/qrcode/temporary', 'WechatToolController@getTemporaryQrCode');
//});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace'=>'App\Http\Controllers\Api'
],function ($api){
    // 限流  每分钟
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 60,
        'expires' => 1,
    ],function ($api){
        // 发送短信验证码
        $api->post('verifyCode','VerifyCodeController@store')
            ->name('api.verifyCode.store');
        // 用户注册
        $api->post('user','UserController@store')
            ->name('api.user.store');
        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
    });

});

$api->version('v2',function ($api){
    $api->get('version',function (){
        return response('v2');
    });
});



