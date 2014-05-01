<?php
namespace  Plugins\Comments;
require_once __ROOT__.'/Plugins/Plugin.class.php';
class CommentsPlugin extends \Plugins\Plugin{
	protected   $config=array(
            		'version'=>'1.0',
            	    'author'=>'qiaokeli',
            	    'name'=>'留言插件',
            	    'descr'=>'留言'
            	 );
	//插件默认的调用方法
	public function run(){
	   $this->display('content');	
	}
   
    public  function install(){
		return true;
	}
	public function uninstall(){
		return true;
	}
	public function set(){
		return true;
	}
}