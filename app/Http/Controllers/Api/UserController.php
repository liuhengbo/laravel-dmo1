<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function store(UserRequest $request){
        $verifyCodeKey=$request->verifyCodeKey;
        $verifyCodeData=Cache::get("$verifyCodeKey");
        // 422表示校验错误
        if(!$verifyCodeData){
            return $this->response->error("验证码已失效",422);
        }
        if(!hash_equals($request->verifyCode,(string)data_get($verifyCodeData,'verifyCode'))){
            return $this->response->error("验证码不正确",422);
        }
        // 验证码正确，清除验证码
        Cache::forget("$verifyCodeKey");

        return $this->response->created();
    }
}
