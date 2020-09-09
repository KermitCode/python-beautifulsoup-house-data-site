<?php
!defined('ROOT_PATH') && define('ROOT_PATH', dirname(dirname( __FILE__ )) );
define('APP_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR);
define('LIB_PATH', ROOT_PATH.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR);
define('MOD_PATH', APP_PATH.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR);
define('DB_PATH',  LIB_PATH.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR);
define('VIEW_PATH',APP_PATH.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR);

define('LIB','\lib\\');
define('CONTROLLER_SPEACE','\app\controller\\');
define('MODEL_SPEACE','\app\model\\');
define('CRON_SPEACE','\app\cron\\');
define('MODEL_SUFFIX', 'Model');
define('CONTROLLER_SUFFIX', 'Controller');

// Config class
class Config {

    //上线时，调整DEBUG = false
    const DEBUG          = false;

    //图片地址前缀
    const PREFIX_URL = 'http://house.04007.cn/images/';

    //allow apps;
    public static $CONTROLLERS = array('Interface','Index');

    /**************  MYSQL 配置 ********/
    //默认的数据库
    public static $_MYSQL = array(
        //默认连接此配置：读库配置:支持多库配置:不要加key
        'default'=>array(
            array('h'=>'127.0.0.1', 'u'=>'', 'pa'=>'', 'd'=>'04007CN', 'po'  => 3306),
            ),
        //写库配置：可支持配多个，但写库一般只会有一个库:不要加key
        'writedb'=>array(
            array('h'=>'127.0.0.1', 'u'=>'', 'p'=>'', 'd'=>'04007CN'),
            ),
    );

    /**************  以下是 redis 配置 ********/
    public static $_REDIS = array(
        'cache01'=>array('host' => '127.0.0.1', 'port' => 6379, 'auth'=>''),
        
    );
}
