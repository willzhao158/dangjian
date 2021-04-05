<?php

namespace app\admin\controller;

use app\common\model\UserModel;
use think\DB;

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
        session('ADMIN_ID', null);
        session_destroy();
        $url = 'http://'.$_SERVER['HTTP_HOST']."/login/login";
        Header("Location:$url"); 
        exit;
    }

    public function doLogin(){
        $mobile = input('mobile','');
        $password = input('password');

        $res = array();
        
        $user = Db::table('ims_jueqi_fkdt_user')->where(['tel' => $mobile])->find();



        if(empty($user)){
            $res['code'] = 2;
            $res['msg'] = '此账号不存在,请您先注册！';
            return $res;
        }


        if($password == $user['password']){
            session('uid', $user["id"]);
            $res['code'] = 1;
            $res['msg'] = '登录成功';
            return $res;
        }else{
            $res['code'] = 2;
            $res['msg'] = '账号密码错误！';
            return $res;
        }
    }

    //登录
    public function login()
    {
        return $this->fetch('login/login');
    }
}