<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Logic;

/**
 * 文档模型子模型 - 商品模型
 */
class GoodsLogic extends BaseLogic{
	/* 自动验证规则 */
	protected $_validate = array(
		array('goodsdescr', 'getgoodsdescr', '商品详情不能为空！', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array();

	/**
	 * 新增或添加一条商品详情
	 * @param  number $id 商品ID
	 * @return boolean    true-操作成功，false-操作失败
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function update($id = 0){
		/* 获取商品数据 */
		$data = $this->create();
		if($data === false){
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){//新增数据
			$data['id'] = $id;
			$id = $this->add($data);
			if(!$id){
				$this->error = '新增详细内容失败！';
				return false;
			}
		} else { //更新数据
			$status = $this->save($data);
			if(false === $status){
				$this->error = '更新详细内容失败！';
				return false;
			}
		}

		return true;
	}

	/**
	 * 获取商品的详细内容
	 * @return boolean
	 * @author huajie <banhuajie@163.com>
	 */
	protected function getgoodsdescr(){
		$type = I('post.type');
		$goodsdescr = I('post.goodsdescr');
		if($type > 1){	//主题和段落必须有内容
			if(empty($goodsdescr)){
				return false;
			}
		}else{			//目录没内容则生成空字符串
			if(empty($goodsdescr)){
				$_POST['goodsdescr'] = ' ';
			}
		}
		return true;
	}

	/**
	 * 保存为草稿
	 * @return true 成功， false 保存出错
	 * @author huajie <banhuajie@163.com>
	 */
	public function autoSave($id = 0){
		$this->_validate = array();

		/* 获取商品数据 */
		$data = $this->create();
		if(!$data){
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){//新增数据
			$data['id'] = $id;
			$id = $this->add($data);
			if(!$id){
				$this->error = '新增详细内容失败！';
				return false;
			}
		} else { //更新数据
			$status = $this->save($data);
			if(false === $status){
				$this->error = '更新详细内容失败！';
				return false;
			}
		}

		return true;
	}

}
