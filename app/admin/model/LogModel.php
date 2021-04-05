<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use app\admin\model\LayuiModel;
Class LogModel extends Model
{
	private $page_count;

	public $table;

    public function editfielddata($data){
    	$edit = $this->save($data,$data['id']);
		if(!$edit){
			return [false,$data];
		}
		return [true,$edit];
	}

    public function adddata($data){
    	$data['create_time'] = time();
    	$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
		if($user['level'] == '分公司'){
			$data['company'] = $user['company'];
        }
        
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

    public function excelcdatalist(){
        $this->page_count = input('limit');
        $this->vip_log = 'charge_log';
        $data = input();
        $is_invoice = input('is_invoice','');

        $where = ' 1=1 ';

        if(!empty($is_invoice)){
            $where .= " and b.is_invoice = $is_invoice";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('mobile_user')->alias("a")->join('charge_log b ', ' a.id = b.uid')->where($where)->count();
        $data = Db::name('mobile_user')->alias("a")->field("a.name,a.alipay_account,a.mobile,a.id,b.money,b.createtime,b.is_invoice")->join('charge_log b ', ' a.id = b.uid')->order("b.id desc")->where($where)->select()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

    public function cdatalist(){
        $this->page_count = input('limit');
        $this->vip_log = 'charge_log';
        $data = input();
        $is_invoice = input('is_invoice','');

        $where = ' 1=1 ';

        if(!empty($is_invoice)){
            $where .= " and b.is_invoice = $is_invoice";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('mobile_user')->alias("a")->join('charge_log b ', ' a.id = b.uid')->where($where)->count();
        $data = Db::name('mobile_user')->alias("a")->field("a.name,a.alipay_account,a.mobile,a.id,b.money,b.createtime,b.is_invoice")->join('charge_log b ', ' a.id = b.uid')->order("b.id desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

	public function datalist(){
		$this->page_count = 10;
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

}	