<?php


namespace App\lib\helpers;


use Redis;

class RedisHelper
{
    // redis对象
    private static $redis = null;
    // redis配置
    private $redisConfig;
    // 连接redis
    private function connect(){
        self::$redis = new Redis();
        self::$redis->connect(data_get($this->redisConfig,'host'),data_get($this->redisConfig,'port'));
        self::$redis->auth('');
        self::$redis->select(data_get($this->redisConfig,'database'));
    }

    /**
     * 获取redis对象
     * @param array $redisConfig
     * @return null
     */
    public  function getRedis(array $redisConfig){
        if(self::$redis){
            return self::$redis;
        }else{
            $this->redisConfig = $redisConfig;
            $this->connect();
            return self::$redis;
        }
    }





}