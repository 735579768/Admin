<?php
namespace Home\Model;
use Think\Model;

/**
 * 用户模型
 * @author 寞枫 <zuojiazi@vip.qq.com>
 */

class CommentsModel extends Model {
    /* 用户模型自动验证 */
    protected $_validate = array(

        /* 验证标识符 */
		array('nickname', 'require', '昵称不能空', self::EXISTS_VALIDATE),
		array('email', 'require', '邮箱不能空', self::EXISTS_VALIDATE),
		array('email', 'email', '邮箱格式不对', self::EXISTS_VALIDATE),
		array('url', 'url', '地址格式不对', self::EXISTS_VALIDATE),
        array('content', 'require', '评论内容不能空', self::EXISTS_VALIDATE),
    );
   protected $_auto = array ( 
         array('status','1'),  // 新增的时候把status字段设置为1
         array('create_time','time',1,'function'), // 写入当前时间戳
		 array('ip', 'get_client_ip', self::MODEL_INSERT, 'function', 0),
     );
 
}
