<?php
namespace app\farm\model;

use think\Model;
use app\farm\model\LayuiModel;

Class RoleModel extends Model
{
	private $pagecount;

	public function rolelist(){
		$this->pagecount = Config('page_count');
		$name = input('name','');
		$where = '1=1';
		if($name){
			$where = ['name'=>['like','%'.$name.'%']];
		}
		$start = ((input('page',1))-1)*$this->pagecount;
		$count = $this->where($where)->count();
		$data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
		$sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
		return LayuiModel::layuiData($data,$count,$sql);
	} 	

	public function addrole($data){
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function editrole($data){
		$save = $this->allowField(true)->update($data['params']);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function delrole($params){
		return $this->where(['id'=>['in',$params['params']]])->delete();
	}


	

}