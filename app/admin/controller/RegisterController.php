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

    public function resetpwd(){
        return $this->fetch('register/resetpwd');
    }

    public function doreset(){
        $res = array();
        $mobile = $this->request->param("mobile");
        if (empty($mobile)) {
            $res['code'] = 2;
            $res['msg'] = '请输入手机号';
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

        if(empty($user['password'])){
            $res['code'] = 2;
            $res['msg'] = '此账号不存在';
            echo json_encode($res);
            exit;
        }else{
            $data = [];
            $data['password'] = $password;

            Db::table('ims_jueqi_fkdt_user')->where("tel", $mobile)->update($data);

            $res['code'] = 1;
            $res['msg'] = '密码重置成功';
            echo json_encode($res);
            exit;
        }
    }

    public function storage(){
        $count =  Db::table('ims_jueqi_fkdt_question')->count();
        $this->assign('count',$count);
        return $this->fetch();
    }

    public function getQuestion(){
        $curr = $this->request->param("curr");
        $limit = $this->request->param("limit");

        $start = ($curr - 1) * $limit;

        $questions = Db::table('ims_jueqi_fkdt_question')->order("id asc")->limit($start,$limit)->select()->toArray();

        $str = '';
        foreach ($questions as $key => $value) {
            if($value['is_danxuan'] == 1){
                $type = 'radio';
            }else{
                $type = 'checkbox';
            }
            $answerA_str = empty($value['answerA']) ? '' : '<li>A、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerA'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'A')){
                $answerA_str = str_replace('checked', '', $answerA_str);
            }
            $answerB_str = empty($value['answerB']) ? '' : '<li>B、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerB'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'B')){
                $answerB_str = str_replace('checked', '', $answerB_str);
            }
            $answerC_str = empty($value['answerC']) ? '' : '<li>C、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerC'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'C')){
                $answerC_str = str_replace('checked', '', $answerC_str);
            }
            $answerD_str = empty($value['answerD']) ? '' : '<li>D、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerD'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'D')){
                $answerD_str = str_replace('checked', '', $answerD_str);
            }
            $answerE_str = empty($value['answerE']) ? '' : '<li>E、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerE'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'E')){
                $answerE_str = str_replace('checked', '', $answerE_str);
            }
            $answerF_str = empty($value['answerF']) ? '' : '<li>F、<label class="item"><input type="'.$type.'" disabled checked><i></i><span>'.$value['answerF'].'</span></label></li>';
            if(!strstr($value['yes_answer'],'F')){
                $answerF_str = str_replace('checked', '', $answerF_str);
            }
            $str .= '<div class="form-item on">
                    <div class="question">'.($key+$start+1).'.'.$value['question'].'</div>
                    <ul class="answer-list">'.$answerA_str.$answerB_str.$answerC_str.$answerD_str.$answerE_str.$answerF_str.'
                    </ul>
                </div>';
        }

        echo json_encode($str);exit;

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