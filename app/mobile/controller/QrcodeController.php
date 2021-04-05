<?php
namespace app\mobile\controller;

use think\DB;

class QrcodeController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
    }
    
    public function index()
    {
        $controller=request()->controller();
        $this->assign('controller',$controller);
        $uid = session('uid');
        $this->assign('uid',$uid);
        return $this->fetch('qrcode/index');
    }

    public function wechat()
    {
    	$controller=request()->controller();
        $this->assign('controller',$controller);
        return $this->fetch('qrcode/wechat');
    }
    
}