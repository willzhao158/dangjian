<?php
namespace app\mobile\model;

use think\Model;
use think\Db;
use app\mobile\model\LayuiModel;
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

    public function editfielddata($data){
    	if(array_key_exists('user_pass', $data['params'])){
    		$data['params']['user_pass'] = cmf_password($data['params']['user_pass']);
    	}

		$edit = $this->save($data['params'],$data['params']['id']);
		if(!$edit){
			return [false,$data];
		}
		return [true,$edit];
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
    	$uid = session('uid');
    	$sql = "select * from ny_mobile_user where id = $uid and cancel = 1";
    	$res = $this->query($sql);
    	return $res[0];
    }

	public function datalist(){
		//$this->page_count = $_POST['limit'];
		$data = input();
		$user_login = input('user_login','');
		$level = input('level','');
		$special_number = input('special_number','');
		$salesman = input('salesman','');
		$isxinghuo = input('isxinghuo','');
		$tran_company = input('tran_company','');
		$con_number = input('con_number','');
		$oid = input('oid','');
		$deliver_time = input('deliver_time','');
		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }
		if($user_login){
			$where .= " and user_login like '%$user_login%' ";
		}
		if($level){
			$where .= " and level like '%$level%' ";
		}
		if($special_number){
			$where .= " and special_number like '%$special_number%' ";
		}
		if($salesman){
			$where .= " and salesman like '%$salesman%' ";
		}
		if($isxinghuo){
			$where .= " and isxinghuo like '%$isxinghuo%' ";
		}
		if($tran_company){
			$where .= " and tran_company like '%$tran_company%' ";
		}
		if($con_number){
			$where .= " and con_number like '%$con_number%' ";
		}
		if($oid){
			$where .= " and oid = $oid";
		}
		if($deliver_time){
			$deliver_time_arr = explode('~', $deliver_time);
			$from = strtotime($deliver_time_arr[0]);
			$end = strtotime($deliver_time_arr[1]);
			$where .= " and deliver_time >= '{$from}' and deliver_time <= '{$end}'";
		}

		$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
		if($user['level'] == '分公司'){
			$where .= " and company = '".$user['company']."' ";
        }
        
		
		$start = ((input('page',1))-1)*$this->page_count;
		$count = $this->where($where)->count();
		$data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
		$sql = $this->where($where)->limit($start,$this->page_count)->select(false);
		//var_dump($sql);exit;
		return LayuiModel::layuiData($data,$count,$sql);
	} 	

}	