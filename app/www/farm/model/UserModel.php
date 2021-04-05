<?php
namespace app\farm\model;

use think\Model;
use app\farm\model\LayuiModel;
use think\DB;
use think\session;

Class UserModel extends Model
{
	private $pagecount;

	public function userlist(){
		$this->pagecount = Config('page_count');
		$name = input('name','');

		$where = [];

		if(session('company')!=0){
			$where['companyid'] = session('company');
		}

		if($name){
			$where['user_login'] = ['like','%'.$name.'%'];
		}
		$start = ((input('page',1))-1)*$this->pagecount;
		$count = $this->where($where)->count();
		$data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
		$sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
		return LayuiModel::layuiData($data,$count,$start);
	} 	

	public function adduser($data){
		$data['user_pass'] = cmf_password($data['user_pass']);
		$save = $this->allowField(true)->save($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function edituser($data){
		if($data['user_pass']){
			$data['user_pass'] = cmf_password($data['user_pass']);
		}else{
			unset($data['user_pass']);
		}
		file_put_contents('role.txt', json_encode($data,true));
		DB::name('role_user')->where(['user_id'=>$data['id']])->update(['role_id'=>$data['user_type']]);





		$save = $this->allowField(true)->where(['id'=>$data['id']])->update($data);
		if(!$save){
			return [false,$data];
		}
		return [true,$save];
	}

	public function deluser($params){
		return $this->where(['id'=>['in',$params['params']]])->delete();
	}

	public function getUserinfo(){
		return $this->find(input('id'));
	}

	public function getCompany(){
		return DB::name('company')->select()->toArray();
	}

}