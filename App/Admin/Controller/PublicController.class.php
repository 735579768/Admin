<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	 /**
     * 后台控制器初始化
     */
    protected function _initialize(){

        /* 读取数据库中的配置 */
        $config =   S('DB_CONFIG_DATA');
       // trace($config);
        if(!$config){
            //$config =   api('Config/lists');
            S('DB_CONFIG_DATA',$config);
        }
        C($config); //添加配置
	}
    /**
     * 后台用户登录
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }
            $uid = D('member')->login($username, $password);
            //die($uid);
            if(0 < $uid){ //UC登录成功
                    $this->success('登录成功！', U('Index/index'));

            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
    
    /**
     * 清空系统缓存目录
     * **/
    public function clearCache(){
    	$rutimepath=$_SERVER['DOCUMENT_ROOT'].RUNTIME_PATH;
    	$arr=delAllFile($rutimepath);
        if(is_array($arr)){
          //统计缓存大小
          $siz=0;
          foreach ($arr as $a){
          	$siz+=$a['size'];
          }
          $this->success("缓存已经清理完成,共计 ".($siz/1000)." k",'',6);
        }
    }
}