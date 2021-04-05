<?php
namespace app\farm\model;
use think\Db;
Class CropModel extends FarmbaseModel
{
	public function cropkind(){
		return $this->where(['parent_id'=>0])->select();
	}

	private function cropchild(){
		return $this->where('parent_id','neq',0)->select()->toArray();
	}

	public function datalist($islimit = true){
		$kind = $this->cropkind();
		$child = $this->cropchild();
		foreach ($kind as $key=>$value){
			$array = [];
			foreach($child as $v){
				if($v['parent_id'] == $value['id']){
					$array[] = $v;
				}
			}
			$kind[$key]['child'] = $array;
		}
		return $kind;
	}

	public function checkChild($data){
		return $this->where(['parent_id'=>$data['params']])->find();
	}

	public function growthList($crop_id){
		return DB::name('crop_growth')->where(['crop_id'=>$crop_id])->select()->toArray();
	}


}