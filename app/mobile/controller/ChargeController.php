<?php
namespace app\mobile\controller;

use think\DB;

class ChargeController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;


    }
    
    public function index()
    {
        
        return $this->fetch('charge/index');
    }

    
}