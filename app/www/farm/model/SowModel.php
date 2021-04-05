<?php
namespace app\farm\model;
use think\Db;
Class SowModel extends FarmbaseModel
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
            'sow' => $data,
            'sow_detail' => $array
        );
        return $this->result;
    }
    
    public function addsow($data){
        $res = $this->handle_data($data);
        $sowId = DB::name('sow')->insertGetId($res['sow']);
        if($sowId){
            foreach($res['sow_detail'] as $k=>$v){
                $res['sow_detail'][$k]['sow_id'] = $sowId;
            }
            $sowDetail = DB::name('sow_detail')->insertAll($res['sow_detail']);
        }
        return $sowId;
    }

    public function editsow($data){
        $res = $this->handle_data($data);
        $id = $res['sow']['id'];

        $sowId = DB::name('sow')->where(['id'=>$id])->update($res['sow']);
        $sowId = $this->save($res['sow'],$id);


        $OldDetail = $this->getOldDetail($id);
        if($sowId){
            foreach($res['sow_detail'] as $k=>$v){
                $res['sow_detail'][$k]['sow_id'] = $res['sow']['id'];
            }
            $sowDetail = DB::name('sow_detail')->insertAll($res['sow_detail']);
            if($sowDetail){
                DB::name('sow_detail')->where('id','in',$OldDetail)->delete();
            }
        }
        return $sowId;
    }

    public function getOldDetail($id){
        $detail = DB::name('sow_detail')->field('id')->where(['sow_id'=>$id])->select()->toArray();
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
        return [$this->find($params['id'])->toArray(),DB::name('sow_detail')->where(['sow_id'=>$params['id']])->select()->toArray()];
    }

    public function getsowDetail($params){
        return DB::name('sow_detail')->where(['sow_id'=>$params['params']])->select();
    }

}