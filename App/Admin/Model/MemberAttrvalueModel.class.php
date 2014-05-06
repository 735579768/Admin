<?php
namespace Admin\Model;
use Think\Model;

/**
 * 用户模型
 * @author 寞枫 <zuojiazi@vip.qq.com>
 */

class MemberAttrvalueModel extends Model {

//取用户信息
//返回用户信息数组
public function getMemberInfo($member_id=null){		
			//查找用户组id
			$row=M('Member')->where("id=$member_id")->find();
			$group_id=$row['groupid'];
			
			//查找用户组的表单项列表
			$fieldlist=M('MemberAttr')->field(true)->where("group_id=$group_id")->select();
				
			//查找表单对应的值
			$model=M('MemberAttrvalue');
			foreach($fieldlist as $key=>$val){
				$map['attr_id']=$val['id'];
				$map['member_id']=$member_id;
				$row2=$model->where($map)->field('attr_value')->find();
				$fieldlist[$key]['attr_value']=$row2['attr_value'];
				}
				return $fieldlist;
	} 
//更新用户信息
//@param  $field 一个用户字段数组格式为$field[0],$field[1],...$field['attr_id']
//@param  $member_id 用户id
public function updateMemberInfo($member_id=null){
			$msg=array(
				'info'=>'更新成功',
				'status'=>1
			);
			$fields=$this->userinfotoarray();
			$model=M('MemberAttrvalue');
			//更新字段状态
			$fieldbool=true;
			foreach($fields as $key=>$val){
				//查找有没有这个表单值
				$map['member_id']=$member_id;
				//$map['attr_name']=$key;
				$map['attr_id']=$key;
				$temrow=$model->where($map)->find();
				
				if(empty($temrow)){
					//添加
					$map['attr_value']=$val;
					$fieldbool=$model->add($map);
					
					if($fieldbool===false){
						$msg['info']='添加字段时出错';
						$msg['status']=0;
						}
					}else{
					//更新
					$mapp['member_id']=$member_id;
					$mapp['attr_id']=$key;
					$fieldbool=$model->where($mapp)->save(array('attr_value'=>$val));	
					if($fieldbool===false){
						$msg['info']='更新字段时出错';
						$msg['status']=0;	
						}
						}
				
				}
		return $msg;
	}
	/**
	 *把post过来的用户信息转换成数组
	 */
	private function userinfotoarray(){
		//取post值
		$data=I('post.');
		
		$data2=array();
		foreach ($data as $key => $value) {
			$tem=explode('_', $key);
			if(is_numeric($tem[1])){
			$data2[$tem[1]]=$value;
			}
		}
		return $data2;
	}
}
