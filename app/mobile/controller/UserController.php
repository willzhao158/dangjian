<?php
namespace app\order\controller;
use app\order\model\UserModel;

use think\DB;

class UserController extends BaseController
{
	private $pagecount;
    //数据表名
    public $table = 'ny_user';

	public function initialize(){
        parent::initialize();
        $model = new UserModel();
        $model->table= $this->table;
        $this->model = $model;
    }

	public function index(){
        $companys = $this->model->getalldata('ny_newcompany');
        $uid = cmf_get_current_admin_id();
        $user = $this->model->getUserById();
        $this->assign("user", $user);
        $this->assign("companys", $companys);
		return $this->fetch('user/index');
	}

    public function delaction(){
        if($this->model->deluser(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }

    

    public function addone(){
        $data = input();
        $data['companyid'] = 1;
        $add = $this->model->adddata($data);
        if($add[0]){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }

	public function datalist(){
		$res = $this->model->datalist();

        foreach ($res['data'] as $key => $value) {
            $res['data'][$key]['create_time'] = empty($value['create_time']) ? '' : date('Y-m-d H:i:s',intval($value['create_time']));
            $res['data'][$key]['last_login_time'] = empty($value['last_login_time']) ? '' : date('Y-m-d H:i:s',intval($value['last_login_time']));
            $res['data'][$key]['user_pass'] = '';
        }
        //var_dump($res);exit;
        return $res;
	}
    public function info()
    {
    	if(input()){
    		$data = input();
            $data['birthday'] = strtotime($data['birthday']);
            // $data['sex'] = $post_data['sex'];
            // $data['user_nickname'] = $post_data['user_nickname'];
            // $data['user_url'] = $post_data['user_url'];
            // $data['signature'] = $post_data['signature'];
            $data['id']       = cmf_get_current_admin_id();
            $create_result    = Db::name('user')->update($data);

            if ($create_result !== false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
    	}else{
    		$id   = cmf_get_current_admin_id();
	        $user = Db::name('user')->where("id", $id)->find();
	        $this->assign('user',$user);
	        return $this->fetch('user/info');
    	}
    	
    }

    public function editaction(){
        $data = input();
        if(array_key_exists('user_login', $data["params"])){
            $user_login = $data["params"]['user_login'];
            $user = Db::name('user')->where("user_login", $user_login)->find();
            if ($user) {
                return $this->error('该用户已存在，请更换用户名');
            }
        }
        $edit = $this->model->editfielddata($data);

        if($edit[0]){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function pass(){
    	if(input()){
    		if ($this->request->isPost()) {

	            $data = $this->request->param();
	            if (empty($data['old_password'])) {
	                $this->error("原始密码不能为空！");
	            }
	            if (empty($data['password'])) {
	                $this->error("新密码不能为空！");
	            }

	            $userId = cmf_get_current_admin_id();

	            $admin = Db::name('user')->where("id", $userId)->find();

	            $oldPassword = $data['old_password'];
	            $password    = $data['password'];
	            $rePassword  = $data['re_password'];

	            if (cmf_compare_password($oldPassword, $admin['user_pass'])) {
	                if ($password == $rePassword) {

	                    if (cmf_compare_password($password, $admin['user_pass'])) {
	                        $this->error("新密码不能和原始密码相同！");
	                    } else {
	                        Db::name('user')->where('id', $userId)->update(['user_pass' => cmf_password($password)]);
	                        $this->success("密码修改成功！");
	                    }
	                } else {
	                    $this->error("密码输入不一致！");
	                }

	            } else {
	                $this->error("原始密码不正确！");
	            }
	        }
    	}else{
    		$id   = cmf_get_current_admin_id();
	        $user = Db::name('user')->where("id", $id)->find();
	        $this->assign('user',$user);
	        return $this->fetch('user/pass');
    	}
    }

}