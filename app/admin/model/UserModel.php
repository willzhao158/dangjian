<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use app\admin\model\LayuiModel;
Class UserModel extends Model
{
	private $page_count;

	public $table;

	public function decimal2ABC($num){
        $ABCstr = "";
        $ten = $num;
        if($ten==0) return "A";
        while($ten!=0){
            $x = $ten%26;
            $ABCstr .= chr(65+$x);
            $ten = intval($ten/26);
        }

        return strrev($ABCstr);
    }

    public function getalldata($table){
    	$sql = "select * from $table";
    	$res = $this->query($sql);
        return $res;
    }

    

    public function stringFromColumnIndex($pColumnIndex = 0)
    {
        //    Using a lookup cache adds a slight memory overhead, but boosts speed
        //    caching using a static within the method is faster than a class static,
        //        though it's additional memory overhead
        static $_indexCache = array();

        if (!isset($_indexCache[$pColumnIndex])) {
            // Determine column string
            if ($pColumnIndex < 26) {
                $_indexCache[$pColumnIndex] = chr(65 + $pColumnIndex);
            } elseif ($pColumnIndex < 702) {
                $_indexCache[$pColumnIndex] = chr(64 + ($pColumnIndex / 26)) .
                                              chr(65 + $pColumnIndex % 26);
            } else {
                $_indexCache[$pColumnIndex] = chr(64 + (($pColumnIndex - 26) / 676)) .
                                              chr(65 + ((($pColumnIndex - 26) % 676) / 26)) .
                                              chr(65 + $pColumnIndex % 26);
            }
        }
        return $_indexCache[$pColumnIndex];
    }

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

    public function getUserById(){
    	$uid = cmf_get_current_admin_id();
    	$sql = "select * from ny_user where id = $uid";
    	$res = $this->query($sql);
    	return $res[0];
    }

    public function exceltixiandatalist(){
        $data = input();
        $from = input('from','');
        
        $where = ' 1 = 1';

        if(!empty($from)){
            $where .= " and ny_tixian_log.from = $from";
        }

        $start = ((input('page',1))-1)*$this->page_count;
        $count = $this->where($where)->count();
        $data = $this->order("id desc")->order('status asc,createtime desc')->where($where)->select()->toArray();
        $sql = $this->where($where)->limit($start,$this->page_count)->select(false);
        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    } 

    public function tixiandatalist(){
        $this->page_count = input('limit','');
        $data = input();
        $from = input('from','');
        
        $where = ' 1 = 1';

        if(!empty($from)){
            $where .= " and ny_tixian_log.from = $from";
        }

        $start = ((input('page',1))-1)*$this->page_count;
        $count = $this->where($where)->count();
        $data = $this->order("id desc")->order('status asc,createtime desc')->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = $this->where($where)->limit($start,$this->page_count)->select(false);
        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    } 

    public function sdatalist(){
        $this->page_count = input('limit');
        $data = input();
        $username = input('username','');
        $mobile = input('mobile','');
        
        $where = ' 1=1 ';

        if(!empty($username)){
            $where .= " and a.name like '%{$username}%'";
        }

        if(!empty($mobile)){
            $where .= " and a.mobile like '%{$mobile}%'";
        }

        
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);

        $count = Db::name('mobile_user')->alias("a")->join('ny_shop b ', ' a.id = b.uid')->where($where)->count();
        $data = Db::name('mobile_user')->alias("a")->order("b.id desc")->join('ny_shop b ', ' a.id = b.uid')->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = '';


        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

    public function adatalist(){
        $this->page_count = input('limit');
        $data = input();
        $mobile = input('mobile','');

        $where = ' 1=1 ';

        if(!empty($mobile)){
            $where .= " and a.mobile like '%{$mobile}%'";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('mobile_user')->alias("a")->join('ny_advertisement b ', ' a.id = b.uid')->where($where)->count();
        $data = Db::name('mobile_user')->alias("a")->order("b.id desc")->join('ny_advertisement b ', ' a.id = b.uid')->where($where)->limit($start,$this->page_count)->select()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

    public function excelvdatalist(){
        $this->page_count = input('limit');
        $this->vip_log = 'vip_update';
        $data = input();
        $mobile = input('mobile','');

        $where = ' 1=1 ';

        if(!empty($mobile)){
            $where .= " and a.mobile like '%{$mobile}%'";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('vip_update')->alias("a")->join('ny_address b ', ' a.address_id = b.id')->where($where)->count();
        $data = Db::name('vip_update')->alias("a")->join('ny_address b ', ' a.address_id = b.id')->order("a.id desc")->where($where)->field('a.*,b.name,b.province,b.city,b.district,b.address,b.mobile')->select()->toArray();
        $sql = '';

        //var_dump($sql);exit;
        return LayuiModel::layuiData($data,$count,$sql);
    }

    public function vdatalist(){
        $this->page_count = input('limit');
        $this->vip_log = 'vip_update';
        $data = input();
        $mobile = input('mobile','');

        $where = ' 1=1 ';

        if(!empty($mobile)){
            $where .= " and a.mobile like '%{$mobile}%'";
        }
        
        $start = ((input('page',1))-1)*$this->page_count;
        // $count = $this->where($where)->count();
        // $data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
        // $sql = $this->where($where)->limit($start,$this->page_count)->select(false);


        $count = Db::name('vip_update')->alias("a")->join('ny_address b ', ' a.address_id = b.id')->where($where)->count();
        $data = Db::name('vip_update')->alias("a")->join('ny_address b ', ' a.address_id = b.id')->order("a.id desc")->where($where)->field('a.*,b.name,b.province,b.city,b.district,b.address,b.mobile')->limit($start,$this->page_count)->select()->toArray();
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

}	