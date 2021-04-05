<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\RuleModel;

class WalletController extends BaseController
{
    private $encript_str = "FQtAWzcQyR51Itmj4nGNFHu2aBQmVmMOMaoIknlTPxW9iy9OdT";

    public function initialize(){
        parent::initialize();
        //$model = new UserModel();
        // $model->table= $this->table;
        //$this->model = $model;


    }
    
    public function index(){
        $uid = session('uid');
        $user = Db::name('mobile_user')->where(['id'=>$uid,'cancel'=>1])->find();

        $income_log = Db::name('income_log')->order("id desc")->where(['uid'=>$uid])->all()->toArray();

        $allready_tixian = Db::name('tixian_log')->where("ny_tixian_log.from=1 and uid = $uid")->sum('price');

        foreach ($income_log as $key => $value) {
            if($value['from'] == 1){
                $income_log[$key]['from_log'] = '直推用户提现成功奖励';
            }elseif($value['from'] == 2){
                $income_log[$key]['from_log'] = '社区用户提现成功奖励';
            }elseif($value['from'] == 3){
                $income_log[$key]['from_log'] = '直推用户升级VIP商家成功奖励';
            }elseif($value['from'] == 4){
                $income_log[$key]['from_log'] = '社区用户升级VIP商家成功奖励';
            }elseif($value['from'] == 5){
                $income_log[$key]['from_log'] = '直推用户升级为合作商成功奖励';
            }elseif($value['from'] == 6){
                $income_log[$key]['from_log'] = '社区用户升级为合作商成功奖励';
            }elseif($value['from'] == 7){
                $income_log[$key]['from_log'] = '领取商家活动彩金券成功奖励';
            }elseif($value['from'] == 8){
                $income_log[$key]['from_log'] = '领取商家广告宣传券成功奖励';
            }

            $income_log[$key]['createtime'] = date('Y-m-d H:i',$value['createtime']);
        }

        $this->assign("allready_tixian", $allready_tixian);
        $this->assign("user", $user);
        $this->assign("income_log", $income_log);

        $tixian_log = Db::name('tixian_log')->order("id desc")->where(['uid'=>$uid])->all()->toArray();
        $this->assign("tixian_log", $tixian_log);

        return $this->fetch('wallet/index');
    }

    public function get_income(){
        $uid = input('uid','');
        $my_uid = session('uid');
        $cash_number = input('cash_number','');
        $code = input('code','');

        $user_info = Db::name('mobile_user')->where(['id'=>$my_uid])->find();

        if(empty($user_info)){
            $res['code'] = 2;
            $res['msg'] = '非法操作！';
            return $res;
        }

        if($cash_number < 100 || $cash_number > 1000){
            echo $cash_number;
            $res['code'] = 2;
            $res['msg'] = '请输入正确数额！';
            return $res;
        }

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $user_info['mobile']])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }

        //每月限4次收益提现次数
        $tixian_count = Db::name('tixian_log')->where(['uid'=>$my_uid,'from'=>1])->count();
        if($tixian_count >= 4){
            $res['code'] = 2;
            $res['msg'] = '您已超过当月提现次数！';
            return $res;
        }

        if($uid != $my_uid){
            $res['code'] = 2;
            $res['msg'] = '非法操作！';
            return $res;
        }

        if(empty($my_uid)){
            $res['code'] = 3;
            $res['msg'] = '请重新登录！';
            return $res;
        }

        

        if($cash_number > $user_info['income']){
            $res['code'] = 2;
            $res['msg'] = '请输入正确数额！';
            return $res;
        }

        $RuleModel = new RuleModel();
        $RuleModel::income_cash($uid,$cash_number);

        $res['code'] = 1;
        $res['msg'] = '提现成功！';


        return $res;

    }

    public function my_wallet_cash(){
        $uid = session('uid');
        $user = Db::name('mobile_user')->where(['id'=>$uid,'cancel'=>1])->find();
        if(empty($user['alipay_account'])){
            return $this->fetch('wallet/alipay_warning');
        }
        $this->assign("user", $user);

        return $this->fetch('wallet/my_wallet_cash');
    }

    public function yue_tixian(){
        $uid = session('uid');
        $cash_number = input('cash_number','');
        $code = input('code','');

        $user_info = Db::name('mobile_user')->where(['id'=>$uid])->find();

        if(empty($user_info)){
            $res['code'] = 2;
            $res['msg'] = '非法操作！';
            return $res;
        }

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $user_info['mobile']])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }

        //每月限1次收益提现次数
        $from = strtotime(date('Y-m-01 00:00:00'));
        $end = strtotime(date('Y-m-31 23:59:59'));
        $tixian_count = Db::name('tixian_log')->where("uid = $uid and createtime >= $from and createtime <= $end and ny_tixian_log.from = 2")->count();
        if($tixian_count >= 1){
            $res['code'] = 2;
            $res['msg'] = '您已超过当月提现次数！';
            return $res;
        }

        if(empty($uid)){
            $res['code'] = 3;
            $res['msg'] = '请重新登录！';
            return $res;
        }

        

        if($cash_number > $user_info['yue']){
            $res['code'] = 2;
            $res['msg'] = '请输入正确数额！';
            return $res;
        }

        Db::table('ny_mobile_user')->where("id = $uid")->setDec('yue',$cash_number);

        $tixian_log = array(
                        'uid'=>$uid,
                        'price'=>$cash_number,
                        'channel'=>'余额提现',
                        'createtime'=>time(),
                        'from'=>2,
                        'status'=>1,
                    );
        Db::table('ny_tixian_log')->insert($tixian_log);

        $yue_log =  array(
                        'uid'=>$uid,
                        'price'=>$cash_number,
                        'change'=>'1',
                        'createtime'=>time(),
                        'action'=>'余额提现'
                    );
        Db::table('ny_yue_log')->insert($yue_log);

        $res['code'] = 1;
        $res['msg'] = '提现成功！';
        return $res;
    }

    public function yue(){
        $uid = session('uid');
        $status = Db::name('shop')->where(['uid'=>$uid])->value('status');
        $user = Db::name('mobile_user')->where(['id'=>$uid,'cancel'=>1])->find();



        if($user['level'] == 1){
            return $this->fetch('shop/vip_fail');
        }

        if(empty($status)){
            return $this->fetch('shop/first');
        }

        if($status == 1){
            Header("Location:".url('tips/examine')); 
            exit;
        }elseif($status == 2){
            Header("Location:".url('tips/fail')); 
            exit;
        }else{
            $yue_log = Db::name('yue_log')->order("id desc")->where(['uid'=>$uid])->all()->toArray();
            $this->assign("yue_log", $yue_log);
            $this->assign("user", $user);
            return $this->fetch('wallet/yue');
        }


    }

    public function tixian(){
        $uid = session('uid');
        $user = Db::name('mobile_user')->where(['id'=>$uid])->find();
        if(empty($user['alipay_account'])){
            return $this->fetch('wallet/alipay_warning');
        }
        $this->assign("user", $user);
        return $this->fetch('wallet/tixian');
    }

    public function charge(){
        $uid = session('uid');
        $invoice = Db::name('invoice')->where(['uid'=>$uid])->find();
        if(empty($invoice)){
            return $this->fetch('wallet/invoice_error');
        }
        $need_charge = input('need_charge');
        $this->assign("need_charge", $need_charge);
        return $this->fetch('wallet/charge');
    }

    public function show_charge(){
        $uid = session('uid');
        $money = input('money');
        $this->assign("money", $money*1.065);
        return $this->fetch('wallet/show_charge');
    }

    public function docharge(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return $this->fetch('wallet/pay_error');
        }
    }
    
}