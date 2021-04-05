<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/9/20
 * Time: 上午 9:20
 */
namespace app\farm\controller;
use app\farm\model\PurchaseModel;
use app\farm\model\LayuiModel;
Class PurchaseController extends FarmbaseController
{
    public $model;
    public $table = 'ny_purchase';
    public $log = '';
    public function initialize(){
        $this->model = new PurchaseModel();
    }

	public function index(){

        return view();
    }

    public function add(){
        return view();
    }

    public function edit(){
        $data = $this->model->getpurchase(input('id'));
    

        $this->assign('data', $data);
        return view();
    }
	
    public function goodslist(){
        return view();

    }

    public function addaction(){
        $add = $this->model->addpurchase(input());
        if($add){
             $this->log = '采购订单添加成功';
            return $this->success('采购订单添加成功');
        }        
        return $this->error('采购订单添加失败');
    }

    public function editaction(){
        $edit = $this->model->editpurchase(input());
        if($edit){
            return $this->success('采购订单修改成功');
        }        
        return $this->error('采购订单修改失败');
    }

    public function showPurchaseDetail(){
        $this->model->table = 'ny_purchase_detail';
        return $this->model->getPurchaseDetail();
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


    public function PurchaseInfo(){
        return $this->model->find(input('id'));
    }

    public function __destruct(){
        file_put_contents('./log.txt', $this->log,FILE_APPEND);
    }


    //入库操作
    public function addWarehouseData(){
        $add = $this->model->addWarehouseData();
        if($add){
            return $this->success('入库成功');
        }
        return $this->error('入库失败');
    }

    
}


