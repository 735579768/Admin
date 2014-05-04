<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class MemberAttrController extends AdminController {
 function _initialize(){
   parent::_initialize();
 	$this->assign('meta_title','用户注册项管理');
 }
 public function index(){
	 $list=M('MemberAttr')->select();
	 $this->assign('_list',$list);
	 $this->display();
	 }
 public function add(){
	 if(IS_POST){
		 $model=D('MemberAttr');
		 if($model->create()){
			 $result=$model->add();
			 	 if($result!==false){
				 	$this->success('添加成功',U('MemberAttr/index'));
				 }else{
					$this->error('添加失败,未知错误');	 
					 }
			 }else{
			$this->error($model->geterror());	 
				 }
	  }else{
		 $this->display('edit');	 
			 }
	
	 }
 public function edit($id=null){
	 $model=D('MemberAttr');
	 if(IS_POST){
		 
		 if($model->create()){
			 $result=$model->save();
			 if($result!==false){
				 	$this->success('更新成功',U('MemberAttr/index'));
				 }else{
					$this->error('更新失败，未知错误');	 
					 }
			 
			 }else{
			$this->error($model->geterror());	 
				 }		 
		 }else{
		if(empty($id))$this->error('id不能为空');
		$data=M('MemberAttr')->where("id=$id")->find();
		$this->assign('data',$data);
		$this->display();	 
			 }
	 
	 }
public function del($id){
	$result=M('MemberAttr')->where("id=$id")->delete();
	 if($result!==false){
		$this->success('删除成功',U('MemberAttr/index'));
	 }else{
		$this->error('删除失败，未知错误');	 
		 }
	}
}
