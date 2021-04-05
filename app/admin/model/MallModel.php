<?php
namespace app\admin\model;
use think\Model;
use think\DB;
use app\admin\model\LayuiModel;

class MallModel extends Model
{

    private $page_count;

    public $table;

    public function getdatainfo($params){
        return $this->find($params['id'])->toArray();
    }

    public function excelodatalist(){
        $this->page_count = input('limit');
        $data = input();
        $serial = input('serial','');
        $pay_status = input('pay_status','');

        $where = ' 1=1 ';

        if(!empty($serial)){
            $where .= " and a.serial like '%$serial%'";
        }
        if(!empty($pay_status)){
            $where .= " and b.status = $pay_status";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('goods')->alias("a")->join('ny_goods_order b ', ' b.goods_id = a.id')->where($where)->count();

        $data = Db::name('goods')->alias("a")->join('ny_goods_order b ', ' b.goods_id = a.id')->order("b.id desc")->where($where)->all()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }
    
    public function odatalist(){
        $this->page_count = input('limit');
        $data = input();
        $serial = input('serial','');
        $pay_status = input('pay_status','');

        $where = ' 1=1 ';

        if(!empty($serial)){
            $where .= " and a.serial like '%$serial%'";
        }
        if(!empty($pay_status)){
            $where .= " and b.status = $pay_status";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('goods')->alias("a")->join('ny_goods_order b ', ' b.goods_id = a.id')->where($where)->count();

        $data = Db::name('goods')->alias("a")->join('ny_goods_order b ', ' b.goods_id = a.id')->order("b.id desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

    public function datalist(){
        $this->page_count = input('limit');
        $data = input();
        $mobile = input('mobile','');
        
        $where = ' 1=1 ';

        if(!empty($mobile)){
            $where .= " and mobile like '%{$mobile}%'";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        $count = $this->where($where)->count();
        $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = $this->where($where)->limit($start,$this->page_count)->select(false);
        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }   

    public function getUserById(){
        $uid = cmf_get_current_admin_id();
        $sql = "select * from ny_user where id = $uid";
        $res = $this->query($sql);
        return $res[0];
    }

    public function editfielddata($data){
        $edit = $this->save($data,$data['id']);
        if(!$edit){
            return [false,$data];
        }
        return [true,$edit];
    }

    public function adddata($data){
        $save = $this->allowField(true)->save($data);
        if(!$save){
            return [false,$data];
        }
        return [true,$save];
    }

    public function deluser($params){
        //var_dump($params);exit;
        $users = explode(',',$params['params']);
        foreach ($users as $key => $value) {
            if($value==1){
                continue;
            }
            $this->where('id','in',$value)->delete();
        }
        return true;
    }

    public function deldata($params){
        //var_dump($params);exit;
        return $this->where('id','in',$params['params'])->delete();
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