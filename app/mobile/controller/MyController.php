<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\UserModel;
use app\mobile\model\CityModel;

class MyController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        $model = new UserModel();
        // $model->table= $this->table;
        $this->model = $model;


    }

    public function ticket(){
        $uid = session('uid');
        $ad_type = input('ad_type');
        //echo $uid;
        $my_tickets = Db::name('my_join')->order("id desc")->where("ad_type = {$ad_type} and uid = $uid")->all()->toArray();
        //var_dump($my_tickets);exit;
        foreach ($my_tickets as $key => $value) {
            $ad_info = Db::table('ny_advertisement')->where("id = {$value['ad_id']}")->find();
            
            if($ad_info['end_time'] < time()){
                unset($my_tickets[$key]);
                continue;
            }
            $my_tickets[$key]['subject'] = $ad_info['subject'];
            if($ad_info['type'] == 1){
                $my_tickets[$key]['activity_type_name'] = '广告宣传券';
            }else{
                $my_tickets[$key]['activity_type_name'] = ($ad_info['activity_type'] == 1) ? '58' : '108';
            }
            $my_tickets[$key]['end_time'] = date('Y-m-d H:i',$ad_info['end_time']);

            if($value['status']==1){
                $status = '提交';
            }elseif($value['status']==2){
                $status = '已退回';
            }elseif($value['status']==3){
                $status = '已提交';
            }elseif($value['status']==4){
                $status = '已使用';
            }
            $my_tickets[$key]['status_name'] = $status;


            
            //领券之后是否超过24小时
            $join_time = $value['join_time'];
            if((time()-$join_time) > 60*60*24){
                $my_tickets[$key]['pass_time'] = 2;
            }else{
                $my_tickets[$key]['pass_time'] = 1;
            }

        }

        //var_dump($my_tickets);exit;

        $this->assign("ad_type", $ad_type);
        $this->assign("my_tickets", $my_tickets);
        if($ad_type == 1){
            
            return $this->fetch('my/ticket');
        }else{
            
            



            return $this->fetch('my/ticket1');
        }

        
    }
    
    public function index()
    {

        $user = $this->model->getUserById();
        if($user['level'] == 1){
            $user['level_name'] = '普通用户';
        }elseif($user['level'] == 2){
            $user['level_name'] = 'VIP商家';
        }elseif($user['level'] == 3){
            $user['level_name'] = '合作商';
        }
        $user['fans_num'] = Db::name('mobile_user')->where(['reference' => $user['id'],'cancel'=>1])->count();
        $user['team'] = Db::name('mobile_user')->where(['reference' => $user['id'],'cancel'=>1])->whereor(['top_reference' => $user['id']])->count();
        $this->assign("user", $user);
        return $this->fetch('my/index');
    }

    public function cancel_tips(){
        $content = Db::table('ny_content')->where('id', 3)->find();
        
        $this->assign('content',$content);
        
        return $this->fetch('my/cancel_tips');
    }

    public function cancel_form(){
        $mobile = session('mobile');
        $this->assign('mobile',$mobile);
        return $this->fetch('my/cancel_form');
    }

    public function my_collect(){
        $uid = session('uid');
        $collects = Db::table('ny_my_collect')->where('uid', $uid)->order('createtime desc')->all()->toArray();
        $now = time();
        foreach ($collects as $key => $value) {
            $ad_info = Db::table('ny_advertisement')->where("id = {$value['ad_id']} and end_time >= $now")->find();

            if($ad_info['type'] == 2){
                $number = $ad_info['number'];
                $canjia = Db::table('ny_my_join')->where("ad_id = {$ad_info['id']} and status != 2")->count();
                if($canjia >= $number){
                    unset($collects[$key]);
                    continue;
                }
            }

            
            if(!empty($ad_info)){
                $collects[$key]['subject'] = $ad_info['subject'];
                $collects[$key]['ad_id'] = $ad_info['id'];
                $img = explode(',', $ad_info['imgs']);
                $collects[$key]['imgs'] = $img[0];
                $collects[$key]['type_name'] = ($ad_info['type'] == 1) ? '宣传类' : '活动类';
                $collects[$key]['ac_number'] = ($ad_info['type'] == 1) ? '关注名额:'.$ad_info['number'] : '活动名额:'.$ad_info['number'];
                $collects[$key]['count'] = $ad_info['end_time'] - time();
            }else{
                unset($collects[$key]);
            }
            
        }
        $this->assign('collects',$collects);
        return $this->fetch('my/collect');
    }

    public function docancel(){
        $mobile = input('mobile','');
        $code = input('code','');

        $res = array();
        
        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            echo json_encode($res);
            exit;
        }
        
        $array = array(
                        'cancel'=>2,
                    );

        Db::table('ny_mobile_user')->where('mobile', $mobile)->update($array);

        $res['code'] = 1;
        $res['msg'] = '注销成功';

        //session_start();
        session_destroy();

        echo json_encode($res);
        exit;
    }

    public function my_fans(){
        $uid = session('uid');
        $references = Db::table('ny_mobile_user')->order("id desc")->where(['reference' => $uid,'cancel'=>1])->all()->toArray();
        

        foreach ($references as $key => $value) {
            $level = $value['level'];
            if($level == 1){
                $references[$key]['level'] = '普通用户';
            }elseif($level == 2){
                $references[$key]['level'] = 'VIP商家';
            }elseif($level == 3){
                $references[$key]['level'] = '合作商';
            }

            $zhitui_num = Db::name('mobile_user')->where(['reference' => $value['id'],'cancel'=>1])->count();
            $vip_num = Db::name('mobile_user')->where(['reference' => $value['id'],'level'=>2,'cancel'=>1])->count();

            $references[$key]['zhitui_num'] = $zhitui_num;
            $references[$key]['vip_num'] = $vip_num;
            $references[$key]['createtime'] = date('Y-m-d H:i',$value['createtime']);
        }
        $this->assign("references", $references);
        return $this->fetch('my/my_fans');
    }

    public function config()
    {
        return $this->fetch('my/config');
    }

    public function my_phone()
    {
        $user = $this->model->getUserById();
        $this->assign("user", $user);
        return $this->fetch('my/my_phone');
    }

    public function change_phone(){
        $uid = session('uid');
        $old_mobile = input('old_mobile','');
        $mobile = input('mobile','');
        $code = input('code','');

        $res = array();
        
        $user = Db::table('ny_mobile_user')->where(['mobile' => $mobile,'cancel' => 1])->find();



        if($user){
            $res['code'] = 2;
            $res['msg'] = '此账号已被注册';
            return $res;
        }

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $old_mobile])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }
        
        $array = array(
                        'mobile'=>$mobile
                    );

        Db::table('ny_mobile_user')->where(['id'=>$uid,'mobile'=>$old_mobile])->update($array);

        $res['code'] = 1;
        $res['msg'] = '绑定成功';

        echo json_encode($res);exit;
    }

    public function alipay(){
        $user = $this->model->getUserById();
        $this->assign("user", $user);
        return $this->fetch('my/alipay');
    }

    public function save_alipay(){
        $uid = session('uid');
        $mobile = input('mobile','');
        $alipay_account = input('alipay_account','');
        $code = input('code','');

        $res = array();
        
        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }
        
        $array = array(
                        'alipay_account'=>$alipay_account
                    );

        Db::table('ny_mobile_user')->where(['id'=>$uid,'mobile'=>$mobile])->update($array);

        $res['code'] = 1;
        $res['msg'] = '提交成功';

        echo json_encode($res);exit;
    }

    public function select_address(){
        $address_list = Db::table('ny_address')->where(["uid" => session('uid')])->order('isdefault asc,createtime desc')->all()->toArray();

        foreach ($address_list as $key => $value) {
            $province = $value['province'];
            $city = $value['city'];
            $district = $value['district'];

            $address_list[$key]['province'] = Db::table('ny_city')->where(["value" => $value['province']])->value('label');
            $address_list[$key]['city'] = Db::table('ny_city')->where(["value" => $value['city']])->value('label');
            $address_list[$key]['district'] = Db::table('ny_city')->where(["value" => $value['district']])->value('label');
        }

        $this->assign("address_list", $address_list);

        return $this->fetch('my/address_list');
    }

    public function address_add(){

        $city = CityModel::getAll();

        $this->assign("city", json_encode($city));

        return $this->fetch('address/address_add');

    }    
}