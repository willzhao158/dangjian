<?php
namespace app\mobile\controller;

use think\DB;

class WechatController extends BaseController
{
    

    public function initialize(){
    }
    
    public function wechat()
    {
    	$controller=request()->controller();
        $this->assign('controller',$controller);
        return $this->fetch('qrcode/wechat');
    }
    
}