<?php
namespace Admin\Widget;
use Think\Controller;
class CustomFormWidget extends Controller {
	//云标签表单
    public function tag($name=null,$value=null){
		if(empty($name))return '参数传递出错';
		
		//查找系统标签
		$_list=M('tag')->order('id desc')->select();
		$data['name']=$name;
		$data['value']=$value;
		$this->assign('data',$data);
		$this->assign('_list',$_list);
        $this->display('Widget:CustomForm/tag');
	}
}