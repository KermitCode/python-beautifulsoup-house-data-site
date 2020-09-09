<?php

namespace app\model;
use lib\Model;

class NormalModel extends Model
{
    public $table = 'qd_house';

    public function getDataBetween($sdate, $edate)
    {
        return self::$source->querySql("select area_id,date,one_house_num,one_house_area,two_house_num,two_house_area ".
                                       "from qd_house where date >= '{$sdate}' and date <= '{$edate}' order by date asc,area_id asc");
    }
    

    //读取卡片配置的数据
    public function getArea()
    {
        $result = array();
        $rs = self::$source->querySql("select * from qd_area order by id asc");
        foreach($rs as $row)
        {
            $result[$row['id']] = $row['area'];
        }
        return $result;
    }

    //读取连接12个月的房产成交量
    public function getMonthStat($smonth, $emonth)
    {
        return self::$source->querySql("select area_id,SUBSTR(date,1,7) as ym ,sum(one_house_num) as one_house_num,sum(two_house_num) as two_house_num from qd_house where DATE_FORMAT(date, '%Y%m')<= {$smonth} and DATE_FORMAT(date, '%Y%m') >= {$emonth} group by area_id,ym");
    }

}
