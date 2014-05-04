<?php
use Think\Exception;
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 寞枫 <735579768@.qq.com>
 */
function is_login(){
    $user = session('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
    }
}
/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 寞枫 <735579768@.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}
/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5');  调用Admin模块的User接口
 * @param  string  $name 格式 [模块名]/接口名/方法名
 * @param  array|string  $vars 参数
 */
function api($name,$vars=array()){
    $array     = explode('/',$name);
    $method    = array_pop($array);
    $classname = array_pop($array);
    $module    = $array? array_pop($array) : 'Common';
    $callback  = $module.'\\Api\\'.$classname.'Api::'.$method;
    if(is_string($vars)) {
        parse_str($vars,$vars);
    }
    return call_user_func_array($callback,$vars);
}
/**
  *系统用户密码加密算法
  */
function think_ucenter_md5($str, $key = 'adminrootkl'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}
/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 寞枫 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}
if(!function_exists('array_column')){
  function array_column(array $input, $columnKey, $indexKey = null) {
    $result = array();
    if (null === $indexKey) {
      if (null === $columnKey) {
        $result = array_values($input);
      } else {
        foreach ($input as $row) {
          $result[] = $row[$columnKey];
        }
      }
    } else {
      if (null === $columnKey) {
        foreach ($input as $row) {
          $result[$row[$indexKey]] = $row;
        }
      } else {
        foreach ($input as $row) {
          $result[$row[$indexKey]] = $row[$columnKey];
        }
      }
    }
    return $result;
  }
}
	 /**此方法用来删除某个文件夹下的所有文件
     *@param string $path为文件夹的绝对路径如d:/tem/
     *@param string $delself 是否把自己也删除,默认不删除
	   *@param string $delfolder 删除所有文件夹默认为true,
     *                           如果为false,则只删除所有目录中的文件
     *@返回值为 删除的文件数量(路径和大小)
     *清理缓存很实用,哈哈
     *@author qiaokeli <735579768@qq.com>  www.zhaokeli.com
     * */
function delAllFile($fpath,$delself=false,$delfolder=true) { 
    defined('YPATH') OR define('YPATH', $fpath);
    $files= array(); 
    $filepath = iconv('gb2312', 'utf-8', $fpath); 
    if (is_dir($fpath)) { 
        if ($dh = opendir($fpath)) { 
          while (($file = readdir($dh)) !== false) { 
            if($file != '.' && $file != '..') { 
            $temarr= delAllFile($fpath.'/'.$file);
            $files=array_merge($files,$temarr); 
            } 
          } 
        closedir($dh); 
        }
        if($delfolder){
          //过虑删除自己的情况
          if($fpath===YPATH){
            if($delself){
              $files[]=array('path'=>$fpath,'size'=>filesize($fpath));  
              @rmdir($fpath);
            }
          }else{
            $files[]=array('path'=>$fpath,'size'=>filesize($fpath));  
            @rmdir($fpath);            
          }
         }
    } else { 
        if(is_file($fpath)) { 
           $files[]=array('path'=>$fpath,'size'=>filesize($fpath)); 
            @unlink($fpath);
        } 
    } 
  return $files; 
} 

/**
 * 返回一个目录中的目录列表(只返回一级)
 * @param string $path
 * **/
function getDirList($dir){
	$dirArray[]=NULL;
	if (false != ($handle = opendir ( $dir ))) {
		$i=0;
		while ( false !== ($file = readdir ( $handle )) ) {
			//去掉"“.”、“..”以及带“.xxx”后缀的文件
			if ($file != "." && $file != ".."&&!strpos($file,".")) {
				$dirArray[$i]=$file;
				$i++;
			}
		}
		//关闭句柄
		closedir ( $handle );
	}
	return $dirArray;
}
/**
 * 系统钩子函数
 * @param $name 钩子名字
 * **/
function hook($name,$param=array())
{
  $map['status']=1;
  $map['mark']=$name;
  $map['status']=1;
  $rows=M('Hooks')->field('id,pluginid')->where($map)->find();
  if(!empty($rows)){
  	$pluginidarr=explode(',', $rows['pluginid']);
  }else{
    //钩子不存在
    //throw new \Exception("钩子$name不存在");
  	trace("钩子'{$name}'不存在或被禁用");
    return null;
  }
  //运行钩子上的插件列表
  $str='';
  if(!empty($pluginidarr)){
  foreach ($pluginidarr as $a){
    if(empty($a))continue;
    $model=M('addons')->where("id=$a")->find();
    if(!empty($model) && $model['status']==='1'){
    	$str.=runPluginMethod($model['mark'],'run',$param);
    }elseif($model['status']==='0'){  	
    	//removePluginFromHook($rows['id'], $a);
    	trace("插件:[名字]{$model['name']},[标识]{$model['mark']} 被禁用");
    }elseif(!empty($model['id'])){
      removePluginFromHook($rows['id'], $a);
      trace("插件id: $a 对应的插件不存在,已从钩子列表中移除");     
    }
  }
  }
  return $str;
}
  /*
   * 调用插件方法
   * @param string $name 插件名字
   * @param string $method 插件调用的方法
   * @param string $param一维数组传参数,返数组顺序传参
   * 返回方法的返回值
   * */
function runPluginMethod($name,$method,$param=array()){
    //包含插件目录
    require_once __ROOT__."/Plugins/$name/".$name.'Plugin.class.php';
    $str="\\Plugins\\$name\\".$name.'Plugin';
    $temobj=new $str();
    return call_user_func_array(array($temobj,$method),$param);
//     $temobj=new $str();
//     return $temobj->$method($param);
  }

/**
 * 获取图片
 * @param int $id
 * @param string $field
 * @return 完整的数据  或者  指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function getPicture($cover_id, $field = null){
    if(empty($cover_id)){
        return false;
    }
    $picture = M('Picture')->where(array('status'=>1))->getById($cover_id);
    return empty($field) ? $picture : $picture[$field];
}
/**
 * 获取文档封面图片
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据  或者  指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function get_cover($cover_id, $field = null){
    if(empty($cover_id)){
        return false;
    }
    $picture = M('Picture')->where(array('status'=>1))->getById($cover_id);
    return empty($field) ? $picture : $picture[$field];
}
/*
 * 生成插件url地址
 * @param string $name Test/set 插件和操作
 * @param string $param 数组参数
 * */
function UP($name=null,$param=array()){
    $a=explode('/', $name);
    $data=array(
    	'name'=>$a[0],
        'method'=>$a[1]
    );
    $data=array_merge($data,$param);
	return U('Addon/plugin',$data);
}

/*
 * 返回插件指定的配置项
 * @param $mark 插件的名字
 * @param $field 插件的配置项
 * */
function getPC($mark=null,$field=null){
	$model=M('Addons');
	$rows=$model->field("param")->where("mark='$mark'")->find();
	if(is_array($rows)){
		$arr=json_decode($rows['param']);
		foreach ($arr as $key=>$val){
			if($key==$field){
				return $val;
			}
		}
	}
	return  '';
}
/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}
/**
 * 获取文档模型信息
 * @param  integer $id    模型ID
 * @param  string  $field 模型字段
 * @return array
 */
function get_document_model($id = null, $field = null){
    static $list;

    /* 非法分类ID */
    if(!(is_numeric($id) || is_null($id))){
        return '';
    }

    /* 读取缓存数据 */
    if(empty($list)){
        $list = S('DOCUMENT_MODEL_LIST');
    }

    /* 获取模型名称 */
    if(empty($list)){
        $map   = array('status' => 1, 'extend' => 1);
        $model = M('Model')->where($map)->field(true)->select();
        foreach ($model as $value) {
            $list[$value['id']] = $value;
        }
        S('DOCUMENT_MODEL_LIST', $list); //更新缓存
    }

    /* 根据条件返回数据 */
    if(is_null($id)){
        return $list;
    } elseif(is_null($field)){
        return $list[$id];
    } else {
        return $list[$id][$field];
    }
}
/**
 *把分类转成导航链接
 */
 function cattonav($catarr){
	 foreach ($catarr as $key=>$value){
		 	$catarr[$key]['url']="cat/{$value['name']}";
		 }
		 return $catarr;
	 }
/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}
/**
  *返字符串转成数组
  */
 
function mbstringtoarray($str,$charset) {
    $strlen=mb_strlen($str);
    while($strlen){
        $array[]=mb_substr($str,0,1,$charset);
        $str=mb_substr($str,1,$strlen,$charset);
        $strlen=mb_strlen($str);
    }
    return $array;
}

function removeHtml($str, $start=0, $length, $charset="utf-8", $suffix=true){
	$str=strip_tags($str);
	return msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true);
}