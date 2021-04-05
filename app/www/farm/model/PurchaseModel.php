<?php
namespace app\farm\model;
use think\Db;
Class PurchaseModel extends FarmbaseModel
{
    public $table = 'ny_purchase';
    public $purchase_detail = 'ny_purchase_detail';
	private function handle_data($data){
        $detail = [];
        foreach($data as $k=>$v){
            if(is_array($v)){
                $detail[$k] = $v;
                unset($data[$k]);
            }
        }
        $array = [];
        $j = 0;
        $keys = array_keys($detail);

        $count = count($detail[$keys[0]]);
        for($i=0;$i<$count;$i++){
            $arr = [];
            foreach($keys as $value){
                $arr[$value] = $detail[$value][$i];
            }
            $array[] = $arr;
        }
        return array(
        	'purchase' => $data,
        	'purchase_detail' => $array
        );
    }
	
    public function addpurchase($data){
    	$res = $this->handle_data($data);
        $res['purchase']['ref'] = date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        // $res['purchase']['delivery'] = strtotime($res['purchase']['delivery']);
    	$purchaseId = $this->save($res['purchase']);

        if($purchaseId){
    		foreach($res['purchase_detail'] as $k=>$v){
                unset($res['purchase_detail'][$k]['goods_name']);
    			$res['purchase_detail'][$k]['purchase_id'] = $this->id;
    		}
            $this->table = $this->purchase_detail;
            $this->insertAll($res['purchase_detail']);
    	}
    	return $this->id;
    }

    public function editpurchase($data){
        $res = $this->handle_data($data);
        $this->startTrans();
        try {
            $purchaseId = $res['purchase']['id'];
            $this->save($res['purchase'],['id'=>$purchaseId]);

            foreach($res['purchase_detail'] as $k=>$v){
                unset($res['purchase_detail'][$k]['goods_name']);
                $res['purchase_detail'][$k]['purchase_id'] = $purchaseId;
            }

            $this->table = $this->purchase_detail;
            $this->where(['purchase_id'=>$purchaseId])->delete();
            $this->insertAll($res['purchase_detail']);
            $this->commit();

            return true;
           
        } catch (Exception $e) {
            $this->rollback();
            return false;   
        }
    }

    public function delaction($id){
        $this->startTrans();
        try{
            $this->where(['id'=>['in',$id]])->delete();
            $this->table = $this->purchase_detail;
            $this->where(['purchase_id'=>['in',$id]])->delete();
            $this->commit();
            return true;
        }catch(Exception $e){
            $this->rollback();
            return false;
        }
    }

    public function datalist($islimit=true){
        $this->pagecount = Config('page_count');
        $name = input('name','');
        $type = input('type','');
        $purchase_id = input('purchase_id','');
      

        $where = ' 1=1 ';

        // if(session('company')!=0){
        //  $where .= " and companyid=".session('companyid');
        // }
        if($name){
            $where .= " and name like '%$name%' ";
        }
        if($type!=''){
            $where .= " and type=$type ";
        }

        if($purchase_id){
            $where .= " and purchase_id=$purchase_id  ";
        }


      
        $start = ((input('page',1))-1)*$this->pagecount;
        $count = $this->where($where)->count();
        $data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
        $sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
        return LayuiModel::layuiData($data,$count,$sql);
    }   


    public function getpurchase($id){
        $purchase = $this->find($id);
        $this->table = 'ny_purchase_detail';
        $purchase_detail = $this
                                ->alias('a')
                                ->join('ny_machinery b','a.goods_id=b.id')
                                ->where("a.purchase_id=$id")
                                ->field('a.*,b.name as goods_name')
                                ->select()
                                ->toArray();


        return array(
            'purchase' => $purchase, 
            'purchase_detail' => $purchase_detail 
        );
    }


    public function examine($id){
        return $this->save(
            ['status' => 1],
            ['id'   =>  $id]
        );
    }

    public function unexamine($id){
        return $this->save(
            ['status' => 0],
            ['id'   =>  $id]
        );
    }


    public function addWarehouseData(){
        $id = input('id',36);
        $data = $this->getpurchase($id);

        $warehouseId = input('warehouseid','');

        //将订单中的相同商品的数量整合
        $goods = [];
        foreach($data['purchase_detail'] as $v){
            if(!isset($goods[$v['goods_id']])){
                $goods[$v['goods_id']] = $v;
            }else{
                $goods[$v['goods_id']]['goods_count'] += $v['goods_count'];
                $goods[$v['goods_id']]['goods_money'] += $v['goods_money'];
            }
        }


        $this->startTrans();
        try{
            //分别给入库单的商品数据处理 及入库操作
            $inventoryOrderDetail = [];
            foreach($goods as $v){
                $order = [];
                $order['goods_id'] = $v['goods_id'];
                $order['goods_count'] = $v['goods_count'];
                $order['goods_price'] = $v['goods_price'];
                $order['goods_money'] = $v['goods_money'];
                $order['order_id'] = $data['purchase']['id'];
                $order['warehouse_id'] = $warehouseId;
                $order['type'] = 'purchase';

                $inventoryOrderDetail[] = $order;
            }
            /**
             * 增加已经入库后总的数量 金额 仓库存放仓库总表
             */
            $this->addInventoryAll($inventoryOrderDetail);

            $changeStatus = $this->update(array(
                'id' => $id,
                'status' => 2
            ));

            $this->table = 'ny_inventory_detail';
            $this->insertAll($inventoryOrderDetail);
            $this->commit();
            return true;
        }catch(Exception $e){
            $this->rollback();
            return false;
        }

    }

    private function addInventoryAll($inventoryOrderDetail){
        $this->table = 'ny_inventory';

        foreach ($inventoryOrderDetail as $order) {
            $where = ['goods_id'=>$order['goods_id'],'warehouse_id'=>$order['warehouse_id']];
            $findOld = $this->where($where)->find();
            if($findOld){
                $this->save([
                    'goods_count' =>  $order['goods_count']+$findOld['goods_count'],
                    'goods_money' =>  $order['goods_money']+$findOld['goods_money'],
                ],['id'=>$findOld['id']]);
            }else{
                unset($order['goods_price']);
                unset($order['purchase_id']);
                unset($order['type']);
                $res = $this->insert($order);
            }
        }
    }



    public function getPurchaseDetail(){
        $this->table = "ny_purchase_detail";
        $purchase_id = input('purchase_id','');
        $where = ' 1=1 ';
        if($purchase_id){
            $where .= " and a.purchase_id=$purchase_id  ";
        }

        $goods_id = input('goods_id','');
        if($goods_id){
            $where .= " and a.goods_id=$goods_id  ";
        }


        $data = $this->alias('a')
                     ->join('ny_machinery b','a.goods_id=b.id')
                     ->where($where)
                     ->select()
                     ->toArray();

        $sql = $this->alias('a')
                     ->join('ny_machinery b','b.goods_id=b.id')
                     ->where($where)
                     ->select(false);
        return LayuiModel::layuiData($data,'',$sql);
    }

    public function getWarehouse(){
        $this->table = 'ny_warehouse';
        return $this->select()->toArray();
    }


    
}