<?php
namespace app\mobile\controller;

use think\DB;

class AdvertisementController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
    }
    
    public function index()
    {
        return $this->fetch('advertisement/publish');
    }

}