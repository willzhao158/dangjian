<?php
namespace app\admin\controller;

use app\admin\model\OrderModel;

class IndexController extends BaseController
{
    private $pagecount;
    //数据表名
    public $table = 'ny_order';

    public $userinfo = '';

    public function initialize(){
        // parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;
    }

    public function index(){
        return $this->fetch('index/index');
    }

    public function question(){
        return $this->fetch('index/question');
    }

    public function banner(){

        return $this->fetch('banner/index');
    }

    
}