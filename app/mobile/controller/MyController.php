<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\UserModel;

class MyController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        $model = new UserModel();
        // $model->table= $this->table;
        $this->model = $model;


    }
    
    public function index()
    {

        $user = $this->model->getUserById();
        $this->assign("user", $user);
        return $this->fetch('my/index');
    }

    public function my_vip()
    {
        return $this->fetch('my/my_vip');
    }
}