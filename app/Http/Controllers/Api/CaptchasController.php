<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request,CaptchaBuilder $captchaBuilder){
        $key = "capacha_".Str::random(15);
        $captcha=$captchaBuilder->build();
        $expired_at = now()->addMinutes(2);
        Cache::put($key,['mobile'=>$request->mobile,'capachaCode'=>$captcha->getPhrase()],$expired_at);
        // 此处返回url
        return $this->response->array([
            "capacha_key"=>$key,
            "capacha_image_content"=>$captcha->inline(),
            "expired_at"=>$expired_at->toDateTimeString(),
        ]);
    }

}
