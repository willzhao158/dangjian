<?php
namespace app\farm\model;
Class InventoryModel extends FarmbaseModel
{
    public $table = 'ny_inventory_detail';

    public function getWarehouse(){
        $this->table = 'ny_warehouse';
        return $this->select()->toArray();
    }
   

    public function tableInventoryView(){
        $sql = $this->alias('a')
                    ->Join('ny_machinery b','a.goods_id=b.id')
                    ->Join('ny_purchase c','a.purchase_id=c.id')
                    ->field('a.*,b.name,b.unit,b.number,b.spec,c.ref,c.delivery,c.supplier_id,c.address,c.contacts,c.phone')
                    ->select(false);

        $view = "Create view ny_inventory as $sql";
        echo $view;
    }
    

    public function datalist($islimit = true){
        $this->table = 'ny_inventory';
        $this->pagecount = Config('page_count');
        $name = input('name','');
        $type = input('type','');
        $warehouseid = input('warehouseid','');
        $where = ' 1=1 ';
        $Name = '';
        if($name){
            $Name .= " and b.name like '%$name%' ";
        }
        $warehouse = '';
        if($warehouseid){
            $warehouse .= " and a.warehouse_id=$warehouseid ";
        }

        $start = ((input('page',1))-1)*$this->pagecount;

        $sql = $this->alias('a')
                     ->leftJoin('ny_machinery b','a.goods_id=b.id'.$name)
                     ->where($where.$warehouse)
                     ->limit($start,$this->pagecount)
                     ->select(false);

        $count = $this->alias('a')
                      ->leftJoin('ny_machinery b','a.goods_id=b.id')
                      ->where($where)
                      ->count();

        $data = $this->alias('a')
                     ->leftJoin('ny_machinery b','a.goods_id=b.id'.$name)
                     ->where($where.$warehouse)
                     ->limit($start,$this->pagecount)
                     ->select()
                     ->toArray();

        return LayuiModel::layuiData($data,$count,$sql);
    }


    public function getInventoryDetail(){
        $this->table = 'ny_inventory_detail';
        $where = [];
        $goods_id = input('goods_id','');
        if($goods_id){
            $where = ['a.goods_id'=>$goods_id,'a.warehouse_id'=>input('warehouse_id')];
        }

        $InventoryDetail = $this->alias('a')
                                ->leftJoin('ny_machinery b','a.goods_id=b.id')
                                ->field('a.*,b.name as bname,b.number')
                                ->where($where)->select()->toArray();
        return LayuiModel::layuiData($InventoryDetail,100,'');
    }



}