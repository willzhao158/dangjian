<?php
/**
 * Created by sublime.
 * User: xiaoma
 * Date: 2019/11/11
 * Time: 上午 1:36
 */
namespace app\farm\controller;
use app\farm\model\InventoryModel;
use app\farm\model\PurchaseModel;
use app\farm\model\LayuiModel;
Class InventoryController extends FarmbaseController
{
    public function initialize(){
        $this->model = new InventoryModel();
    }

	public function index(){
		// $this->model->tableInventoryView();
        $this->checkSql();
		$this->assign('warehouse',$this->model->getWarehouse());
        return view();
    }

    public function showInventoryDetail(){
    	return $this->model->getInventoryDetail();;
    }

    public function checkSql(){
        $data = $this->model;
        // dump($data);
    }
    
}


