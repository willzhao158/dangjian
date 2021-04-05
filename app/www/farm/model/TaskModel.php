<?php
namespace app\farm\model;
use think\Db;
Class TaskModel extends FarmbaseModel
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
        	'task' => $data,
        	'task_detail' => $array
        );
        return $this->result;
    }
	
    public function addtask($data){
    	$res = $this->handle_data($data);
    	$taskId = DB::name('task')->insertGetId($res['task']);
    	if($taskId){
    		foreach($res['task_detail'] as $k=>$v){
    			$res['task_detail'][$k]['task_id'] = $taskId;
    		}
    		$taskDetail = DB::name('task_detail')->insertAll($res['task_detail']);
    	}
    	return $taskId;
    }

    public function edittask($data){
    	$res = $this->handle_data($data);
        $id = $res['task']['id'];

    	$taskId = DB::name('task')->where(['id'=>$id])->update($res['task']);
    	$taskId = $this->save($res['task'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($taskId){
    		foreach($res['task_detail'] as $k=>$v){
    			$res['task_detail'][$k]['task_id'] = $res['task']['id'];
    		}
    		$taskDetail = DB::name('task_detail')->insertAll($res['task_detail']);
            if($taskDetail){
                DB::name('task_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $taskId;
    }

    public function getOldDetail($id){
        $detail = DB::name('task_detail')->field('id')->where(['task_id'=>$id])->select()->toArray();
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
		return [$this->find($params['id'])->toArray(),DB::name('task_detail')->where(['task_id'=>$params['id']])->select()->toArray()];
	}

    public function gettaskDetail($params){
        return DB::name('task_detail')->where(['task_id'=>$params['params']])->select();
    }

}