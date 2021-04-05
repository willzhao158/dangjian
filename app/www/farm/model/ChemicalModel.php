<?php
namespace app\farm\model;
use think\Db;
Class ChemicalModel extends FarmbaseModel
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
        	'chemical' => $data,
        	'chemical_detail' => $array
        );
        return $this->result;
    }
	
    public function addchemical($data){
    	$res = $this->handle_data($data);
    	$chemicalId = DB::name('chemical')->insertGetId($res['chemical']);
    	if($chemicalId){
    		foreach($res['chemical_detail'] as $k=>$v){
    			$res['chemical_detail'][$k]['chemical_id'] = $chemicalId;
    		}
    		$chemicalDetail = DB::name('chemical_detail')->insertAll($res['chemical_detail']);
    	}
    	return $chemicalId;
    }

    public function editchemical($data){
    	$res = $this->handle_data($data);
        $id = $res['chemical']['id'];

    	$chemicalId = DB::name('chemical')->where(['id'=>$id])->update($res['chemical']);
    	$chemicalId = $this->save($res['chemical'],$id);


        $OldDetail = $this->getOldDetail($id);
    	if($chemicalId){
    		foreach($res['chemical_detail'] as $k=>$v){
    			$res['chemical_detail'][$k]['chemical_id'] = $res['chemical']['id'];
    		}
    		$chemicalDetail = DB::name('chemical_detail')->insertAll($res['chemical_detail']);
            if($chemicalDetail){
                DB::name('chemical_detail')->where('id','in',$OldDetail)->delete();
            }
    	}
    	return $chemicalId;
    }

    public function getOldDetail($id){
        $detail = DB::name('chemical_detail')->field('id')->where(['chemical_id'=>$id])->select()->toArray();
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
		return [$this->find($params['id'])->toArray(),DB::name('chemical_detail')->where(['chemical_id'=>$params['id']])->select()->toArray()];
	}

    public function getchemicalDetail($params){
        return DB::name('chemical_detail')->where(['chemical_id'=>$params['params']])->select();
    }

}