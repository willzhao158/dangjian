<?php
namespace app\farm\model;

use think\Model;
use app\farm\model\LayuiModel;

Class MachineryModel extends Model
{
	private $pagecount;

	public function machinerylist(){
		$this->pagecount = Config('page_count');
		$name = input('name','');
		$type = input('type',0);
		$where = ' 1=1 ';
		
		if($type){
			$where .= " and type=$type ";
		}

		if($name){
			$where = " and name like '%$name%' ";
		}

		$start = ((input('page',1))-1)*$this->pagecount;
		$count = $this->where($where)->count();
		$data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
		$sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
		return LayuiModel::layuiData($data,$count,$sql);
	} 	

	public function addmachinery($data){
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function editmachinery($data){
		$save = $this->allowField(true)->update($data['params']);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function delmachinery($params){
		return $this->where('id','in',$params['params'])->delete();
	}

	public function changemachineryclassify($params){
		$sql = "update ny_machinery set type={$params['type']} where id in({$params['id']})";
		return $this->query($sql);
	}

		
}


