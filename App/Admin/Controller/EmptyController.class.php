<?php
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller {
    public  function _empty(){
    	header('HTTP/1.1 404 Not Found');
		header("status: 404 Not Found");
    	$this->display('Public:404');
    }
}