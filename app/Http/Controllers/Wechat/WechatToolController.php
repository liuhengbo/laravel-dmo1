<?php


namespace App\Http\Controllers\Wechat;

class WechatToolController extends WechatBaseController
{


    public function getTemporaryQrCode()
    {
        if($url=$this->redis->get('wechat_login_qr_code_url')){
            return $url;
        }
        //单位秒，生成有效期1天的二维码
        $result = $this->wechatApp->qrcode->temporary('login', 24 * 3600);
        $url = $this->wechatApp->qrcode->url(data_get($result, 'ticket'));
        if($url){
            $this->redis->set('wechat_login_qr_code_url',$url,24 * 3600);
        }
        return $url ?: '';
    }
}