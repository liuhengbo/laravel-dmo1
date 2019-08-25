<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerifyCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;


class VerifyCodeController extends Controller
{

    private $validPeriod = 10;

    public function store(VerifyCodeRequest $request,EasySms $easySms){
        $mobile = $request->mobile;
        // 生成4位随机数
        $verifyCode=str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);

        if(config('easysms.debug_send_sms')){
            // 本地调试模式不发短信
            $verifyCode=1234;
        }else{
            // 线上或发短息模式
            try{
                $easySms->send($mobile,[
                    'content'=>"【刘恒博test】您的验证码是{$verifyCode}。有效期为{$this->validPeriod}分钟，请尽快验证",
                ]);
            }catch (NoGatewayAvailableException $exception){
                $message=$exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message?:'短信发送异常');
            }
        }
        $key = 'verifyCode_'.Str::random(15);
        // 过期时间
        $expired_at = now()->addMinute($this->validPeriod);
        // 存入缓存
        Cache::put($key,['mobile'=>$mobile,'verifyCode'=>$verifyCode],$expired_at);
        return $this->response->array([
            'key'=>"$key",
            'expired_at'=>$expired_at->toDateTimeString()
        ])->setStatusCode(201);
    }
}
