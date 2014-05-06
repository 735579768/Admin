<?php
namespace Admin\Model;
use Think\Model;

/**
 * 用户模型
 * @author 寞枫 <zuojiazi@vip.qq.com>
 */

class MemberAttrModel extends Model {
    /* 用户模型自动验证 */
    protected $_validate = array(

        /* 验证标识符 */
		array('attr_title', 'require', '标题不能空', self::EXISTS_VALIDATE),
        array('attr_name', 'require', '表单名称不能空', self::EXISTS_VALIDATE),
		array('attr_type', 'require', '表单类型不能空', self::EXISTS_VALIDATE),
		array('group_id', 'require', '所属用户组不能空', self::EXISTS_VALIDATE),
//        array('mark', 4,30, '标识符长度不合法', self::EXISTS_VALIDATE, 'length'), //用户名禁止注册
        array('attr_name', '', '标识符被占用', self::EXISTS_VALIDATE, 'unique'), //表单名字被占用
		array('attr_title','','标题不能空', self::EXISTS_VALIDATE,'unique'),
    );
 
}
