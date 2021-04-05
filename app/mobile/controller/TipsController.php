<?php
namespace app\mobile\controller;

use think\DB;

class TipsController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;


    }
    
    public function examine()
    {
        return $this->fetch('tips/examine');
    }

    public function fail()
    {
        return $this->fetch('tips/fail');
    }

    public function success_tip()
    {
        return $this->fetch('tips/success');
    }

    
}