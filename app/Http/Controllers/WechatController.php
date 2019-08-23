<?php


namespace App\Http\Controllers;


use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;

class WechatController
{
    public function index(){
        Log::info("进入微信测试");
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->server->push(function ($message){
            return "您好，徐小猪";
        });
        $response= $app->server->serve();

        return $response;
    }
}