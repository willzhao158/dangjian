<?php
namespace app\mobile\controller;

use think\DB;

class MessageController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        //$model = new UserModel();
        // $model->table= $this->table;
        //$this->model = $model;


    }
    
    public function index(){
        $anounces = Db::table('ny_anounce')->order("createtime", "desc")->all()->toArray();
        $this->assign("anounces", $anounces);
        return $this->fetch('message/index');
    }

    public function detail(){
        $id = input('id','');
        $anounce = Db::table('ny_anounce')->where(['id'=>$id])->find();
        $this->assign("anounce", $anounce);
        return $this->fetch('message/detail');
    }

}