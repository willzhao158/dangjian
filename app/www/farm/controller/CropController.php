<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/21
 * Time: 上午 13:50
 */
namespace app\farm\controller;
use app\farm\model\CropModel;
Class CropController extends FarmbaseController
{
    public $table = 'ny_crop';
    
    public function initialize(){
        $this->model = new CropModel();
    }

    public function index(){
        return view();
    }

    public function add(){
        $this->assign('kind',$this->model->cropkind());
        return view();
    }

    public function edit(){
        $this->assign('kind',$this->model->cropkind());
        $this->assign('data',$this->model->getdatainfo(input()));
        return view();
    }

    public function datalist($islimit=true){
        return $this->model->datalist($islimit);
    }

    public function delaction(){
        if($this->model->checkChild(input())){
            return $this->error('删除失败，请删除子栏目！');
        }
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }

    public function growth(){
        $growthList = $this->model->growthList(input('id'));
        $this->assign('data',$growthList);
        return view();
    }

    public function addgrowth(){
        return view();
    }

    public function addgrowthaction(){
        $this->model->table = 'ny_crop_growth';
        $this->addaction();
    }

    public function editgrowth(){
        $this->model->table = 'ny_crop_growth';
        $data = $this->getdatainfo(input());
        $this->assign('data',$data);
        return view();
    }

    public function editgrowthaction(){
        $this->model->table = 'ny_crop_growth';
        $this->editallaction();
    }

    public function delgrowth(){
        $this->model->table = 'ny_crop_growth';
        if($this->model->deldata(input())){
            return $this->success('删除成功');
        }
        return $this->error('删除失败');
    }

}