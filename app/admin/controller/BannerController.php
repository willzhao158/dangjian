<?php
namespace app\admin\controller;

use app\admin\model\OrderModel;

class BannerController extends BaseController
{
    private $pagecount;
    //数据表名
    public $table = 'ny_banner';

    public $userinfo = '';

    public function initialize(){
        parent::initialize();
        $model = new OrderModel();
        $model->table= $this->table;
        $this->model = $model;
    }

    public function edit(){
        $data = $this->model->getdatainfo(input());
        $this->assign('data',$data);
        return $this->fetch('banner/edit');
        return view();
    }

    public function index(){
        return $this->fetch('banner/index');
    }

    public function add(){
        
        return view();
    }
}