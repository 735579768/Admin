<?php
namespace Admin\Controller;
use Think\Controller;
class CommentsController extends AdminController {
	public function _initialize(){
		parent::_initialize();
		$this->meta_title='评论列表';
		}
    public function index(){
		$this->pages('Comments');
		$this->display();
    }
	public function del($id=null){
		$result=M('Comments')->where("id=$id")->delete();
		if($result){
			$this->success('删除成功');
			}else{
			$this->error('删除失败');	
			}
		}
}