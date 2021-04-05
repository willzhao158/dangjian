<?php

namespace app\admin\controller;

use app\common\model\SmsModel;
use think\DB;

class SmsController extends BaseController
{

    public function initialize()
    {
        //parent::initialize();
    }



    //发送短信
    public function sendsms(){

        $mobile = $this->request->param("mobile");
        $time = time() - 60;
        $where = [];
        $where[] = ['mobile','=',$mobile];
        $where[] = ['createtime','>=',$time];
        $send_sms = Db::table('ims_sms')->where($where)->select()->toArray();

        $times = count($send_sms);
        if($times >= 3){
            $res_arr['code'] = 2;
            $res_arr['msg'] = '请您休息几分钟~';
            echo json_encode($res_arr);exit;
        }
        
        $code = rand(99999,999999);

        $res = SmsModel::sendSms($mobile,$code);

        $res_arr = array();

        if($res->Code == 'OK'){
            $array = array(
                    'mobile'=>$mobile,
                    'code'=>$code,
                    'createtime'=>time()
                );
            Db::name("sms")->insert($array);

            $res_arr['code'] = 1;
            $res_arr['msg'] = '发送成功';
        }else{
            $res_arr['code'] = 2;
            $res_arr['msg'] = '发送失败，请稍后再试';
        }
        echo json_encode($res_arr);exit;
    }
}