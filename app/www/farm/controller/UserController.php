<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;

use cmf\controller\AdminBaseController;
use cmf\controller\RestBaseController;
use app\farm\model\UserModel;
use think\Db;
use think\facade\Validate;

Class UserController extends AdminBaseController
{
	public function initialize(){
        parent::initialize();
		
		$this->user = new userModel();
		$this->restbase = new RestBaseController();
	}

	public function index(){
		return view();
	}

	public function userlist(){
		return $this->user->userlist();
	}

	public function getRole(){
		return DB::name('role')->select()->toArray();
	}

	public function add(){
        $company = $this->user->getCompany();
        $this->assign('company',$company);
		$this->assign('role',$this->getRole());
		return view();
	}



	public function edit(){
        $company = $this->user->getCompany();
        $this->assign('company',$company);
		$this->assign('role',$this->getRole());
		$this->assign('user',$this->user->getUserinfo());
		return view();
	}

	public function addaction(){
        $add = $this->user->adduser(input());
        if($add){
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
     }

    public function editaction(){
        $edit = $this->user->edituser(input());
        if($edit){
            return $this->success('更新成功');
        }
        return $this->error('更新失败');
    }

    public function delaction(){
    	if($this->user->deluser(input())){
    		return $this->success('删除成功');
    	}
    	return $this->error('删除失败');
    }

    public function password(){
    	return view();
    }

    public function passwordPost()
    {
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
    }


    public function userInfo()
    {
        $id   = cmf_get_current_admin_id();
        $user = Db::name('user')->where("id", $id)->find();
        $this->assign($user);
        return $this->fetch();
    }


    public function userInfoPost()
    {
        if ($this->request->isPost()) {

            $data             = $this->request->post();
            $data['birthday'] = strtotime($data['birthday']);
            $data['id']       = cmf_get_current_admin_id();
            $create_result    = Db::name('user')->update($data);;
            if ($create_result !== false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }

}