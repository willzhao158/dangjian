<?php

namespace app\mobile\controller;

use think\DB;
use app\mobile\model\RegisterModel;

class RegisterController extends BaseController
{

    public function initialize()
    {

    }

    //注册页面
    public function index()
    {
        return $this->fetch('register/index');
    }

    public function doregister(){
        
        $res = RegisterModel::register();

        echo json_encode($res);exit;
    }

}