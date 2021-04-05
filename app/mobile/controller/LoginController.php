<?php

namespace app\mobile\controller;


use think\DB;
use app\common\model\UserModel;

use app\common\model\SmsModel;
use app\mobile\model\LoginModel;
use think\Session;

class LoginController extends BaseController
{

    public function initialize()
    {
        
    }


    /**
     * 后台管理员退出
     */
    public function logout()
    {
        session_start();
        session_destroy();
        return $this->fetch('login/login');
        exit;
    }

    public function dologin(){
        $res = LoginModel::Login();
        echo json_encode($res);exit;
    }

    //登录
    public function login()
    {
        return $this->fetch('login/login');
    }

}