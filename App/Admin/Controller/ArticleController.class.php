<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Page;

/**
 * 后台内容控制器
 * @author huajie <banhuajie@163.com>
 */
class ArticleController extends AdminController {
   private  $fields=array();
	/* 保存允许访问的公共方法 */
	static protected $allow = array( 'draftbox','mydocument');

    private $cate_id        =   null; //文档分类id
	//取菜单
	function _initialize(){
		parent::_initialize();
		 //获取分类id
        $cate_id        =   I('param.cate_id');
        $this->cate_id  =   $cate_id;
		
		$this->assign('cate_id',    $this->cate_id);
		$this->assign('tree',D('Category')->gettree());
		 //获取面包屑信息
        $nav = get_parent_category($cate_id);

        $this->assign('rightNav',   $nav);
		}
    /**
     * 分类文档列表页
     * @param $cate_id 分类id
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    public function index($cate_id = null){

        if($cate_id===null){
            $cate_id = $this->cate_id;
        }

        //获取模型信息
        $model = M('Model')->getByName('document');


        //$grids  = preg_split('/[;\r\n]+/s', );
        $grids=$this->getgrids($model['list_grid']);



        //获取对应分类下的模型
        if(!empty($cate_id)){   //没有权限则不查询数据
            //获取分类绑定的模型
            $models         =   get_category($cate_id, 'model');
            $mod = M('Model')->getById($models);
            //使用扩展文档的list_grids显示列表
            $grids=$this->getgrids($mod['list_grid']);

            $allow_reply    =   get_category($cate_id, 'reply');//分类文档允许回复
            $pid            =   I('pid');
            if ( $pid==0 ) {
                //开发者可根据分类绑定的模型,按需定制分类文档列表
                $template = $this->indexOfArticle( $cate_id,$mod); //转入默认文档列表方法
                $this->assign('model',  explode(',',$models));
            }else{
                //开发者可根据父文档的模型类型,按需定制子文档列表
                $doc_model = M('Document')->where(array('id'=>$pid))->find();

                switch($doc_model['model_id']){
                    default:
                        if($doc_model['type']==2 && $allow_reply){
                            $this->assign('model',  array(2));
                            $template = $this->indexOfReply( $cate_id ); //转入子文档列表方法
                        }else{
                            $this->assign('model',  explode(',',$models));
                            $template = $this->indexOfArticle( $cate_id ); //转入默认文档列表方法
                        }
                }
            }

            $this->assign('list_grids', $grids);
            $this->assign('model_list', $model);
            $this->display($template);
        }else{
            $this->error('非法的文档分类');
        }
    }
/**
  *返回模型的grids数组
  */
      protected function getgrids($list_grid){
        //解析列表规则
        // trace($list_grid);
        $fields = array();
        $grids  = preg_split('/[;\r\n]+/s', $list_grid);
       
        foreach ($grids as &$value) {
          // 字段:标题:链接
          $val      = explode(':', $value);
          // 支持多个字段显示
          $field   = explode(',', $val[0]);
         // trace($val);
          $value    = array('field' => $field, 'title' => $val[1]);
          if(isset($val[2])){
            // 链接信息
            $value['href']  =   $val[2];
            // 搜索链接信息中的字段信息
            preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
          }
          if(strpos($val[1],'|')){
            // 显示格式定义
            list($value['title'],$value['format'])    =   explode('|',$val[1]);
          }
          foreach($field as $val){
            $array  =   explode('|',$val);
            $fields[] = $array[0];
          }
        }
        // 过滤重复字段信息 TODO: 传入到查询方法
        $fields = array_unique($fields);
        return $grids;
      }  
    /**
     * 默认文档回复列表方法
     * @param $cate_id 分类id
     * @author huajie <banhuajie@163.com>
     */
    protected function indexOfReply($cate_id) {
        /* 查询条件初始化 */
        if(UID!=1)$map['uid'] = UID;
        $map = array();
        if(isset($_GET['content'])){
            $map['content']  = array('like', '%'.(string)I('content').'%');
        }
        if(isset($_GET['status'])){
            $map['status'] = I('status');
            $status = $map['status'];
        }else{
            $status = null;
            $map['status'] = array('in', '0,1,2');
        }
        if ( !isset($_GET['pid']) ) {
            $map['pid']    = 0;
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['username']) ) {
            $map['uid'] = M('UcenterMember')->where(array('username'=>I('username')))->getField('id');
        }

        // 构建列表数据
        $Document = M('Document');
        $map['category_id'] =   $cate_id;
        $map['pid']         =   I('pid',0);
        if($map['pid']){ // 子文档列表忽略分类
            unset($map['category_id']);
        }

        $prefix   = C('DB_PREFIX');
        $l_table  = $prefix.('document');
        $r_table  = $prefix.('document_article');
        $list     = M() ->table( $l_table.' l' )
                       ->where( $map )
                       ->order( 'l.id DESC')
                       ->join ( $r_table.' r ON l.id=r.id' );
        $_REQUEST = array();
        $list = $this->lists($list,null,"update_time desc",null,'l.id id,l.pid pid,l.category_id,l.title title,l.update_time update_time,l.uid uid,l.status status,r.content content' );
        int_to_string($list);

        if($map['pid']){
            // 获取上级文档
            $article    =   $Document->field('id,title,type')->find($map['pid']);
            $this->assign('article',$article);
        }
        //检查该分类是否允许发布内容
        $allow_publish  =   get_category($cate_id, 'allow_publish');

		$this->assign('cate_id', $cate_id);
        $this->assign('status', $status);
        $this->assign('list',   $list);
        $this->assign('allow',  $allow_publish);
        $this->assign('pid',    $map['pid']);
        $this->meta_title = '子文档列表';
        return 'reply';//默认回复列表模板
    }
    /**
     * 默认文档列表方法
     * @param $cate_id 分类id
     * @author huajie <banhuajie@163.com>
     */
    protected function indexOfArticle($cate_id=null,$model=NULL){
        /* 查询条件初始化 */
        $map = array();
        if(UID!=1)$map['uid'] = UID;
        if(isset($_GET['title'])){
            $map['title']  = array('like', '%'.(string)I('title').'%');
        }
        if(isset($_GET['status'])){
            $map['status'] = I('status');
            $status = $map['status'];
        }else{
            $status = null;
            $map['status'] = array('in', '0,1,2');
        }
        if ( !isset($_GET['pid']) ) {
            $map['pid']    = 0;
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['nickname']) ) {
            $map['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
        }

        // 构建列表数据
        //$Document = M('Document');
        $map['category_id'] =   $cate_id;
        $map['pid']         =   I('pid',0);
        if($map['pid']){ // 子文档列表忽略分类
            unset($map['category_id']);
        }
        if($model!=null){
        	$modeltable=$model['name'];
        	$join="kl_document_$modeltable as a on a.id=kl_document.id";
        }

        //$list = $this->lists($Document,$map,'level DESC,id DESC');
        $list = $this->pages('Document',$map,$join);
//         int_to_string($list);
        if($map['pid']){
            // 获取上级文档
            $article    =   $Document->field('id,title,type')->find($map['pid']);
            $this->assign('article',$article);
        }
        //检查该分类是否允许发布内容
        $allow_publish  =   get_category($cate_id, 'allow_publish');

        $this->assign('status', $status);
        $this->assign('list',   $list);
        $this->assign('allow',  $allow_publish);
        $this->assign('pid',    $map['pid']);

        $this->meta_title = '文档列表';
        return 'index';
    }

    // /**
    //  * 设置一条或者多条数据的状态
    //  * @author huajie <banhuajie@163.com>
    //  */
    // public function setStatus($model='Document'){
    //     return parent::setStatus('Document');
    // }

    /**
     * 文档新增页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function add(){


        $cate_id    =   I('get.cate_id',0);
        $model_id   =   I('get.model_id',0);

        empty($cate_id) && $this->error('参数不能为空！');
        empty($model_id) && $this->error('该分类未绑定模型！');

        //检查该分类是否允许发布
        $allow_publish = D('Document')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($model_id);

        //处理结果
        $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
        $info['model_id']       =   $model_id;
        $info['category_id']    =   $cate_id;
        if($info['pid']){
            // 获取上级文档
            $article            =   M('Document')->field('id,title,type')->find($info['pid']);
            $this->assign('article',$article);
        }

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('info',       $info);
        $this->assign('fields',     $fields);
        $this->assign('type_list',  get_type_bycate($cate_id));
        $this->assign('model',      $model);
        $this->meta_title = '新增'.$model['title'];
        $this->display();
    }

    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    public function edit(){


        $id     =   I('get.id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }

        /*获取一条记录的详细数据*/
        $Document = D('Document');
        $data = $Document->detail($id);
        if(!$data){
            $this->error($Document->getError());
        }

        if($data['pid']){
            // 获取上级文档
            $article        =   M('Document')->field('id,title,type')->find($data['pid']);
            $this->assign('article',$article);
        }
        $this->assign('data', $data);
        $this->assign('model_id', $data['model_id']);

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($data['model_id']);
        $this->assign('model',      $model);

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('fields',     $fields);


        //获取当前分类的文档类型
       // $this->assign('type_list', get_type_bycate($data['category_id']));

        $this->meta_title   =   '编辑文档';
        $this->display();
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    public function update(){
        $res = D('Document')->update();
        if(!$res){
            $this->error(D('Document')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功',U('Article/index?cate_id='.I('post.category_id')));
        }
    }

    /**
     * 批量操作
     * @author huajie <banhuajie@163.com>
     */
    public function batchOperate(){


        $pid = I('pid', 0);
        $cate_id = I('cate_id');

        empty($cate_id) && $this->error('参数不能为空！');

        //检查该分类是否允许发布
        $allow_publish = D('Document')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        //批量导入目录
        if(IS_POST){
            $model_id = I('model_id');
            $type = 1;	//TODO:目前只支持目录，要动态获取
            $content = I('content');
            $_POST['content'] = '';	//重置内容
            preg_match_all('/[^\r]+/', $content, $matchs);	//获取每一个目录的数据
            $list = $matchs[0];
            foreach ($list as $value){
                if(!empty($value) && (strpos($value, '|') !== false)){
                    //过滤换行回车并分割
                    $data = explode('|', str_replace(array("\r", "\r\n", "\n"), '', $value));
                    //构造新增的数据
                    $data = array('name'=>$data[0], 'title'=>$data[1], 'category_id'=>$cate_id, 'model_id'=>$model_id);
                    $data['description'] = '';
                    $data['pid'] = $pid;
                    $data['type'] = $type;
                    //构造post数据用于自动验证
                    $_POST = $data;

                    $res = D('Document')->update($data);
                }
            }
            if($res){
                $this->success('批量导入成功！', U('index?pid='.$pid.'&cate_id='.$cate_id));
            }else{
                if(isset($res)){
                    $this->error(D('Document')->getError());
                }else{
                    $this->error('批量导入失败，请检查内容格式！');
                }
            }
        }

        $this->assign('pid',        $pid);
        $this->assign('cate_id',	$cate_id);
        $this->assign('type_list',  get_type_bycate($cate_id));

        $this->meta_title       =   '批量导入';
        $this->display('batchoperate');
    }


    /**
     * 禁用列表
     */
    public function examine(){


        $map['status']  =   0;

        $list = $this->lists(M('Document'),$map,'update_time desc');
        // //处理列表数据
        // if(is_array($list)){
        //     foreach ($list as $k=>&$v){
        //         $v['username']      =   get_nickname($v['uid']);
        //     }
        // }

        $this->assign('list', $list);
        $this->meta_title       =   '禁用文档';
        $this->display();
    }

    /**
     * 回收站列表
     * @author huajie <banhuajie@163.com>
     */
    public function recycle(){


        $map['status']  =   -1;
//         if ( !IS_ROOT ) {
//             $cate_auth  =   AuthGroupModel::getAuthCategories(UID);
//             if($cate_auth){
//                 $map['category_id']    =   array('IN',$cate_auth);
//             }else{
//                 $map['category_id']    =   -1;
//             }
//         }
        $list = $this->lists(M('Document'),$map,'update_time desc');

        //处理列表数据
        if(is_array($list)){
            foreach ($list as $k=>&$v){
                $v['username']      =   get_username($v['uid']);
            }
        }

        $this->assign('list', $list);
        $this->meta_title       =   '回收站';
        $this->display();
    }

    /**
     * 写文章时自动保存至草稿箱
     * @author huajie <banhuajie@163.com>
     */
    public function autoSave(){
        $res = D('Document')->autoSave();
        if($res !== false){
            $return['data']     =   $res;
            $return['info']     =   '保存草稿成功';
            $return['status']   =   1;
            $this->ajaxReturn($return);
        }else{
            $this->error('保存草稿失败：'.D('Document')->getError());
        }
    }

    /**
     * 草稿箱
     * @author huajie <banhuajie@163.com>
     */
    public function draftBox(){


        $Document   =   D('Document');
        $map        =   array('status'=>3,'uid'=>UID);
        $list       =   $this->lists($Document,$map);
        //获取状态文字
        //int_to_string($list);

        $this->assign('list', $list);
        $this->meta_title = '草稿箱';
        $this->display();
    }

    /**
     * 我的文档
     * @author huajie <banhuajie@163.com>
     */
    public function mydocument($status = null, $title = null){


        $Document   =   D('Document');
        /* 查询条件初始化 */
        if(UID!=1)$map['uid'] = UID;
        if(isset($title)){
            $map['title']   =   array('like', '%'.$title.'%');
        }
        if(isset($status)){
            $map['status']  =   $status;
        }else{
            $map['status']  =   array('in', '0,1,2');
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        //只查询pid为0的文章
       // $map['pid'] = 0;
        $list = $this->lists($Document,$map,'update_time desc');
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->meta_title = '我的文档';
        $this->display();
    }

    /**
     * 还原被删除的数据
     * @author huajie <banhuajie@163.com>
     */
    public function permit(){
        /*参数过滤*/
        $ids = I('param.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }

        /*拼接参数并修改状态*/
        $Model  =   'Document';
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', $ids);
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        $this->restore($Model,$map);
    }

    /**
     * 清空回收站
     * @author huajie <banhuajie@163.com>
     */
    public function clear(){
        $res = D('Document')->remove();
        if($res !== false){
            $this->success('清空回收站成功！');
        }else{
            $this->error('清空回收站失败！');
        }
    }

    /**
     * 移动文档
     * @author huajie <banhuajie@163.com>
     */
    public function move() {
        if(empty($_POST['id'])) {
            $this->error('请选择要移动的文档！');
        }
        session('moveArticle', $_POST['ids']);
        session('copyArticle', null);
        $this->success('请选择要移动到的分类！');
    }
    //设置文档状态
    public function setStatus($id=null,$status=null){
        if(empty($id))$this->error('文档id不能为空');
        if(!is_numeric($status))$this->error('文档状态错误');
        $map=array('id'=>array('in',$id));

        $result=M('Document')->where($map)->save(array('status'=>$status));
        if($result!==false){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
	//添加文章标签
	public function addtag($title=null){
		$reinfo=array(
		      'info'=>'',
              'status'=>0,
              'tagid'=>0,
              'title'=>$title,
              'url'=>'',
              'norefresh'=>1
		);
        if(!empty($title)){
            $model=M('tag')->where("title='$title'")->find();
            if(empty($model)){
                    $id=M('tag')->add(array('title'=>$title));
                    if($id>0){
                        $reinfo['tagid']=$id;
                        $reinfo['status']=1;
                        $reinfo['info']='添加成功';
                    }else{
                        $reinfo['info']='添加标签失败';
                    }
             }else{
                $reinfo['info']='此标签已经存在';
             }
        }else{
            $reinfo['info']='标题不能为空';
        }
        echo json_encode($reinfo);
        exit();
		}
}
