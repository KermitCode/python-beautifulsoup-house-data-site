<?php

//根路径定义
!defined('ROOT_PATH') && define('ROOT_PATH', dirname(dirname( __FILE__ )) );

//定义缓存路径(:包括图灵缓存等数据):及日志路径
define('CACHE_PATH', ROOT_PATH .DIRECTORY_SEPARATOR. 'cache'.DIRECTORY_SEPARATOR);
define('LOG_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR);

//基础处理：全局当前时间戳值和全局Y-m-d H:i:s格式时间值
date_default_timezone_set( 'PRC' );
header( "Content-type: text/html; charset=utf-8" );

//执行vendor_autoload
require_once ROOT_PATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

//执行结束异常捕获
register_shutdown_function(array('lib\Log', 'checkFinished'));

if (\Config::DEBUG){
    error_reporting(E_ALL);
    ini_set('display_errors','on');
}else{
    //error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT ^ E_DEPRECATED);
    error_reporting(E_ALL ^ E_NOTICE);
}


$WORK_SPEACE = CONTROLLER_SPEACE;

//Cli
if (PHP_SAPI == "cli") {
    $_REQUEST = $_SERVER['argv'];
    $_REQUEST['c']  = empty($_REQUEST[1]) ? 'index' : $_REQUEST[1];
    $_REQUEST['a']  = empty($_REQUEST[2]) ? 'index' : $_REQUEST[2];
    $WORK_SPEACE    = CRON_SPEACE;
}else{
    if (empty($_REQUEST['c']))
        $_REQUEST['c'] = 'drm';

    if (empty($_REQUEST['a']))
        $_REQUEST['a'] = 'index';
}

$class = ucfirst(strtolower($_REQUEST['c']));
$method     = strtolower($_REQUEST['a']);

if (in_array($class, \Config::$CONTROLLERS) ) {

    //the controller
    $class = $WORK_SPEACE.$class.CONTROLLER_SUFFIX;
    if(!class_exists($class)){
        echo "class not found! \n";
        exit();
    }
    $class = new $class();
    if (method_exists($class, $method) ) {
        $class->$method();

        if( isset($class->filter) && $class->filter) {
            $logFilter = LOG_PATH . 'php_filter.log';
            $logChar = PHP_EOL.date('Y-m-d H:i:s').PHP_EOL.var_export($class->_filterDataLog, true). PHP_EOL;
            file_put_contents($logFilter, $logChar . PHP_EOL, FILE_APPEND);
        }
    } else {
        echo "Action is empty! \n";
    }
}


