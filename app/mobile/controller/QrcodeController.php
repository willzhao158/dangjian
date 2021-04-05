<?php
namespace app\mobile\controller;

use think\DB;

class QrcodeController extends BaseController
{
    

    public function initialize(){

    }
    
    public function index()
    {
    	$controller=request()->controller();
        $this->assign('controller',$controller);
        return $this->fetch('qrcode/index');
    }


    
}