<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends AdminController {
    public function index(){
		$map['status']=array('gt',0);
    	$this->pages('Member',$map);
		$this->display();
    }
    public function recycling(){
		$map['status']=array('lt',0);
    	$this->pages('Member',$map);
		$this->display();
    }
    public function add($groupid='',$username = '', $password = '', $repassword = '', $email = ''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User   = D('Member');
            $uid    =   $User->register($groupid,$username, $password, $email);
            if(0 < $uid){ //注册成功
              $this->success('添加用户成功',U('Member/index'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            //查询用户组
            $tem=D('MemberGroup')->select();
            $this->assign('list',$tem);
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatepwd(){
        $this->meta_title = '修改密码';
        $this->display();
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

         $uid=$this->login(UID, $password,4);
         ($uid == -2) && $this->error('原密码不正确');
         $Member =   D('Member');
         $data=$Member->create($data);
        $res = $Member->where(array('id'=>$uid))->save($data);
        if($res){
            $this->success('修改密码成功！请重新登陆!',U('Public/logout'));
        }else{
            $this->error('修改失败');
        }
    }
	    function login($username, $password,$type=4){

        return D('Member')->login($username, $password,$type);
    }
	    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在5-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }
	    function del($id){
        $id=I('get.id');
        if($id=='1')$this->error('超级管理员不能删除');
        $uid=M('Member')->where("id=$id")->save(array('status'=>-1));        
      if(0<$uid){
      	$this->success('已经移到回收站',U('Member/recycling'));
      }else{
      	$this->error('操作失败');
      }
    }
    function dele(){
    	$id=I('get.id');
    	$uid=M('Member')->where("id=$id")->delete();
    	if(0<$uid){
    	  $this->success('已经彻底删除');
    	}else{
    	  $this->error('操作失败');
    	}
    }
	function huifu(){
      $id=I('get.id');
      if($id=='1')$this->error('超级管理员不能删除');
      $uid=M('Member')->where("id=$id")->save(array('status'=>1));
      if(0<$uid){
        $this->success('已经成功恢复',U('Member/index'));
      }else{
        $this->error('操作失败');
      }
    }
}