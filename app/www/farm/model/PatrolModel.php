<?php
namespace app\farm\model;
use think\Db;
Class PatrolModel extends FarmbaseModel
{
	public $result = '';
	public function handle_data($data){
        $detail = [];
        foreach($data as $k=>$v){
            if(is_array($v)){
                $detail[$k] = $v;
                unset($data[$k]);
            }
        }
        $array = [];
        $j = 0;
        $keys = array_keys($detail);
        $count = count($detail[$keys[0]]);
        for($i=0;$i<$count;$i++){
            $arr = [];
            foreach($keys as $value){
                $arr[$value] = $detail[$value][$i];
            }
            $array[] = $arr;
        }
        $this->result =  array(
        	'patrol' => $data,
        	'patrol_detail' => $array
        );
        return $this->result;
    }
	
    public function addpatrol($data){
    	$res = $this->handle_data($data);
    	$patrolId = DB::name('patrol')->insertGetId($res['patrol']);
    	if($patrolId){
    		foreach($res['patrol_detail'] as $k=>$v){
    			$res['patrol_detail'][$k]['patrol_id'] = $patrolId;
    		}
    		$patrolDetail = DB::name('patrol_detail')->insertAll($res['patrol_detail']);
    	}
    	return $patrolId;
    }

    public function editpatrol($data){
    	$res = $this->handle_data($data);
        $id = $res['patrol']['id'];

    	$patrolId = DB::name('patrol')->where(['id'=>$id])->update($res['patrol']);
    	$patrolId = $this->save($res['patrol'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($patrolId){
    		foreach($res['patrol_detail'] as $k=>$v){
    			$res['patrol_detail'][$k]['patrol_id'] = $res['patrol']['id'];
    		}
    		$patrolDetail = DB::name('patrol_detail')->insertAll($res['patrol_detail']);
            if($patrolDetail){
                DB::name('patrol_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $patrolId;
    }

    public function getOldDetail($id){
        $detail = DB::name('patrol_detail')->field('id')->where(['patrol_id'=>$id])->select()->toArray();
        $array = [];
        foreach($detail as $value){
            foreach($value as $v){
                $array[] = $v;
            }
        }
        $array = implode(',',$array);
        return $array;
    }


    public function getdatainfo($params){
		return [$this->find($params['id'])->toArray(),DB::name('patrol_detail')->where(['patrol_id'=>$params['id']])->select()->toArray()];
	}

    public function getpatrolDetail($params){
        return DB::name('patrol_detail')->where(['patrol_id'=>$params['params']])->select();
    }

}