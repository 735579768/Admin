<?php
namespace Admin\Controller;
use Think\Controller;
class MenuController extends AdminController {
    public function index(){
		$this->assign('meta_title','菜单列表');
        $tree = D('Menu')->getTree(0,'id,title,url,hide,sort,pid,group,status');
        $this->assign('tree', $tree);
		$this->display();
    }
    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function tree($tree = null){
      //  C('_SYS_GET_CATEGORY_TREE_') || $this->_empty();
        $this->assign('tree', $tree);
        $this->display('tree');
    }	
	    /**
     * 新增菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function add(){
        if(IS_POST){
            $Menu = D('Menu');
            $data = $Menu->create();
            if($data){
                $id = $Menu->add();
                if($id){
                    // S('DB_CONFIG_DATA',null);
                    //记录行为
                   // action_log('update_menu', 'Menu', $id, UID);
                    $this->success('新增成功',U('Menu/index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $this->assign('info',array('pid'=>I('pid')));
            $menus = M('Menu')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);
            $this->meta_title = '新增菜单';
            $this->display('edit');
        }
    }
    /**
     * 编辑配置
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Menu = D('Menu');
            $data = $Menu->create();
            if($data){
                if($Menu->save()!== false){
                    // S('DB_CONFIG_DATA',null);
                    //记录行为
                   // action_log('update_menu', 'Menu', $data['id'], UID);
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($Menu->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Menu')->field(true)->find($id);
            $menus = M('Menu')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus);

            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);
            if(false === $info){
                $this->error('获取后台菜单信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑后台菜单';
            $this->display();
        }
    }
    /**
     * 删除后台菜单
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public function del($id=null){
        $tem=M('menu')->where('pid='.$id)->find();
        if(is_array($tem)){
            $this->error('请删除子菜单后再操作');
        }else{
           $result=M('Menu')->where("id=$id")->delete();
        	if($result){
				$this->success('删除成功',U('Menu/index'));
				}else{
				$this->error('删除失败');	
					}
		}
    }
}