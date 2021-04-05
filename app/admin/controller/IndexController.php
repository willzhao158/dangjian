<?php
namespace app\admin\controller;

use think\Db;

class IndexController extends BaseController
{

    public function initialize(){
        parent::initialize();
    }

    public function index(){
        $uid = cmf_get_current_admin_id();
        $this->assign('uid',$uid);
        return $this->fetch('index/index');
    }

    public function banner(){

        return $this->fetch('banner/index');
    }

    

    
}