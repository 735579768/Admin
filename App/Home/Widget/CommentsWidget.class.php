<?php
namespace Home\Widget;
use Think\Controller;
class CommentsWidget extends Controller {
	public function add(){
		$this->display('Widget:Comments');
		}
}