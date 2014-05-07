<?php
namespace Home\Widget;
use Think\Controller;
class CommentsWidget extends Controller {
	public function add($id){
		$this->arc_id=$id;
		$this->display('Widget:Comments');
		}
}