<?php
namespace app\mobile\controller;

use think\DB;

class InvoiceController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
    }
    
    public function index()
    {
        $invoice = Db::table('ny_invoice')->where('uid', session('uid'))->find();
        $this->assign("invoice", $invoice);
        return $this->fetch('invoice/index');
    }

    public function add(){
    	$company = input('company','');
        $code = input('code','');
        $mobile = input('mobile','');
        $address = input('address','');
        $bank = input('bank','');
        $bank_code = input('bank_code','');

        $inser_data = array(
                            'company'=>$company,
                            'code'=>$code,
                            'mobile'=>$mobile,
                            'address'=>$address,
                            'bank'=>$bank,
                            'bank_code'=>$bank_code,
                            'createtime'=>time(),
                            'bank_code'=>$bank_code,
                            'uid'=>session('uid')
                        );

        $exit = Db::table('ny_invoice')->where('uid', session('uid'))->find();

        if($exit){
            Db::table('ny_invoice')->where('uid', session('uid'))->update($inser_data);
        }else{
            Db::table('ny_invoice')->insert($inser_data);
        }
        
        echo 1;exit;
    }

}