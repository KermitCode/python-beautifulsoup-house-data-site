<?php

namespace lib;

class Controller {

    protected $request;

    public function __construct()
    {

    }

    public function index() {
        $name = get_class($this);
        echo "$name's index.\n";
    }

    public function setResponse($result) {
        
    }


    public function view($template,$data=false, $isReturn = false)
    {
        if (!empty($data) && is_array($data)) {
            extract($data, EXTR_OVERWRITE);
        }
        ob_start();

        $templatePath = VIEW_PATH.$template.'.php';
        if (file_exists($templatePath)) {
            include_once($templatePath);
        }
        if ( $isReturn === TRUE ) {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }
        ob_end_flush();
        exit;
    }


    // 生成签名
	public function createSign($key, array $data=array()){
    	ksort($data);
    	$r = http_build_query($data);
    	return md5(urldecode($r).$key);
    }
    
    //测试显示数据
    public function debug($data, $continue=false)
    {
        echo '<pre>';
        print_r($data);
        if(!$continue) exit;
    }

}
