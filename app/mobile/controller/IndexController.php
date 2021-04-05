<?php
namespace app\mobile\controller;

use think\DB;

class IndexController extends BaseController
{
    

    public function initialize(){
        //parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;


    }
    
    public function index()
    {
        

        // $banners = Db::table('ny_banner')->all()->toArray();
        // $this->assign("banners", $banners);

        // $all_classify = Db::table('ny_classify')->where('parent', 0)->all()->toArray();
        // $this->assign("all_classify", $all_classify);

        // $anounces = Db::table('ny_anounce')->all()->toArray();
        // $this->assign("anounces", $anounces);

        return $this->fetch('index/index');
    }

    
}