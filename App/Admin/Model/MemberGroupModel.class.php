<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 图片模型
 * 负责图片的上传
 */

class MemberGroupModel extends Model{
  /* 自动验证规则 */
  protected $_validate = array(
  	array('title','require','标题不能为空',self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
     array('title', '', '标题已经被占用', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
  );
    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('groupid',2,self::MODEL_INSERT),
        array('status', 1, self::MODEL_INSERT),
    );
    function changestatus($id=null){
    	$data=$this->find($id);
    	if($data['status']=='1'){
    		$data['status']=0;
    	}else{
    		$data['status']=1;
    	}
    	$this->where("id=$id")->save($data);
    	return '操作成功';
    }
}
