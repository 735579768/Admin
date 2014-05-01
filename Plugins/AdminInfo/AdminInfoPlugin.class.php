<?php
namespace  Plugins\AdminInfo;
require_once __ROOT__.'/Plugins/Plugin.class.php';
class AdminInfoPlugin extends \Plugins\Plugin{
	protected   $config=array(
            		'version'=>'1.0',
            	    'author'=>'qiaokeli',
            	    'name'=>'系统信息',
            	    'descr'=>'插件描述'
            	 );
	//插件默认的调用方法
	public function run(){
	   $this->display('content');	
	}
    
	public function getConfig(){
		return $this->config;
	}
    public  function install(){
		return true;
	}
	public function uninstall(){
	 return  true;	
	}
	public function set(){
		return true;
	}
}