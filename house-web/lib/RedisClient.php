<?php

namespace lib;
use Config;
use Redis;
use Flexihash\Flexihash;
use lib\Log;

class RedisClient
{
    //过期时间（秒）
    //每次设置过期时间时最好向前后随机偏移几分钟，见setExpire方法
    private $_expire = 3600;    //25 * 60
    private $_timeout = 5000;   //超时时间
    
    //REDIS连接信息
    private $_serverInfo = null;
    private $_configid   = null;
    private $_currentServer = null;

    //实例化标识
    private $_type;
    private $hash;
    private static $uid = null;
    private static $_source = array();
    private static $fix_read_redis = null;
    private static $fix_card_read_redis = null;
 
    //连接资源标识
    private static $_clients = array();
    public static $_records = array();

    //禁止直接使用new实例化此类
    private function __construct(){}
   
    public static function getInstance($type=0, $uid=null)
    {
        //已实例化直接返回
        if(isset(self::$_source[$type])) return self::$_source[$type];
        if(self::$uid === null) self::$uid = $uid;
        switch($type)
        {
            case 0:$config = Config::$_WL_REDIS;break; 
            case 1:$config = Config::$_DT_REDIS;break; 
            case 2:$config = Config::$_FIX_REDIS;          
                   if(self::$fix_read_redis === null) self::$fix_read_redis = rand(0, count($config)-1);
                   break;
            case 3:$config = Config::$_FIX_WRITE_REDIS;break; 

            case 4:$config = Config::$_FIX_CARD_REDIS;        
                   if(self::$fix_card_read_redis === null) self::$fix_card_read_redis = rand(0, count($config)-1);
                   break;
            case 5:$config = Config::$_FIX_CARD_WRITE_REDIS;break; 
        }
        
        $redis = new RedisClient();
        $redis->_serverInfo = $config;
        $redis->hash = new Flexihash();
        $redis->hash->addTargets( array_keys($redis->_serverInfo) );
        $redis->_type = $type;
        
        return self::$_source[$type] = $redis;
    }

    //实现REDIS的set方法
    public function set($k, $v, $expire=null, $continue=false)
    {
        $exp = $expire===null?$this->_expire:$expire;
        $redis = $this->_conn($k);
        $ttl = $redis->ttl($k);
        if($ttl >1  && $continue)
        {
            $exp = $ttl;
        }
        $redis->setex($k, $exp, $v);
        return true;
    }
    
    //实现REDIS的del方法
    public function del($k)
    {
        $redis = $this->_conn($k);
        return $redis->del($k);
    }
    
    //连接服务器
    private function _conn($key)
    {
        //调试状态记录redis的操作次数
        if(Config::DEBUG)
        {
            $records =  debug_backtrace();
            $records = $records[1];
            foreach($records['args'] as $key=>$value)
            {
                if(is_array($value)) $records['args'][$key]=implode(',', $value);
            }
            self::$_records[$this->_type][$records['function']][] = implode(' ',$records['args']);
        }

        //读取连接第几个REDIS
        $id = $configid = $this->_getServerId($key);
        $this->_configid = $id;

        $id = $this->_type.'_'.$id;
        if (!isset(self::$_clients[$id]) || !(self::$_clients[$id] instanceof Redis))
        {
            self::$_clients[$id] = new Redis();
        }

        if (!isset(self::$_clients[$id]->socket) || !is_resource(self::$_clients[$id]->socket))
        {
            $server = $this->_serverInfo[$configid];
            $this->_currentServer = $server;

            $rs = self::$_clients[$id]->pconnect($server['host'], $server['port'], $this->_timeout);
            if(!$rs) Log::error("connect redis:{$server['host']}:{$server['port']}-failed");
            if(!empty($server['auth']))
            {
                $rs = self::$_clients[$id]->auth($server['auth']);
                if(!$rs) Log::error("redis auth password:{$server['host']}:{$server['port']}-failed");
            }
        }

        return self::$_clients[$id];
    }
    
    //决定连接第几个REDIS
    private function _getServerId($key)
    {
        //根据当前请求的REDIS类型返回连接第几个REDIS
        $Flexihash = new Flexihash();
        switch($this->_type)
        {
            case 0:
            case 1:
                if(isset($this->hash->idCache) && $this->hash->idCache)
                {
                    $id = $this->hash->idCache;
                }else{
                    $id = $this->hash->lookup(self::$uid);
                    $this->hash->idCache = $id;
                } 
                break; 
            case 2:$id = self::$fix_read_redis;break;        
            case 3:$id = 0;break;                            
            case 4:$id = self::$fix_card_read_redis;break;  
            case 5:$id = 0;                                 
        }
        return $id;
    }
    
    //测试显示资源
    public function showStatic()
    {
        echo '-------------source-------------------------<pre>';
        print_r(self::$_source);
        echo '-------------fix_read_redis-------------------------<pre>';
        print_r(self::$fix_read_redis);
        echo '-------------clients-------------------------<pre>';
        print_r(self::$_clients);
    }
    
    //值过期设置
    public function setExpire($seconds = null)
    {
        $seconds = intval($seconds);
        if ($seconds > 0) {
            $this->_expire = $seconds;
        } else {
            $h = date('H');
            if ($h < 2 || $h > 19) {
                $this->_expire = 60 * 60 + rand(0, 15 * 60); // 晚间高峰期增加缓存时间
            } elseif($h > 2 && $h < 12) {
                $this->_expire = 15 * 60 + rand(0, 5 * 60);  // 低谷期减少缓存时间
            } else {
                $this->_expire = 15 * 60 + rand(0, 10 * 60);
            }
		
            //测试环境时不开启REDIS缓存
            //if(defined("IN_TEST_MODE") && IN_TEST_MODE) $this->_expire = 1;
        }
    }
    
    //读取值
    public function get($k)
    {
        $redis = $this->_conn($k);
        return $redis->get($k);
    }
    
    //读取队列
    public function lrange($k, $left, $length)
    {
        $redis = $this->_conn($k);
        return $redis->lrange($k, $left, $length);
    }
    
    //读取hash中的key
    public function hGet($h, $k)
    {
        $redis = $this->_conn($h);
        return $redis->hget($h, $k);
    }

    //hash读所有
    public function hGetall($h)
    {
        $redis = $this->_conn($h);
        $rtn = $redis->hgetall($h);
        return $rtn?$rtn:array();
    }
    
    //批量读取REDIS数据:$keys为数组，以一个key计算redis存储位置
    public function mget($keys)
    {
        if(!$keys) return array();
        $redis = $this->_conn(current($keys));
        $rtn = $redis->mget($keys);
        return $rtn?$rtn:array();
    }
    
    //批量设置REDIS数据:$data为数组，$key=>$values
    public function mset($data, $expire=0)
    {
        $redis = $this->_conn(key($data));
        $rtn = $redis->mset($data);

        //循环设置过期时间
        if($expire)
        {
            foreach($data as $k=>$v)
            {
                $redis->expire($k, $expire);
            }
        }
        return $rtn?$rtn:array();
    }
    
    //设置hash的值
    public function hSet($h, $k, $v, $expire=0)
    {
        $expire = $expire?$expire:$this->_expire;
        try {
            $redis = $this->_conn($h);
            $redis->hSet($h, $k, $v);
            if ($redis->ttl($h) < 0)
            {
                $redis->expire($h, $expire);
            }
            return true;
        } catch (Exception $e) {
            // pass
        }
        return false;
    }
    
    //给值设置过期时间
    public function expire($key ,$expire=0)
    {
        $expire = $expire?$expire:$this->_expire;
        $redis = $this->_conn($key);
        return $redis->expire($key, $expire);
    }
    
    //hash批量设置值
    public function hMSet($h, $arr, $expire=0)
    {
        $expire = $expire?$expire:$this->_expire;
        $redis = $this->_conn($h);
        if ($redis->hMSet($h, $arr))
        {
            if ($redis->ttl($h) < 0) $redis->expire($h, $expire);
            return true;
        }
        return false;
    }
    
    //取得集合数据
    public function smembers($key)
    {
        if(!$key) return array();
        $redis = $this->_conn($key);
        $rtn = $redis->smembers($key);
        return $rtn?$rtn:array();
    }
    
    //向集合添加数据
    public function sadd($k, $v, $expire=null)
    {
        $exp = $expire===null?$this->_expire:$expire;
        $redis = $this->_conn($k);
        $redis->sadd($k, $v);
        return $redis->expire($k, $exp);
    }
    
    
    //////////////////////////////////////////////////////////////

    public function exists($key) {
        try {
            $redis = $this->_conn($key);
            return $redis->exists($key);
        } catch (Exception $e) {
            // pass
        }
        return false;
    }

    
    
    public function hSetHasExpire($h,$k,$v,$expire=null) {
        try {
            $redis = $this->_conn($h);
            $redis->hset($h,$k,$v);
            if (intval($expire) > 0 && $redis->ttl($h) < 0) {
                $redis->expire($h, intval($expire));
            }
            return true;
        } catch (Exception $e) {
            // pass
        }
        return false;
    }

    

    public function hMGet($h, $arr, $db_name='rough') {
        $rtn = array();
        try {
            $redis = $this->_conn($h, $db_name);
            $rtn = $redis->hMGet($h, $arr);
        } catch (Exception $e) {
            // pass
        }
        return $rtn;
    }
    
    public function hExists($h,$k,$db_name='rough') {
        try {
            $redis = $this->_conn($h);
            return $redis->hexists($h, $k);
        } catch (Exception $e) {
        }
        return 0;
    }
    
    public function hIncrBy($h,$k,$count=1,$db_name='rough') {
        try {
            $redis = $this->_conn($h);
            return $redis->hincrby($h, $k, $count);
        } catch (Exception $e) {
        }
        return false;
    }

    

    public function setex($k, $ttl, $v, $db_name='exact') {
        $rtn = false;
        try {
            $redis = $this->_conn($k, $db_name);
            if ($ttl <= 0) {
                $ttl = $this->getExpire();
            }
            $rtn = $redis->setex($k, $ttl, $v);
        } catch (Exception $e) {
            // pass
        }
        return $rtn;
    }


####
    public function getServerInfo() {
        return array('all_server' => $this->_serverInfo, 'current_server' => $this->_currentServer, 'id' => $this->_configid); 
    }

}
