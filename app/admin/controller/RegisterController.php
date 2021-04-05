<?php

namespace app\admin\controller;

use app\common\model\UserModel;
use think\DB;

class RegisterController extends BaseController
{

    public function initialize()
    {

    }

    //登录
    public function index()
    {
        return $this->fetch('register/index');
    }

    public function doregister(){
        $res = array();
        $mobile = $this->request->param("mobile");
        if (empty($mobile)) {
            $res['code'] = 2;
            $res['msg'] = '请输入手机号';
            echo json_encode($res);
            exit;
        }
        $bumen = $this->request->param("bumen");
        if (empty($mobile)) {
            $res['code'] = 2;
            $res['msg'] = '请选择部门';
            echo json_encode($res);
            exit;
        }
        $password = $this->request->param("password");
        if (empty($password)) {
            $res['code'] = 2;
            $res['msg'] = '请输入密码';
            echo json_encode($res);
            exit;
        }
        $code = $this->request->param("code");
        if (empty($code)) {
            $res['code'] = 2;
            $res['msg'] = '请输入验证码';
            echo json_encode($res);
            exit;
        }

        $send_sms = Db::table('ims_sms')->where(['mobile' => $mobile])->order("id desc")->find();
        if($send_sms['code'] != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            echo json_encode($res);
            exit;
        }

        $user = Db::table('ims_jueqi_fkdt_user')->where(['tel' => $mobile])->find();

        if(!empty($user['password'])){
            $res['code'] = 2;
            $res['msg'] = '此号码已注册';
            echo json_encode($res);
            exit;
        }

        if(!empty($user)){
            $data = [];
            $data['tel'] = $mobile;
            $data['bumen'] = $bumen;
            $data['password'] = $password;

            Db::table('ims_jueqi_fkdt_user')->where("tel", $mobile)->update($data);

            $res['code'] = 1;
            $res['msg'] = '注册成功';
            echo json_encode($res);
            exit;
        }else{
            $data = [];
            $data['uniacid'] = 10;
            $data['pid'] = 13;
            $data['tel'] = $mobile;
            $data['add_time'] = time();
            $data['rid'] = 28;
            $data['bumen'] = $bumen;
            $data['password'] = $password;

            $id = Db::table('ims_jueqi_fkdt_user')->insertGetId($data);

            $res['code'] = 1;
            $res['msg'] = '注册成功';
            echo json_encode($res);
            exit;
        }

        
    }
}