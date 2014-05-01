<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {
    public function index(){
		$this->display();
    }
	public function updatefield($table,$id,$field,$value){
		$data=array(
			$field=>$value
		);
	$result=M($table)->where("id=$id")->save($data);
	if($result===false){
		$this->error('更新失败');	
		}else{
		$this->success('更新成功');
			}
	}
}