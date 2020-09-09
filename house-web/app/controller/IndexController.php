<?php

/*
 * Note:首页控制器
 * Author:Kermit
 * Date:2017-04-27
 */

namespace app\controller;

use \app\model\CardModel;
use Config;
use lib\Log;

class IndexController extends BaseController
{
    //show house number and areas image
    public function month()
    {
        #取得区域
        $area = $this->NormalModel->getArea();
        #$this->edate = date('Y-m-d');
        #$this->sdate = date('Y-m-d', strtotime('-31days'));
        $data = $this->NormalModel->getDataBetween($this->sdate, $this->edate); 
        $date = $one =$two = array();
        foreach($data as $key=>$row)
        {
            $date[] = substr($row['date'], -5);
            $one[$row['area_id']][] = $row['one_house_num'];
            $two[$row['area_id']][] = $row['two_house_num'];
        }
        $result = array(
                        'area'=>$area,
                        'date'=>array_values(array_unique($date)),
                        'one'=>$one,
                        'two'=>$two,
                       );
        if(isset($_GET['callbackparam']) && $_GET['callbackparam'])
        {
            echo $_GET['callbackparam']."(".json_encode($result).")";
        }else{
            echo json_encode($result);
        }
        #$this->debug($result);
    }
    
    public function index()
    {
    
       $this->view('index'); 

    }

    public function statmonth()
    {
        $area = $this->NormalModel->getArea(); 
        $data = $this->NormalModel->getMonthStat($this->smonth, $this->emonth);
        $date = $one =$two = array();
        foreach($data as $key=>$row)
        {   
            $date[] = $row['ym'];
            $one[$row['area_id']][] = $row['one_house_num'];
            $two[$row['area_id']][] = $row['two_house_num'];
        }   
        $result = array(
                        'area'=>$area,
                        'date'=>array_values(array_unique($date)),
                        'one'=>$one,
                        'two'=>$two,
                       ); 
        #$this->debug($result);
        if(isset($_GET['callbackparam']) && $_GET['callbackparam'])
        {
            echo $_GET['callbackparam']."(".json_encode($result).")";
        }else{
            echo json_encode($result);
        }
    }

}



