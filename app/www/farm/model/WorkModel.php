<?php
namespace app\farm\model;
use think\Db;
Class WorkModel extends FarmbaseModel
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
        	'work' => $data,
        	'work_detail' => $array
        );
        return $this->result;
    }
	
    public function addwork($data){
    	$res = $this->handle_data($data);
    	$workId = DB::name('work')->insertGetId($res['work']);
    	if($workId){
    		foreach($res['work_detail'] as $k=>$v){
    			$res['work_detail'][$k]['work_id'] = $workId;
    		}
    		$workDetail = DB::name('work_detail')->insertAll($res['work_detail']);
    	}
    	return $workId;
    }

    public function editwork($data){
    	$res = $this->handle_data($data);
        $id = $res['work']['id'];

    	$workId = DB::name('work')->where(['id'=>$id])->update($res['work']);
    	$workId = $this->save($res['work'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($workId){
    		foreach($res['work_detail'] as $k=>$v){
    			$res['work_detail'][$k]['work_id'] = $res['work']['id'];
    		}
    		$workDetail = DB::name('work_detail')->insertAll($res['work_detail']);
            if($workDetail){
                DB::name('work_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $workId;
    }

    public function getOldDetail($id){
        $detail = DB::name('work_detail')->field('id')->where(['work_id'=>$id])->select()->toArray();
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
		return [$this->find($params['id'])->toArray(),DB::name('work_detail')->where(['work_id'=>$params['id']])->select()->toArray()];
	}

    public function getworkDetail($params){
        return DB::name('work_detail')->where(['work_id'=>$params['params']])->select();
    }

}