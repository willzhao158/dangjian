<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/20
 * Time: 上午 9:20
 */
namespace app\farm\controller;
use app\farm\model\SaleModel;
use app\farm\model\LayuiModel;
Class SaleController extends FarmbaseController
{
    public $model;
    public $table = 'ny_sale';
    public $log = '';
    public function initialize(){
        $this->model = new SaleModel();
    }

    public function index(){

        return view();
    }

    public function add(){
        return view();
    }

    public function edit(){
        $data = $this->model->getsale(input('id'));
    

        $this->assign('data', $data);
        return view();
    }
    
    public function goodslist(){
        return view();

    }

    public function addaction(){
        $add = $this->model->addsale(input());
        if($add){
             $this->log = '采购订单添加成功';
            return $this->success('采购订单添加成功');
        }        
        return $this->error('采购订单添加失败');
    }

    public function editaction(){
        $edit = $this->model->editsale(input());
        if($edit){
            return $this->success('采购订单修改成功');
        }        
        return $this->error('采购订单修改失败');
    }

    public function showsaleDetail(){
        $this->model->table = 'ny_sale_detail';
        return $this->model->getsaleDetail();
    }

    public function delaction(){
        if($this->model->delaction(input('id'))){
            return $this->success('采购订单删除成功');
        }
        return $this->error('采购单删除失败');
    }

    public function examine(){
        if($this->model->examine(input('id'))){
            return $this->success('订单审核通过');
        }
        return $this->error('订单审核失败');
    }

    public function unexamine(){
        if($this->model->unexamine(input('id'))){
            return $this->success('订单已取消审核');
        }
        return $this->error('订单取消审核失败');
    }


    public function warehouse(){

        $this->assign('warehouse',$this->model->getWarehouse());

        return view();
    }


    public function saleInfo(){
        return $this->model->find(input('id'));
    }

    public function __destruct(){
        file_put_contents('./log.txt', $this->log,FILE_APPEND);
    }


 

    public function exWare(){
        $less = $this->model->exWare();
        if($less[0]){
            return $this->success('出库成功');
        }
        return $this->error($less[1]);
    }
    
}


