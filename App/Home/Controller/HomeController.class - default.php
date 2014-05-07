<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
		 /**
     * 前台台控制器初始化
     */
    protected function _initialize(){

        /* 读取数据库中的配置 */
        $config =   S('DB_CONFIG_DATA');
       // trace($config);
        if(!$config){
            //$config =   api('Config/lists');
            S('DB_CONFIG_DATA',$config);
        }
        C($config); //添加配置
	}
}