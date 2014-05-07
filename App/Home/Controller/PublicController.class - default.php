<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends HomeController {
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
}