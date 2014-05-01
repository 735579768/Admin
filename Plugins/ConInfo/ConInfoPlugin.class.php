<?php
namespace  Plugins\ConInfo;
require_once __ROOT__.'/Plugins/Plugin.class.php';
class ConInfoPlugin extends \Plugins\Plugin{
	protected   $config=array(
            		'version'=>'1.0',
            	    'author'=>'qiaokeli',
            	    'name'=>'系统内容信息',
            	    'descr'=>'插件描述'
            	 );
	//插件默认的调用方法
	public function run(){
		//取系统分类个数
		$data['catnum']=M('Category')->count();
		//取系统文档个数
		$data['documentnum']=M('Document')->where("status>0")->count();
		//取系统禁用文档个数
		$data['disabledocumentnum']=M('Document')->where("status<0")->count();
		//取系统用户个数
		$data['usernum']=M('Member')->where("status>0")->count();
		//取系统禁用用户个数
		$data['disableusernum']=M('Member')->where("status<0")->count();
		$this->assign('data',$data);
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