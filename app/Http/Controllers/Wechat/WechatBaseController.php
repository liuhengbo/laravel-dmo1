<?php


namespace App\Http\Controllers\Wechat;


use App\Http\Controllers\Controller;
use App\lib\helpers\RedisHelper;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Redis;

class WechatBaseController extends Controller
{
    protected $wechatApp;
    protected $redis;
    private $redisHelper;
    public function __construct()
    {
        $this->wechatApp = Factory::officialAccount(config('wechat.official_account.default'));
        Log::info("进入微信测试");
        // 替换缓存
        $cache = new RedisAdapter(app('redis')->connection('wechat')->client());
        $this->wechatApp->rebind('cache', $cache);
        // 连接redis
        $this->redisHelper = new RedisHelper();
        $this->redis = $this->redisHelper->getRedis(config('database.redis.default'));
    }
}