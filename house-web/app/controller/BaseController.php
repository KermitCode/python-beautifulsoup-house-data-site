<?php

/*
 * Note:基类控制器
 * Author:Kermit
 * Date:2017-04-27
 */

namespace app\controller;

use \lib\Controller;
use lib\util\Params;
use app\model\NormalModel;
use Config;
use lib\Log;

abstract class BaseController extends Controller
{

    //核心参数属性值
    public $sdate, $edate; 

    //所有接口实例化的时候加载好参数并进行过滤
    public function __construct()
    {
        $this->initBaseParams();

        $this->NormalModel = new NormalModel();
    }


    //初始化必传参数:
    private function initBaseParams()
    {
        //基本参数:
        $this->sdate = Params::getRequestArg('sdate');
        $this->edate = Params::getRequestArg('edate');
        
        //基本月参数
        $this->smonth =  date('Ym');
        $this->emonth = date("Ym", strtotime("-1 year")); 

        if(!$this->sdate || !$this->edate)
        {
            $this->edate = date('Y-m-d');
            $this->sdate = date('Y-m-d', strtotime('-31days'));
        }
    }

}
