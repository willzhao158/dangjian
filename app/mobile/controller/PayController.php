<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\PayModel;
use app\mobile\model\RuleModel;

class PayController extends BaseController
{
    

    public function initialize(){
    }

    public function show_charge(){
        $uid = input('uid');
        $invoice = Db::name('invoice')->where(['uid'=>$uid])->find();
        if(empty($invoice)){
            return $this->fetch('wallet/invoice_error');
        }
        $need_charge = input('need_charge');
        $this->assign("uid", $uid);
        $this->assign("need_charge", $need_charge);
        return $this->fetch('pay/charge');
    }



    public function pay()
    {
        $oid = input('oid','');

        $oinfo = Db::name('advertisement')->where('id', $oid)->find();

        if($oinfo['pay_status'] == 2){
            return $this->fetch('pay/pay_ad_success');
            exit;
        }

        $uid = session('uid');
        $user = Db::table('ny_mobile_user')->where(["id" => $uid])->find();
        if($user['yue'] < $oinfo['price']){
            $this->assign("need_charge", $oinfo['price']-$user['yue']);
            $this->assign("uid", $uid);
            return $this->fetch('pay/charge_tips');
        }else{
            $this->assign("oinfo", $oinfo);
            $this->assign("user", $user);
            return $this->fetch('pay/pay');
            //echo '余额足够';
        }

        // $this->assign("oinfo", $oinfo);
        
        // return $this->fetch('pay/pay');
    }

    public function pay_ad_success(){
        return $this->fetch('pay/pay_ad_success');
    }

    //余额支付广告费
    public function yue_pay_ad(){
        $uid = session('uid');
        $mobile = input('mobile','');
        $code = input('code','');
        $ad_id = input('ad_id','');

        if(empty($uid)){
            $res['code'] = 3;
            $res['msg'] = '登录已失效，请重新登录';
            echo json_encode($res);exit;
        }

        $res = array();
        
        $user = Db::table('ny_mobile_user')->where(['mobile' => $mobile,'cancel' => 1])->find();

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');

        $ad_info = Db::table('ny_advertisement')->where(['id' => $ad_id])->find();
        $price = $ad_info['price'];

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            echo json_encode($res);exit;
        }

        //加setInc，减setDec,对用户余额进行更新
        
        Db::table('ny_mobile_user')->where("id = $uid")->setDec('yue',$price);

        //给余额log添加数据
        $data = array(
                    'uid'=>$uid,
                    'ad_id'=>$ad_info['id'],
                    'action'=>'支付广告费用',
                    'createtime'=>time(),
                    'price'=>$ad_info['price'],
                );

        DB::name('yue_log')->insert($data);

        //修改广告支付状态
        Db::name('advertisement')->where('id', $ad_id)->update(array('pay_status'=>2));

        $res['code'] = 1;
        $res['msg'] = '发布成功';
        echo json_encode($res);exit;
    }



    public function vip()
    {
        $address_id = input('address_id');
        $address = '';
        if($address_id){
            $address = Db::table('ny_address')->where(["id" => $address_id])->find();

            $address['province'] = Db::table('ny_city')->where(["value" => $address['province']])->value('label');
            $address['city'] = Db::table('ny_city')->where(["value" => $address['city']])->value('label');
            $address['district'] = Db::table('ny_city')->where(["value" => $address['district']])->value('label');
        }

        $this->assign("address", $address);
        
        return $this->fetch('pay/pay_vip');
    }

    public function pay_error(){
        return $this->fetch('pay/pay_error');
    }

    //商品付款
    public function show_pay(){
        $go_id = input('go_id');
        
        
        $goods_order = Db::name('goods_order')->where("id = $go_id")->find();
        $uinfo = Db::name('mobile_user')->where("id = ".$goods_order['uid'])->find();
        $address = Db::name('address')->where("id = ".$goods_order['address_id'])->find();

        $province = Db::name('city')->where("value = {$address['province']}")->value('label');
        $city = Db::name('city')->where("value = {$address['city']}")->value('label');
        $district = Db::name('city')->where("value = {$address['district']}")->value('label');
        $address_info = $province.$city.$district.$address['address'];

        $goods_info = Db::name('goods')->where("id = ".$goods_order['goods_id'])->find();

        $this->assign('address',$address);
        $this->assign('goods_info',$goods_info);
        $this->assign('uinfo',$uinfo);
        $this->assign('address_info',$address_info);
        $this->assign('goods_order',$goods_order);
        return $this->fetch('pay/show_pay');
    }

    //商品付款
    public function pay_goods(){
        

        $go_id = input('go_id');

        if(empty($go_id)){
            return $this->fetch('pay/goods_error');
        }

        $order_info = Db::table('ny_goods_order')->where(["id" => $go_id])->find();

        if($order_info['status'] == 2){
            return $this->fetch('pay/goods_success');
        }

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return $this->fetch('pay/goods_error');
        }

        $PayModel = new PayModel(); 

        $PayModel->pay_goods($go_id);

        return ;
    }
    
    public function payvip(){

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return $this->fetch('pay/pay_error');
        }

        $address_id = input('address_id','');

        if(empty($address_id)){
            return $this->fetch('pay/goods_error');
        }

        $PayModel = new PayModel(); 

        $PayModel->payvip($address_id);

        return ;
    }

    //广告发布付费
    public function dopay(){
        $oid = input('oid','');

        $oinfo = Db::name('advertisement')->where('id', $oid)->find();

        $PayModel = new PayModel(); 

        $PayModel->doPay($oinfo);

        return ;
    }

    //余额充值
    public function do_charge(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return $this->fetch('wallet/pay_error');
        }

        $uid = input('uid','');
        $money = input('money','');
        $showTypeInput = input('showTypeInput','');

        if(empty($uid) || empty($money) || empty($showTypeInput)){
            return $this->fetch('pay/goods_error');
        }


        $PayModel = new PayModel(); 

        $PayModel->do_charge($uid,$money,$showTypeInput);
    }

    public function return_url(){
        require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");
        require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");

        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config); 
        $result = $alipaySevice->check($arr);

        if($result) {//验证成功
            return $this->fetch('pay/success');
        }
        else {
            //验证失败
            return $this->fetch('pay/fail');
        }
    }

    public function test(){
        $a = unserialize('a:26:{s:10:"gmt_create";s:19:"2020-06-26 16:54:56";s:7:"charset";s:5:"UTF-8";s:12:"seller_email";s:16:"351638274@qq.com";s:7:"subject";s:5:"1";s:4:"sign";s:344:"AqZZ/78V07frjhnkWlKQ+kOMiwI5h/AapMZMZ2ksEhXYbVF7szapqK1Mmm60IOxGJFkHJ69dGZn2t+rlwoioC4pJQGlIXnsxINckFMoC4G2LpK63/PnR0P2guOtuq5TGZUYxkKGpZf1YTOpIDkmrUsaBV2Byg1YUsJ15QklybKFlUQJ5FaIT612H8KfNHdby/pmrrCFAk/Qfa8j0ade3VQvNRYhwAk3YFnITHJ9WBGy6AbQ6boczVUAYtbF6GPukJrZE28QfjYtiEbpHQ2X9DJDwzUdO/CZ1sViSL+WWJpPQUEtIIBwMCIXiTvlnr2gVkIh1bbeWNbBVcepzmCrvRw==";s:4:"body";s:12:"广告说明";s:8:"buyer_id";s:16:"2088202370901004";s:14:"invoice_amount";s:4:"0.01";s:9:"notify_id";s:34:"2020062600222165457001000526310716";s:14:"fund_bill_list";s:43:"[{"amount":"0.01","fundChannel":"PCREDIT"}]";s:11:"notify_type";s:17:"trade_status_sync";s:12:"trade_status";s:13:"TRADE_SUCCESS";s:14:"receipt_amount";s:4:"0.01";s:16:"buyer_pay_amount";s:4:"0.01";s:6:"app_id";s:16:"2021001163632546";s:9:"sign_type";s:4:"RSA2";s:9:"seller_id";s:16:"2088831483532254";s:11:"gmt_payment";s:19:"2020-06-26 16:54:57";s:11:"notify_time";s:19:"2020-06-26 16:54:57";s:7:"version";s:3:"1.0";s:12:"out_trade_no";s:19:"2020062614422837393";s:12:"total_amount";s:4:"0.01";s:8:"trade_no";s:28:"2020062622001401000532082817";s:11:"auth_app_id";s:16:"2021001163632546";s:14:"buyer_logon_id";s:13:"359***@qq.com";s:12:"point_amount";s:4:"0.00";}');
        var_dump($a);exit;
    }

    public function notify_url(){
        require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");
        require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");


        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config); 
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);


        //DB::name('ewq')->insert(array('content'=>serialize($arr)));

        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            
            //商户订单号

            if($arr['trade_status'] == 'TRADE_SUCCESS'){

                $data = array();
                $data['gmt_create'] = strtotime($arr['gmt_create']);
                $data['seller_email'] = $arr['seller_email'];
                $data['buyer_id'] = $arr['buyer_id'];
                $data['invoice_amount'] = $arr['invoice_amount'];
                $data['notify_id'] = $arr['notify_id'];
                $fund_bill_list = json_decode($arr['fund_bill_list']);
                $fund_bill_list = $fund_bill_list[0];
                
                $data['amount'] = $fund_bill_list->amount;
                $data['fundChannel'] = $fund_bill_list->fundChannel;
                $data['notify_type'] = $arr['notify_type'];
                $data['trade_status'] = $arr['trade_status'];
                $data['receipt_amount'] = $arr['receipt_amount'];
                $data['buyer_pay_amount'] = $arr['buyer_pay_amount'];
                $data['app_id'] = $arr['app_id'];
                $data['seller_id'] = $arr['seller_id'];
                $data['gmt_payment'] = strtotime($arr['gmt_payment']);
                $data['notify_time'] = strtotime($arr['notify_time']);
                $data['out_trade_no'] = $arr['out_trade_no'];
                $data['total_amount'] = $arr['total_amount'];
                $data['trade_no'] = $arr['trade_no'];
                $data['auth_app_id'] = $arr['auth_app_id'];
                $data['buyer_logon_id'] = $arr['buyer_logon_id'];
                $data['point_amount'] = $arr['point_amount'];

                $data['detail'] = $arr['subject'];  //充值动作分为余额充值，VIP升级，商城支付
                

                //更新user表vip状态
                if($data['detail'] == '升级VIP'){

                    $body = $arr['body'];
                    $body_info = explode('@', $body);
                    $data['uid'] = $body_info[0];  //uid


                    //$data['uid'] = $arr['body'];  //uid
                    DB::name('alipay_notify')->insert($data);
                    Db::name('mobile_user')->where('id', $data['uid'])->update(array('level'=>2));

                    //$address = Db::table('ny_address')->where(["id" => $address_id])->find();

                    $vip_update = array(
                                    'uid'=>$body_info[0],
                                    'address_id'=>$body_info[1],
                                    'createtime'=>time(),
                                    'ordersn'=>$arr['out_trade_no'],
                            );
                    DB::name('vip_update')->insert($vip_update);

                    $RuleModel = new RuleModel();
                    $RuleModel::update_income($data['uid']);
                }elseif($data['detail'] == '余额充值'){

                    $body = $arr['body'];
                    $body_info = explode('@', $body);
                    $data['uid'] = $body_info[0];  //uid
                    DB::name('alipay_notify')->insert($data);



                    $money = floor($arr['total_amount']/1.065);
                    Db::name('mobile_user')->where('id', $data['uid'])->setInc('yue',$money);

                    $charge_log = array(
                                    'uid'=>$body_info[0],
                                    'money'=>$money,
                                    'action'=>'余额充值',
                                    'createtime'=>time(),
                                    'is_invoice'=>$body_info[1],
                                    'msg'=>$arr['body']
                                );
                    DB::name('charge_log')->insert($charge_log);


                    $yue_log = array(
                                    'uid'=>$body_info[0],
                                    'price'=>$money,
                                    'action'=>'余额充值',
                                    'createtime'=>time(),
                                    'change'=>2,
                                );
                    DB::name('yue_log')->insert($yue_log);
                    //RuleModel()::update_income($arr['subject']);
                }elseif($data['detail'] == '商品付款'){
                    $go_id = $arr['body'];
                    $goods_order_info = Db::name('goods_order')->where('id', $go_id)->find();
                    $data['uid'] = $goods_order_info['uid'];  //uid
                    DB::name('alipay_notify')->insert($data);


                    //减去积分
                    Db::name('mobile_user')->where('id', $data['uid'])->setDec('jifen',$goods_order_info['jifen']);

                    $jifen_log = array(
                                    'uid'=>$data['uid'],
                                    'number'=>$goods_order_info['jifen'],
                                    'createtime'=>time(),
                                    'from'=>4,
                                );
                    DB::name('jifen_log')->insert($jifen_log);

                    //修改订单状态
                    Db::name('goods_order')->where('id', $go_id)->update(array('status'=>2));
                    $time = time();
                    Db::name('goods_order')->where('id', $go_id)->update(array('pay_time'=>$time));

                    Db::name('goods')->where('id', $goods_order_info['goods_id'])->setDec('stock',1);
                    Db::name('goods')->where('id', $goods_order_info['goods_id'])->setInc('sold',1);
                    RuleModel()::update_income($arr['subject']);
                }

                //DB::name('ewq')->insert(serialize($data));
            }
                
        }else {
            //验证失败
            echo "fail";    //请不要修改或删除

        }
    }
}