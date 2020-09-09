<?php

/*
 * Date:2017-03-07
 */
namespace lib\util;
use Config;

class Params 
{
    public static $memory = array();

    //读取参数
    static function getRequestArg($name, $default = null, $int=false)
    {
        //提取参数
        $val = isset($_REQUEST[$name])? trim($_REQUEST[$name]) : null;
        
        //参数安全处理
        $val && $val = htmlspecialchars($val);
        
        //平台机型值处理
        if($name =='platf' && !in_array($val, self::$platfs)) $val = false;
        if($name =='mtype' && !in_array($val, self::$mtypes)) $val = false;

        //值处理及默认值修复
        $int && $val = intval($val);
        !$val && $val = $default;
        
        return $val;
    }
    

    static function dgmdate($timestamp) {
        
        $diffTime = $_SERVER['REQUEST_TIME'] - $timestamp;

        $days = floor($diffTime/86400);

        if( $days > 0 ) {
            return date('Y-m-d', $timestamp);
        }
        
        $hourTime = $diffTime % 86400;

        $hours = floor($hourTime/3600);

        if( $hours > 0  ) {
            return $hours . '小时之前';
        }

        $minTime = $hourTime%3600;

        $mins = floor($minTime/60);

        if( $mins > 0  ) {
            return $mins . '分钟之前';
        }

        $secs = $minTime%60;

        if( $secs >= 0 ) {
            return '1分钟之前';
        }

        return '1分钟之前';

    }

}
