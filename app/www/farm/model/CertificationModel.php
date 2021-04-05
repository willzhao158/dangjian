<?php
namespace app\farm\model;
use think\Db;
Class CertificationModel extends FarmbaseModel
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
            'certification' => $data,
            'certification_detail' => $array
        );
        return $this->result;
    }
    
    public function addcertification($data){
        $res = $this->handle_data($data);
        $certificationId = DB::name('certification')->insertGetId($res['certification']);
        if($certificationId){
            foreach($res['certification_detail'] as $k=>$v){
                $res['certification_detail'][$k]['certification_id'] = $certificationId;
            }
            $certificationDetail = DB::name('certification_detail')->insertAll($res['certification_detail']);
        }
        return $certificationId;
    }

    public function editcertification($data){
        $res = $this->handle_data($data);
        $id = $res['certification']['id'];

        $certificationId = DB::name('certification')->where(['id'=>$id])->update($res['certification']);
        $certificationId = $this->save($res['certification'],$id);


        $OldDetail = $this->getOldDetail($id);
        if($certificationId){
            foreach($res['certification_detail'] as $k=>$v){
                $res['certification_detail'][$k]['certification_id'] = $res['certification']['id'];
            }
            $certificationDetail = DB::name('certification_detail')->insertAll($res['certification_detail']);
            if($certificationDetail){
                DB::name('certification_detail')->where('id','in',$OldDetail)->delete();
            }
        }
        return $certificationId;
    }

    public function getOldDetail($id){
        $detail = DB::name('certification_detail')->field('id')->where(['certification_id'=>$id])->select()->toArray();
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
        return [$this->find($params['id'])->toArray(),DB::name('certification_detail')->where(['certification_id'=>$params['id']])->select()->toArray()];
    }

    public function getcertificationDetail($params){
        return DB::name('certification_detail')->where(['certification_id'=>$params['params']])->select();
    }

}