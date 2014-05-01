<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	protected function _empty(){
		//后台统一的404页面
			$this->display('Public:404');
		}

	 protected function _initialize(){
		 // 获取当前用户ID
        define('UID',is_login());
		 if(!UID)$this->redirect('Public/login');
         if(UID==='22'){
            define('IS_ROOT', true);
        }else{
             define('IS_ROOT', false);
        }
		//先读取缓存配置
        $config =   S('DB_CONFIG_DATA');
        if(!$config){
			/* 读取数据库中的配置 */
            $config =   api('Config/lists');
			//写入缓存
            S('DB_CONFIG_DATA',$config);
        }
        C($config); //添加配置
       // trace($this->_getMenu());
        $this->assign('__MENU__',$this->_getMenu());
	 }
     protected  function _getMenu($controller=CONTROLLER_NAME){
       //默认当前主菜单
       $this->assign('curmainmenu',U('Index/index'));
       $__MENU__=array();
     	$model=M('Menu')->where('pid=0 and hide=0')->order('sort asc')->select();
        $__MENU__['main']=$model;
        //查询当前的子菜单
        //高亮请求菜单
        $current = M('Menu')->where("url like '%{$controller}/".ACTION_NAME."%'")->field('id,pid,url')->find();
        if(!empty($current)){
        	//如果能查到请求的菜单
          if($current['pid']==0)
        	{
        	  //当前操作的是主菜单链接
        	  //查询子菜单分组
        	  $groups = M('Menu')->where("hide=0 and pid = {$current['id']}")->distinct(true)->field("`group`")->order('sort asc')->select();
        	  if($groups){
        	    $groups = array_column($groups, 'group');
        	  }else{
        	    $groups =   array();
        	  }
        	  //查询子菜单
        	  $child=M('Menu')->where('hide=0 and pid='.$current['id'])->order('sort asc,`group` desc')->select();
        	  //trace($child);
        	  $__MENU__['child']=$child;
        	  $__MENU__['groups']=$groups;
        	  $this->assign('curmainmenu',U($current['url']));
        	  $this->assign('curchildmenu',U($child[0]['url']));
        	}
        	else
        	{
        	  //当前操作是子菜单链接
        	  //查自己的父类
        	  $mainmenu=M('Menu')->where("id={$current['pid']}")->find();
        	  //查找自己出级的子类
        	  $child=M('Menu')->where('hide=0 and pid='.$current['pid'])->order('`group` desc,sort asc')->select();
        	  //查询子类分组
        	  $groups = M('Menu')->where("pid = {$current['pid']}")->distinct(true)->field("`group`")->order('sort asc')->select();
        	  if($groups){
        	    $groups = array_column($groups, 'group');
        	  }else{
        	    $groups =   array();
        	  }
        	  $__MENU__['child']=$child;
        	  $__MENU__['groups']=$groups;
        	  $this->assign('curmainmenu',U($mainmenu['url']));
        	  $this->assign('curchildmenu',U($current['url']));	
        	}
        }
        else
        {
          //如果查不到请求的菜单
        	//处理.....
        }
        return $__MENU__;
     }
     /**
      * 通用分页列表数据集获取方法
      *
      *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
      *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
      */
     protected function pages ($model,$where=null,$join=null,$field=null,$order=null,$rows=10){
       $User = M($model); // 实例化User对象
       $count=0;
       if(is_array($join)){
         $count      = $User->where($where)->join($join[0])->join($join[1])->count();// 查询满足要求的总记录数
       }else{
         $count      = $User->where($where)->join($join)->count();// 查询满足要求的总记录数
       }
     
       $Page       = new \Think\Page($count,$rows);// 实例化分页类 传入总记录数和每页显示的记录数(25)
       //$Page->url=$pageurl;
       $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
       $show       = $Page->show();// 分页显示输出
       // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
       if(is_array($join)){
         $list = $User->where($where)->field($field)->order($order)->join($join[0])->join($join[1])->limit($Page->firstRow.','.$Page->listRows)->select();
       }else{
         $list = $User->where($where)->field($field)->join($join)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
       }
     
       $this->assign('_total',$count);
       $this->assign('_page',$show);// 赋值分页输出
       $this->assign('_list', $list);
     }
     /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param array        $base    基本的查询条件
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model,$where=array(),$order='',$base = array('status'=>array('egt',0)),$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){
            $model  =   M($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
            if($val===''||$val===null){
                return false;
            }else{
                return true;
            }
        });
        if( empty($options['where'])){
            unset($options['where']);
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new \Think\Page($total, $listRows, $REQUEST);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;

        $model->setProperty('options',$options);

        return $model->field($field)->select();
    }
}