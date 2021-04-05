<?php
namespace app\farm\model;
use think\Db;
Class CollectModel extends FarmbaseModel
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
        	'collect' => $data,
        	'collect_detail' => $array
        );
        return $this->result;
    }
	
    public function addcollect($data){
    	$res = $this->handle_data($data);
    	$collectId = DB::name('collect')->insertGetId($res['collect']);
    	if($collectId){
    		foreach($res['collect_detail'] as $k=>$v){
    			$res['collect_detail'][$k]['collect_id'] = $collectId;
    		}
    		$collectDetail = DB::name('collect_detail')->insertAll($res['collect_detail']);
    	}
    	return $collectId;
    }

    public function editcollect($data){
    	$res = $this->handle_data($data);
        $id = $res['collect']['id'];

    	$collectId = DB::name('collect')->where(['id'=>$id])->update($res['collect']);
    	$collectId = $this->save($res['collect'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($collectId){
    		foreach($res['collect_detail'] as $k=>$v){
    			$res['collect_detail'][$k]['collect_id'] = $res['collect']['id'];
    		}
    		$collectDetail = DB::name('collect_detail')->insertAll($res['collect_detail']);
            if($collectDetail){
                DB::name('collect_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $collectId;
    }

    public function getOldDetail($id){
        $detail = DB::name('collect_detail')->field('id')->where(['collect_id'=>$id])->select()->toArray();
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
		return [$this->find($params['id'])->toArray(),DB::name('collect_detail')->where(['collect_id'=>$params['id']])->select()->toArray()];
	}

    public function getcollectDetail($params){
        return DB::name('collect_detail')->where(['collect_id'=>$params['params']])->select();
    }

}