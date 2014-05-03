<?php
namespace Admin\Controller;
use Think\Controller;
class HookController extends AdminController {
    public function index(){
      $this->pages('Hooks',null,null,null,'status asc');
	  $this->display();
    }
    public function add(){
      if(IS_POST){
      	$model=D('Hooks');
      	if($model->create()){
      		$model->add();
      		$this->success('添加成功',U('Hook/index'));
      	}else{
      		$this->error($model->getError());
      	}
      }else{
        $this->display();
      }
    	
    }

    /*
     * 禁用插件
     * */
    public function jinyong($id=null){
    	if(D('Hooks')->jinyong($id)){
    		$this->success('禁用成功');
    	}else{
    	  $this->error('操作失败');
    	}
    }
    /*
     * 启用插件
    * */
    public function qiyong($id=null){
        if(D('Hooks')->qiyong($id)){
    	  $this->success('启用成功');
    	}else{
    	  $this->error('操作失败');
    	}
    }
    /*
     * 管理插件
    * */
    public function manage($id=null){
    if(IS_POST){
        $model=D('Hooks');
//     	$data['name']=I('post.name');
//     	$data['descr']=I('post.descr');
//     	dump($data);
    	if($model->create()){
    		$model->save();
    		$this->success('保存成功');
    		exit();
    	}else{
    		$this->error('保存失败');
    	   exit();
    	}
    	//$result=M('Hooks')->where("id=$id")->save($data);

    }else{
    	$data=M('Hooks')->where("id=$id")->find();
        $this->assign('data',$data);
    }
     //查询已挂载插件列表
     $model=M('Hooks')->where("id=$id")->field('pluginid')->find();
     //$arr=explode('c', $model['pluginid']);
     $pluginlisted=array();
     //if(!empty($arr)){
     $map['id']=array('in',$model['pluginid']);
     //foreach ($arr as $val){
       $pluginlisted=M('Addons')->where($map)->select();
     //}
     //}
      //查询还没有挂载的插件列表
     $map=array();
     $map['status']=1;
     $pluginlist=M('Addons')->where($map)->select();
      $temarr=array();
      foreach ($pluginlist as $val){
      	$str=stripos($model['pluginid'],$val['id']);
      	if($str===false){
      		$temarr[]=$val;
      	}
      }
     $this->assign('pluginlist',$temarr);
     $this->assign('pluginlisted',$pluginlisted);
     $this->display();
    }
    /*
     * 保存插件列表字符串
     * */
    public function savepluginlist($id=null){
    	$result=M('Hooks')->where("id=$id")->save(array('pluginid'=>I('post.val')));
// echo M('Hooks')->getlastsql();
        if(!$result){
        	$this->error('保存数据失败');
        }
    }
    public function del($id=null){
    	$model=D('Hooks');
    	$rows=$model->where("id=$id")->find();
    	if(empty($rows['pluginid'])){
    		$model->where("id=$id")->delete();
    		$this->success('删除成功');
    	}else{
    		$this->error('钩子上面有插件挂载不能删除',U('Hook/manage?id='.$id));
    	}
    }
}