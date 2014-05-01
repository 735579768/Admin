<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class MemberGroupController extends AdminController {
 function _initialize(){
   parent::_initialize();
 	$this->assign('meta_title','用户组管理');
 }
 function index(){
   $model=D('MemberGroup');
   $data=$model->select();
   $this->assign('_list',$data);
   $this->display();
 }
 function add(){
   $model=D('MemberGroup');
       //取表单数据
      if(IS_POST){
    	if($model->create()){
    	  $model->add();
    	  $this->success('添加成功',U('MemberGroup/index'));
    	}else{
    	  $this->error($model->getError());
    	}      	
      }else{
      	$this->display();
      }
 }
 function edit(){
   $model=D('MemberGroup');
   if(IS_POST){
     if($model->create()){
     	$model->save();
     	$this->success('更新成功',U('MemberGroup/index'));
     }else{
       $this->error($model->getError());  	
     }   	
   }else{
    $data=$model->find(I('get.id'));
 	$this->assign('data',$data);
    $this->display();   	
   }


 }
 function del($id=null){
   if($id=='22')$this->error('默认管理员组不能删除');
   if($gid=M('MemberGroup')->where('id='.$id)->delete()){
     $this->success('删除成功');
   }else{
     $this->error('删除失败');
   }
 	
 }
  function changestatus($id=null){
    $model=D('MemberGroup');
    $str=$model->changestatus($id);
    $this->success($str);
  }
  /**
   * 访问授权页面
   * @author 朱亚杰 <zhuyajie@topthink.net>
   */
  public function access(){

    $this->meta_title = '访问授权';
    $this->display('managergroup');
  }
}
