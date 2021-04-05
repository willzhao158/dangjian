<?php
namespace app\farm\model;
use think\Db;
Class FertilizeModel extends FarmbaseModel
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
        	'fertilize' => $data,
        	'fertilize_detail' => $array
        );
        return $this->result;
    }
	
    public function addfertilize($data){
    	$res = $this->handle_data($data);
    	$fertilizeId = DB::name('fertilize')->insertGetId($res['fertilize']);
    	if($fertilizeId){
    		foreach($res['fertilize_detail'] as $k=>$v){
    			$res['fertilize_detail'][$k]['fertilize_id'] = $fertilizeId;
    		}
    		$fertilizeDetail = DB::name('fertilize_detail')->insertAll($res['fertilize_detail']);
    	}
    	return $fertilizeId;
    }

    public function editfertilize($data){
    	$res = $this->handle_data($data);
        $id = $res['fertilize']['id'];

    	$fertilizeId = DB::name('fertilize')->where(['id'=>$id])->update($res['fertilize']);
    	$fertilizeId = $this->save($res['fertilize'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($fertilizeId){
    		foreach($res['fertilize_detail'] as $k=>$v){
    			$res['fertilize_detail'][$k]['fertilize_id'] = $res['fertilize']['id'];
    		}
    		$fertilizeDetail = DB::name('fertilize_detail')->insertAll($res['fertilize_detail']);
            if($fertilizeDetail){
                DB::name('fertilize_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $fertilizeId;
    }

    public function getOldDetail($id){
        $detail = DB::name('fertilize_detail')->field('id')->where(['fertilize_id'=>$id])->select()->toArray();
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
		return [$this->find($params['id'])->toArray(),DB::name('fertilize_detail')->where(['fertilize_id'=>$params['id']])->select()->toArray()];
	}

    public function getfertilizeDetail($params){
        return DB::name('fertilize_detail')->where(['fertilize_id'=>$params['params']])->select();
    }

}