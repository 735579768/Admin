<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 用户模型
 * @author 寞枫 <zuojiazi@vip.qq.com>
 */

class AddonsModel extends Model {
    /* 用户模型自动验证 */
    protected $_validate = array(

        /* 验证标识符 */
        array('mark', 'require', '标识符不能空', self::EXISTS_VALIDATE), //用户名长度不合法
        array('mark', 4,30, '标识符长度不合法', self::EXISTS_VALIDATE, 'length'), //用户名禁止注册
        array('mark', '', '标识符被占用', self::EXISTS_VALIDATE, 'unique'), //手机号被占用
    );
   /*
     * 禁用插件
     * */
    public function jinyong($id=null){
      $data['status']=0;
      $data['id']=$id;
      if($this->save($data)){
        return true;
      }else{
        return false;
      }  
    }
    /*
     * 启用插件
    * */
    public function qiyong($id=null){
      $data['status']=1;
      $data['id']=$id;
      if($this->save($data)){
        return true;
      }else{
        return false;
      }   	
    }
    /*
     * 安装插件
    * */
    public function install($mark=null){
    	
    }
    /*
     * 卸载插件
    * */
    public function uninstall($id=null){
    	
    }
}
