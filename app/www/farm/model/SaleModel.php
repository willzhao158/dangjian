<?php
namespace app\farm\model;
use think\Db;
Class SaleModel extends FarmbaseModel
{
    public $table = 'ny_sale';
    public $sale_detail = 'ny_sale_detail';
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
        	'sale' => $data,
        	'sale_detail' => $array
        );
    }
	
    public function addsale($data){
    	$res = $this->handle_data($data);
        $res['sale']['ref'] = date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        // $res['sale']['delivery'] = strtotime($res['sale']['delivery']);
    	$saleId = $this->save($res['sale']);

        if($saleId){
    		foreach($res['sale_detail'] as $k=>$v){
                unset($res['sale_detail'][$k]['goods_name']);
    			$res['sale_detail'][$k]['sale_id'] = $this->id;
    		}
            $this->table = $this->sale_detail;

            $this->insertAll($res['sale_detail']);

    	}

    	return $this->id;
    }

    public function editsale($data){
        $res = $this->handle_data($data);
        $this->startTrans();
        try {
            $saleId = $res['sale']['id'];
            $this->save($res['sale'],['id'=>$saleId]);

            foreach($res['sale_detail'] as $k=>$v){
                unset($res['sale_detail'][$k]['goods_name']);
                $res['sale_detail'][$k]['sale_id'] = $saleId;
            }

            $this->table = $this->sale_detail;
            $this->where(['sale_id'=>$saleId])->delete();
            $this->insertAll($res['sale_detail']);
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
            $this->table = $this->sale_detail;
            $this->where(['sale_id'=>['in',$id]])->delete();
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
        $sale_id = input('sale_id','');
      

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

        if($sale_id){
            $where .= " and sale_id=$sale_id  ";
        }


      
        $start = ((input('page',1))-1)*$this->pagecount;
        $count = $this->where($where)->count();
        $data = $this->where($where)->limit($start,$this->pagecount)->select()->toArray();
        $sql = $this->where($where)->limit($start,$this->pagecount)->select(false);
        return LayuiModel::layuiData($data,$count,$sql);
    }   


    public function getsale($id){
        $sale = $this->find($id);
        $this->table = 'ny_sale_detail';
        $sale_detail = $this
                                ->alias('a')
                                ->join('ny_machinery b','a.goods_id=b.id')
                                ->where("a.sale_id=$id")
                                ->field('a.*,b.name as goods_name')
                                ->select()
                                ->toArray();


        return array(
            'sale' => $sale, 
            'sale_detail' => $sale_detail 
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


    private function checkWarehouseGoodsEnough(){
        $id = input('id',4);
        $warehouseId = input('warehouseid',12);

        //??????????????????????????????
        $this->sale = $sale = $this->getSaleInfo($id);
        
        //??????????????????????????????
        $warehouseGoods = $this->getInventoryGoods($warehouseId);
        
        //???????????????ID
        $saleData = [];

        //??????????????????ID
        $inventoryData = [];

        //??????
        $noEnough = [];

        //???????????????????????????????????????????????????
        foreach($sale as $value){
            $saleData[] = $goodsId = $value['goods_id'];
            $goodsCount = $value['goods_count'];
            foreach($warehouseGoods as $v){
                $inventoryData[] = $v['goods_id'];
                if($v['goods_id'] == $goodsId){
                    if($v['goods_count'] < $value['goods_count']){
                        $noEnough[] = $v['name'];
                    }
                }
            }
        }

        $isexists = [];
        //????????????????????????????????????
        foreach($saleData as $value){
            if(!in_array($value, $inventoryData)){
                $isexists[] = $value;
            }
        }

        $allGoods = $this->getMachinery();
        $noExistsName = [];
        foreach($isexists as $value){
            foreach($allGoods as $v){
                if($value == $v['id']){
                    $noExistsName[] = $v['name'];
                }
            }
        }

        $message = '';
        $message .= !empty($noEnough)==true?'?????? [ '.implode(' ', $noEnough).' ] ???????????? , ':'';
        $message .= !empty($noExistsName)==true?'?????? [ '.implode(' ', $noExistsName).' ] ????????????':'';

        return $message;
    }


    public function exWare(){
        //??????????????????????????????????????????
        $message = $this->checkWarehouseGoodsEnough();
        if($message){
            return [false,$message];
        }

        $add = $this->CreateCheckout();
        if($add){
            return [true,''];
        }
        return [false,''];

    }


    //????????????
    private function CreateCheckout(){
        $id = input('id',4);
        $warehouseId = input('warehouseid',12);

        //??????????????????????????????
        $sale = $this->getSaleInfo($id);
        
        $inventoryOrderDetail = [];

        $this->startTrans();
        try {
            //?????????????????????
            $this->update(array(
                'id' => $id,
                'status' => 2
            ));

            foreach($sale as $v){
                $order = [];
                $order['goods_id'] = $v['goods_id'];
                $order['goods_count'] = $v['goods_count'];
                $order['goods_money'] = $v['goods_money'];
                $order['order_id'] = $v['sale_id'];
                $order['warehouse_id'] = $warehouseId;
                $order['type'] = 'sale';

                $inventoryOrderDetail[] = $order;

                //??????????????????????????????
                $update = [
                    'goods_count' => ['dec', $v['goods_count']],
                    'goods_money' => ['dec', $v['goods_money']]
                ];
                $where = array(
                    'goods_id' => $v['goods_id'],
                    'warehouse_id' => $warehouseId
                );
                $this->table = 'ny_inventory';
                $this->where($where)->update($update);
            }
            //????????????????????????
            $this->table = 'ny_inventory_detail';
            $this->insertAll($inventoryOrderDetail);


            $this->commit();
            return true;

        }catch (Exception $e) {
            $this->rollback();
            return false;   
        }
    }



    private function getSaleInfo($sale_id){
        $this->table = $this->sale_detail;
        return $this->where(['sale_id'=>$sale_id])->select();
    }


    //?????? ???????????????????????? ??? ??????
    private function getInventoryGoods($warehouseId){
        $this->table = 'ny_inventory';
        return $this->field('*,sum(goods_count) as goodscount,sum(goods_money) as goodsmoney')
                    ->where(['warehouse_id'=>$warehouseId])
                    ->group('goods_id')
                    ->select();
    }

    //??????????????????
    private function getMachinery(){
        $this->table = 'ny_machinery';
        return $this->field('id,name')->select();
    }




    public function getsaleDetail(){
        $this->table = "ny_sale_detail";
        $sale_id = input('sale_id','');
        $where = ' 1=1 ';
        if($sale_id){
            $where .= " and a.sale_id=$sale_id  ";
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