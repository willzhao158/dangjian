<?php
namespace app\order\model;

use think\Model;
use think\Db;
use app\order\model\LayuiModel;
Class OrderModel extends Model
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

    public function getadvbycom($company){
    	$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
        $where = '';
        if($user['level'] == '业务经理'){
        	$where .= " and name = '".$user['user_login']."'";
        }
    	$sql = "select * from ny_adviser where company = '$company'" .$where;
    	$res = $this->query($sql);
    	return $res;
    }

    public function getUserById(){
    	$uid = cmf_get_current_admin_id();
    	$sql = "select * from ny_user where id = $uid";
    	$res = $this->query($sql);
    	return $res[0];
    }

    public function getalldata($table){
    	$sql = "select * from $table";
    	$res = $this->query($sql);
        return $res;
    }

    public function getadviser(){
    	$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
        $company = $user['company'];
        $where = ' where 1=1';
        if($user['level'] != '总公司'){
        	$where .= " and company = '$company'";
        }
        $sql = "select * from ny_adviser".$where;
        //echo $sql;exit;
        $advisers = $this->query($sql);
        return $advisers;
    }

    public function getcompany(){
    	$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
        $where = ' where 1=1';
        if($user['level'] != '总公司'){
        	$where .= " and name = '".$user['company']."'";
        }
        $sql = "select * from ny_newcompany".$where;
        //echo $sql;exit;
        $advisers = $this->query($sql);
        return $advisers;
    }

    public function getExcelDate(){
    	$data = input();
    	$company = $data['company'];
    	$salesman = $data['salesman'];
    	$where = ' where 1 = 1';
    	if(!empty($company)){
    		$where .= " and company like '%{$company}%'";
    	}
    	if(!empty($salesman)){
    		$where .= " and salesman like '%{$salesman}%'";
    	}
    	$sql = "select max(back_time) as max from ny_order_back".$where;
    	//echo $sql;exit;
    	$max = $this->query($sql);
    	$sqlmin = "select min(back_time) as min from ny_order_back".$where;
    	$min = $this->query($sqlmin);
    	$res = array();
    	$res['min'] = $min[0]['min'];
    	$res['max'] = $max[0]['max'];
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

    public function adviserlist($islimit=true){

		//$this->page_count = $_POST['limit'];
		$data = input();
		$this->page_count = $data['limit'];
		$company = input('company','');
		$oid = input('oid','');
		$name = input('name','');
		$pro_name = input('pro_name','');
        $contra_num = input('contra_num','');
        $investor = input('investor','');
        $adviser = input('adviser','');
        $exam_status = input('exam_status','');
        $sign_date = input('sign_date','');


        $uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
        

		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }
		if($user['level'] != '总公司'){
			$where .= " and company = '".$user['company']."' ";
        }
		if($name){
			$where .= " and name like '%$name%' ";
		}
		if($company){
			$where .= " and company like '%$company%' ";
		}

		if($pro_name){
			$where .= " and pro_name like '%$pro_name%' ";
		}
		if($contra_num){
			$where .= " and contra_num like '%$contra_num%' ";
		}
		if($investor){
			$where .= " and investor like '%$investor%' ";
		}
		if($adviser){
			$where .= " and adviser like '%$adviser%' ";
		}
		if($exam_status){
			$where .= " and exam_status like '%$exam_status%' ";
		}
		if($sign_date){
			$sign_date = explode('~', $sign_date);
			$from = trim($sign_date[0]);
			$end = trim($sign_date[1]);
			$where .= " and sign_date >='$from' and sign_date <= '$end'";
		}
		if($oid){
			$where .= " and oid = $oid";
		}
		
		
		$start = ((input('page',1))-1)*$this->page_count;
		$count = $this->where($where)->count();
		
		$sql = $this->where($where)->limit($start,$this->page_count)->select(false);
		if($this->table=='ny_order'){
			$data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
		}else{
			$data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
		}
		//var_dump($sql);exit;
		return LayuiModel::layuiData($data,$count,$sql);
	} 

	public function salelist(){
		//$this->page_count = $_POST['limit'];
		$data = input();
		$company = input('company','');
		$oid = input('oid','');
		$name = input('name','');
		$pro_name = input('pro_name','');
        $contra_num = input('contra_num','');
        $investor = input('investor','');
        $adviser = input('adviser','');
        $exam_status = input('exam_status','');
        $sign_date = input('sign_date','');

        //var_dump($adviser);exit;

		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }

		if($name){
			$where .= " and name like '%$name%' ";
		}
		if($company){
			$where .= " and adviser_company like '%$company%' ";
		}

		if($pro_name){
			$where .= " and pro_name like '%$pro_name%' ";
		}
		if($contra_num){
			$where .= " and contra_num like '%$contra_num%' ";
		}
		if($investor){
			$where .= " and investor like '%$investor%' ";
		}
		if(!empty($adviser) && $adviser != 'null'){
			$where .= " and adviser like '%$adviser%' ";
		}
		if($exam_status){
			$where .= " and exam_status like '%$exam_status%' ";
		}
		if($sign_date){
			$sign_date = explode('~', $sign_date);
			$from = trim($sign_date[0]);
			$end = trim($sign_date[1]);
			$where .= " and sign_date >='$from' and sign_date <= '$end'";
		}
		if($oid){
			$where .= " and oid = $oid";
		}

		if($this->table=='ny_order'){
			$uid = cmf_get_current_admin_id();
	        $user = $this->getUserById();
			if($user['level'] == '分公司'){
				$where .= " and adviser_company = '".$user['company']."' ";
	        }
	        if($user['level'] == '业务经理'){
				$where .= " and adviser = '".$user['user_login']."' ";
	        }
		}
		//echo $where;exit;
		$data = $this->order("id", "desc")->where($where)->select()->toArray();
		return $data;
	} 	

	public function datalist($islimit=true){

		//$this->page_count = $_POST['limit'];
		$data = input();
		$this->page_count = $data['limit'];
		$company = input('company','');
		$oid = input('oid','');
		$name = input('name','');
		$pro_name = input('pro_name','');
        $contra_num = input('contra_num','');
        $investor = input('investor','');
        $adviser = input('adviser','');
        $exam_status = input('exam_status','');
        $sign_date = input('sign_date','');
        

		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }

		if($name){
			$where .= " and name like '%$name%' ";
		}
		if($company){
			$where .= " and adviser_company like '%$company%' ";
		}

		if($pro_name){
			$where .= " and pro_name like '%$pro_name%' ";
		}
		if($contra_num){
			$where .= " and contra_num like '%$contra_num%' ";
		}
		if($investor){
			$where .= " and investor like '%$investor%' ";
		}
		if($adviser){
			$where .= " and adviser like '%$adviser%' ";
		}
		if($exam_status){
			$where .= " and exam_status like '%$exam_status%' ";
		}
		if($sign_date){
			$sign_date = explode('~', $sign_date);
			$from = trim($sign_date[0]);
			$end = trim($sign_date[1]);
			$where .= " and sign_date >='$from' and sign_date <= '$end'";
		}
		if($oid){
			$where .= " and oid = $oid";
		}

		if($this->table=='ny_order'){
			$uid = cmf_get_current_admin_id();
	        $user = $this->getUserById();
			if($user['level'] == '分公司'){
				$where .= " and adviser_company = '".$user['company']."' ";
	        }
	        if($user['level'] == '业务经理'){
				$where .= " and adviser = '".$user['user_login']."' ";
	        }
		}
		$start = ((input('page',1))-1)*$this->page_count;
		$count = $this->where($where)->count();
		
		$sql = $this->where($where)->limit($start,$this->page_count)->select(false);
		if($this->table=='ny_order'){
			$data = $this->order("id", "desc")->where($where)->limit($start,$this->page_count)->select()->toArray();
			foreach ($data as $key => $value) {
				if($value['deadline'] < date("Y-m-d")){
					$data[$key]['isdq'] = "已到期";
				}else{
					$data[$key]['isdq'] = "";
				}
			}
		}else{
			$data = $this->where($where)->limit($start,$this->page_count)->select()->toArray();
		}
		//var_dump($sql);exit;
		return LayuiModel::layuiData($data,$count,$sql);
	} 	


	public function excelData(){
		//$this->page_count = $_POST['limit'];
		$data = input();
		$company = input('company','');
		$salesman = input('salesman','');
		$back_time = input('back_time','');
		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }
		if($company){
			$where .= " and company like '%$company%' ";
		}
		if($salesman){
			$where .= " and salesman like '%$salesman%' ";
		}
		if($back_time){
			$back_time_arr = explode('~', $back_time);
			$from = $back_time_arr[0];
			$end = $back_time_arr[1];
			$where .= " and deliver_time >= '".strtotime($from)."' and deliver_time <= '".strtotime($end)."'";
		}else{
			$from = date('Y-m',time());
            $end = date('Y-m',strtotime("+1years",time()));
		}
		$data = $this->where($where)->order('salesman')->select()->toArray();
		foreach ($data as $key => $value) {
			$data[$key]['deliver_time'] = date('Y-m-d',$value['deliver_time']);
			$time = 6;
			$alldebt = 0;
			for ($i=strtotime($from); $i <= strtotime($end); $i=strtotime("+1months",$i)) { 
	            $excelTime = date('Y-m',$i);
	            $cols[$time]['field'] = 'debt'.$time;
	            $cols[$time]['title'] = $excelTime;
	            $sql = "select * from ny_order_back where oid = ".$value['id']." and back_time = '{$excelTime}'";
    			$backinfo = $this->query($sql);

    			if(!empty($backinfo)){
    				$price = empty($backinfo[0]['price']) ? 0 : $backinfo[0]['price'];
    				$real_back = empty($backinfo[0]['real_back']) ? 0 : $backinfo[0]['real_back'];

    			}else{
    				$price = 0;
    				$real_back = 0;
    			}
    			$alldebt += intval($price) - intval($real_back);
    			$data[$key]['debt'.$time] = intval($price) - intval($real_back);
    			//var_dump($bakinfo);
	            $time++;
	        }

			$data[$key]['alldebt'] = $alldebt;
		}
		// $sql = "select max(back_time) as max from ny_order_back".$where;
  //   	$max = $this->query($sql);

    	
		return $data;
	}

	public function backExcel($islimit=true){
		//$this->page_count = $_POST['limit'];
		$data = input();
		$this->page_count = $data['limit'];
		$company = input('company','');
		$salesman = input('salesman','');
		$back_time = input('back_time','');
		$where = ' 1=1 ';
		// echo $where;exit;
		// if(session('company')!=0){
		// 	$where .= " and companyid=".session('companyid');
		// }
		if($company){
			$where .= " and company like '%$company%' ";
		}
		if($salesman){
			$where .= " and salesman like '%$salesman%' ";
		}
		if($back_time){
			$back_time_arr = explode('~', $back_time);
			$from = $back_time_arr[0];
			$end = $back_time_arr[1];
			$where .= " and deliver_time >= '".strtotime($from)."' and deliver_time <= '".strtotime($end)."'";
		}else{
			$from = date('Y-m',time());
            $end = date('Y-m',strtotime("+1years",time()));
		}
		$start = ((input('page',1))-1)*$this->page_count;
		$count = $this->where($where)->order('salesman')->count();
		$data = $this->where($where)->order('salesman')->limit($start,$this->page_count)->select()->toArray();
		$sql = $this->where($where)->order('salesman')->limit($start,$this->page_count)->select(false);
		foreach ($data as $key => $value) {
			$data[$key]['deliver_time'] = date('Y-m-d',$value['deliver_time']);
			$time = 6;
			$alldebt = 0;
			for ($i=strtotime($from); $i <= strtotime($end); $i=strtotime("+1months",$i)) { 
	            $excelTime = date('Y-m',$i);
	            $cols[$time]['field'] = 'debt'.$time;
	            $cols[$time]['title'] = $excelTime;
	            $sql = "select * from ny_order_back where oid = ".$value['id']." and back_time = '{$excelTime}'";
    			$backinfo = $this->query($sql);

    			if(!empty($backinfo)){
    				$price = empty($backinfo[0]['price']) ? 0 : $backinfo[0]['price'];
    				$real_back = empty($backinfo[0]['real_back']) ? 0 : $backinfo[0]['real_back'];

    			}else{
    				$price = 0;
    				$real_back = 0;
    			}
    			$alldebt += intval($price) - intval($real_back);
    			$data[$key]['debt'.$time] = intval($price) - intval($real_back);
    			//var_dump($bakinfo);
	            $time++;
	        }

			$data[$key]['alldebt'] = $alldebt;
		}
		// $sql = "select max(back_time) as max from ny_order_back".$where;
  //   	$max = $this->query($sql);

    	
		return LayuiModel::layuiData($data,$count,$sql);
	}

	public function adddata($data){
		$uid = cmf_get_current_admin_id();
        $user = $this->getUserById();
        $data['adviser_company'] = $user['company'];
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function editfielddata($data){
		//var_dump($data);exit;
		if(array_key_exists('adviser', $data['params'])){
			$adviser_info = explode('_', $data['params']['adviser']);
			$data['params']['adviser'] =  $adviser_info[0];
			$data['params']['adviser_id'] =  $adviser_info[1];
			$data['params']['adviser_company'] =  $adviser_info[2];
		}
		$edit = $this->save($data['params'],$data['params']['id']);
		if(!$edit){
			return [false,$data];
		}
		return [true,$edit];
	}

	public function editdata($data){
		$result = $this->getdatainfo($data);
		if($data['sample']==''){
			unset($data['sample']);
		}
		$edit = $this->allowField(true)->save($data,$data['id']);
		if(!$edit){
			return [false,$data];
		}
		if(isset($data['sample'])){
			$this->deleteFile('./'.$result['sample']);
		}
		return [true,$data];
	}


	public function deldata($params){
		$this->delfile($params);
		return $this->where('id','in',$params['params'])->delete();
	}

	public function getdatainfo($params){
		return $this->find($params['id'])->toArray();
	}

	protected function deleteFile($path){
        @unlink($path);
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