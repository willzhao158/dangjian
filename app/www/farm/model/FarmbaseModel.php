<?php
namespace app\farm\model;

use think\Model;
use think\Db;
use app\farm\model\LayuiModel;
Class FarmbaseModel extends Model
{
	private $pagecount;

	public $table;


	public function datalist($islimit=true){
		$this->pagecount = Config('page_count');
		$name = input('name','');
		$type = input('type','');
		$where = ' 1=1 ';

		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }
		if($name){
			$where .= " and name like '%$name%' ";
		}
		if($type!=''){
			$where .= " and type=$type ";
		}

		if(!$islimit){
			$cycle = input('cycle');
			switch($cycle){
				case '1':
					//日
					$datetime = 'today';
					break;
				case '2':
					//周
					$datetime = 'last week';
					break;
				case '3':
					//月
					$datetime = 'month';
					break;
				case '4':
					//年
					$datetime = 'year';
					break;
				default:
					//全部数据
					$datetime = '';
					break;
			}
			$data = $cycle?$this->where($where)->whereTime('create_time', $datetime)->select()->toArray():$this->where($where)->select()->toArray();
			
			return $data;
		}
		$start = ((input('page',1))-1)*$this->pagecount;
		$count = $this->where($where)->count();
		$data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
		$sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
		return LayuiModel::layuiData($data,$count,$sql);
	} 	

	public function adddata($data){
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function editfielddata($data){
		$edit = $this->save($data['params'],$data['params']['id']);
		if(!$edit){
			return [false,$data];
		}
		return [true,$edit];
	}

	public function editdata($data){
		$result = $this->getdatainfo($data);
		if($data['sample']==''){
			unset($data['sample']);
		}
		$edit = $this->allowField(true)->save($data,$data['id']);
		if(!$edit){
			return [false,$data];
		}
		if(isset($data['sample'])){
			$this->deleteFile('./'.$result['sample']);
		}
		return [true,$data];
	}


	public function deldata($params){
		$this->delfile($params);
		return $this->where('id','in',$params['params'])->delete();
	}

	public function getdatainfo($params){
		return $this->find($params['id']);
	}

	protected function deleteFile($path){
        @unlink($path);
    }

    private function delfile($params){
    	$res['id'] = $params['params'];
    	$data = $this->getdatainfo($res);
    	switch($this->table){
    		case 'ny_device':
				$this->deleteFile('./'.$data['sample']);
    		break;
    	}
    }

	
}	