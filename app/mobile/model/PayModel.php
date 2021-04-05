<?php
namespace app\mobile\model;

use think\Model;
use think\Db;

Class PayModel extends Model
{

        public function build_order_no(){
                /* 选择一个随机的方案 */
                mt_srand((double) microtime() * 1000000);
                return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }

        //余额提现
        public function yue_cash($uid,$cash_number){
                
        }

        //商品付款
        public function pay_goods($go_id){
                $ordersn = $this->build_order_no();
                $oinfo = Db::name('goods_order')->where('id', $go_id)->find();
                header("Content-type: text/html; charset=utf-8");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");

                //商户订单号，商户网站订单系统中唯一订单号，必填
                $out_trade_no = $ordersn;

                //订单名称，必填
                $subject = '商品付款';

                //付款金额，必填
                $total_amount = $oinfo['price'];

                //$total_amount = 0.01;

                //商品描述，可空
                $body = $go_id;

                //超时时间
                $timeout_express="1m";

                $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
                $payRequestBuilder->setBody($body);
                $payRequestBuilder->setSubject($subject);
                $payRequestBuilder->setOutTradeNo($out_trade_no);
                $payRequestBuilder->setTotalAmount($total_amount);
                $payRequestBuilder->setTimeExpress($timeout_express);

                $payResponse = new \AlipayTradeService($config);
                $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

                return ;
        }

        //升级VIP
        public function payvip($address_id){

                $ordersn = $this->build_order_no();
                $address = Db::table('ny_address')->where(["id" => $address_id])->find();


                // $data = array(
                //                 'uid'=>$address['uid'],
                //                 'address_id'=>$address_id,
                //                 'createtime'=>time(),
                //                 'ordersn'=>$ordersn
                //         );
                // $insert_id = DB::name('vip_update')->insertGetId($data);

                header("Content-type: text/html; charset=utf-8");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");

                //商户订单号，商户网站订单系统中唯一订单号，必填
                $out_trade_no = $ordersn;

                //订单名称，必填
                $subject = '升级VIP';

                //付款金额，必填
                //$total_amount = $oinfo['price'];

                $total_amount = 660;

                //商品描述，可空
                $body = $address['uid']."@".$address_id;

                //超时时间
                $timeout_express="1m";

                $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
                $payRequestBuilder->setBody($body);
                $payRequestBuilder->setSubject($subject);
                $payRequestBuilder->setOutTradeNo($out_trade_no);
                $payRequestBuilder->setTotalAmount($total_amount);
                $payRequestBuilder->setTimeExpress($timeout_express);

                $payResponse = new \AlipayTradeService($config);
                $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

                return ;
        }

	public function doPay($oinfo){
		header("Content-type: text/html; charset=utf-8");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");

                //商户订单号，商户网站订单系统中唯一订单号，必填
                $out_trade_no = $oinfo['ordersn'];

                //订单名称，必填
                $subject = $oinfo['uid'];

                //付款金额，必填
                $total_amount = $oinfo['price'];

                //$total_amount = 0.01;

                //商品描述，可空
                $body = '广告发布';

                //超时时间
                $timeout_express="1m";

                $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
                $payRequestBuilder->setBody($body);
                $payRequestBuilder->setSubject($subject);
                $payRequestBuilder->setOutTradeNo($out_trade_no);
                $payRequestBuilder->setTotalAmount($total_amount);
                $payRequestBuilder->setTimeExpress($timeout_express);

                $payResponse = new \AlipayTradeService($config);
                $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

                return ;
	}



        //余额充值
        public function do_charge($uid,$money,$showTypeInput){
                header("Content-type: text/html; charset=utf-8");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/service/AlipayTradeService.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php");
                require_once($_SERVER['DOCUMENT_ROOT']."../vendor/alipay/config.php");

                //商户订单号，商户网站订单系统中唯一订单号，必填
                $out_trade_no = $this->build_order_no();

                //订单名称，必填
                $body = $uid.'@'.$showTypeInput;

                //付款金额，必填
                $total_amount = round($money*1.065,2);

                //var_dump($total_amount);exit;

                //$total_amount = 0.01;

                //商品描述，可空
                $subject = '余额充值';

                //超时时间
                $timeout_express="1m";

                $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
                $payRequestBuilder->setBody($body);
                $payRequestBuilder->setSubject($subject);
                $payRequestBuilder->setOutTradeNo($out_trade_no);
                $payRequestBuilder->setTotalAmount($total_amount);
                $payRequestBuilder->setTimeExpress($timeout_express);

                $payResponse = new \AlipayTradeService($config);
                $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

                return ;
        }

        
}