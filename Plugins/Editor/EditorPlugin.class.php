<?php
namespace  Plugins\Editor;
use Think\Upload;
require_once __ROOT__.'/Plugins/Plugin.class.php';
class EditorPlugin extends \Plugins\Plugin{
	public $uploader = null;
	protected   $config=array(
            		'version'=>'4.1.7',
            	    'author'=>'qiaokeli',
            	    'name'=>'HTML编辑器',
            	    'descr'=>'Editor'
            	 );
	//插件默认的调用方法
	/*
	*@param $name 表单名字
	*@param $content 表单内容
	*/
	public function run($name=null,$content=null,$edittype=null){
	if(empty($name))$name='content';
	  //编辑器类型
	if($edittype==null){
		 $edittype=getPC('Editor','edittype');
	}
	 $edittype=$edittype?$edittype:1;
	 $this->assign('type',$edittype);
	  $this->assign('name',$name);
	  $this->assign('content',$content);
	  $this->display('content');	
	}
	public function getConfig(){
		return $this->config;
	}
    public  function install(){

      $data=array(
      	 'title'=>'Editor插件',
         'pid'=>124,
         'url'=>'Addon/Plugin?name=Editor&method=set', 
         'group'=>'已安装插件',
         'type'=>'Editor'    
      );
       if(M('Menu')->add($data)){
       	return true;
       }else{
       	return false;
       }
	}
	public function uninstall(){
	$map['type']='Editor'; 
	  if(M('Menu')->where($map)->delete()){
	  	return true;
	  }else{
	  	return false;
	  }
	}



	/* 上传图片 */
	public function upload(){
		session('upload_error', null);
		/* 上传配置 */
		$setting = C('EDITOR_UPLOAD');

		/* 调用文件上传组件上传文件 */
		$this->uploader = new Upload($setting, 'Local');
		$info   = $this->uploader->upload($_FILES);
		if($info){
			$url = C('EDITOR_UPLOAD.rootPath').$info['imgFile']['savepath'].$info['imgFile']['savename'];
			$url = str_replace('./', '/', $url);
			$info['fullpath'] = __ROOT__.$url;
		}
		session('upload_error', $this->uploader->getError());
		return $info;
	}

	//keditor编辑器上传图片处理
	public function ke_upimg(){
		/* 返回标准数据 */
		$return  = array('error' => 0, 'info' => '上传成功', 'data' => '');
		$img = $this->upload();
		/* 记录附件信息 */
		if($img){
			$return['url'] = $img['fullpath'];
			unset($return['info'], $return['data']);
		} else {
			$return['error'] = 1;
			$return['message']   = session('upload_error');
		}

		/* 返回JSON数据 */
		exit(json_encode($return));
	}
	//ueditor编辑器上传图片处理
	public function ue_upimg(){

		$img = $this->upload();
		$return = array();
		$return['url'] = $img['fullpath'];
		$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
		$return['title'] = $title;
		$return['original'] = $img['imgFile']['name'];
		$return['state'] = ($img)? 'SUCCESS' : session('upload_error');
		/* 返回JSON数据 */
		exit(json_encode($return));
		// $this->ajaxReturn($return);
	}
	public function set(){
	    if(IS_POST){
	      $data=array(
	      	'edittype'=>I('post.edittype'),
	      );
 	      $model=M('Addons');
         $model->where("mark='Editor'")->save(array('param'=>json_encode($data)));	  	
	    }
	    $data=M('Addons')->field('param')->where("mark='Editor'")->find();
	    $this->assign('info',json_decode($data['param'],true));
	    $str=$this->fetch('config');
        return $str;
	}

}