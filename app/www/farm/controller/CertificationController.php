<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
use app\farm\model\CertificationModel;
use think\Db;
use think\Config;
Class CertificationController extends FarmbaseController
{
    public $table = 'ny_certification';
    
    public function initialize(){
        $this->model = new CertificationModel();
    }

    public function index(){
        return view();
    }

    public function add(){
        $this->assign('type',$this->getCertificationType());
        $this->assign('place',$this->getPlace());
        return view();
    }

    public function edit(){
        $data = $this->model->getdatainfo(input());
        $this->assign('data',$data[0]);
        $this->assign('detail',json_encode($data[1]));
        return view();
    }

    private function getCertificationType(){
        $this->model->table = 'ny_certification_type';
        return $this->model->datalist(false);
    }

    private function getPlace(){
        $this->model->table = 'ny_place';
        return $this->model->datalist(false);
    }

}