<?php


namespace App\Http\Controllers;


use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class WechatController
{
    public function index(){
        $cache = new RedisAdapter(app('redis')->connection()->client());
        Log::info("进入微信测试");
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->rebind('cache', $cache);
        dd($app->access_token->getToken());
        $app->server->push(function ($message){
            return "您好，徐小猪";
        });
        $response= $app->server->serve();

        return $response;
    }
}