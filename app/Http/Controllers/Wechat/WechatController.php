<?php


namespace App\Http\Controllers\Wechat;


use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class WechatController extends WechatBaseController
{
    public function index(){

        $this->wechatApp->server->push(function ($message){
            return "您好，徐小猪";
        });
        $response= $this->wechatApp->server->serve();

        return $response;
    }
}