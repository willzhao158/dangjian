<?php
namespace app\mobile\controller;

use think\DB;

class MallController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        //$model = new UserModel();
        // $model->table= $this->table;
        //$this->model = $model;


    }

    public function all_hot(){
        $hot_goods = Db::name('goods')->where("hot = 2")->all()->toArray();

        foreach ($hot_goods as $key => $value) {
            $imgs_arr = explode(',', $value['imgs']);
            $hot_goods[$key]['cover'] = $imgs_arr[0];
        }

        $this->assign('hot_goods',$hot_goods);
        return $this->fetch('mall/mall_all_hot');
    }

    public function all_recommended(){
        $recommended_goods = Db::name('goods')->where("recommended = 2")->all()->toArray();
        foreach ($recommended_goods as $key => $value) {
            $imgs_arr = explode(',', $value['imgs']);
            $recommended_goods[$key]['cover'] = $imgs_arr[0];
        }

        $this->assign('recommended_goods',$recommended_goods);
        return $this->fetch('mall/mall_all_recommended');
    }

    public function make_order(){
        $number = input('number');
        $address_id = input('address_id');
        $goods_id = input('goods_id');
        $uid = session('uid');
        $need_price = input('need_price');
        $need_jifen = input('need_jifen');
        $remark = input('remark');

        $uinfo = Db::name('mobile_user')->where("id = $uid")->find();

        $ginfo = Db::name('goods')->where("id = $goods_id")->find();

        $res = array();

        if(empty($uid)){
            $res['code'] = 3;
            $res['msg'] = '请重新登录';
            return $res;
        }

        if($uinfo['jifen'] < $need_jifen){
            $res['code'] = 2;
            $res['msg'] = '您所需兑换的积分不足';
            return $res;
        }

        if($ginfo['stock'] < $number){
            $res['code'] = 2;
            $res['msg'] = '库存不足';
            return $res;
        }


        $data = array(
                    'number'=>$number,
                    'address_id'=>$address_id,
                    'goods_id'=>$goods_id,
                    'createtime'=>time(),
                    'uid'=>$uid,
                    'price'=>$need_price,
                    'jifen'=>$need_jifen,
                    'remark'=>$remark,
                );

        $go_id = Db::name('goods_order')->insertGetId($data);

        $res['code'] = 1;
        $res['msg'] = '';
        $res['go_id'] = $go_id;
        return $res;
    }

    public function test1(){
        Db::name('goods_order')->where('id', 17)->update(array('pay_time'=>32321));
    }
    
    public function index(){
        // $controller=request()->controller();
        // $this->assign('controller',$controller);
        //return $this->fetch('mall/test');exit;
        $hot_goods = Db::name('goods')->where("hot = 2")->limit(4)->all()->toArray();

        foreach ($hot_goods as $key => $value) {
            $imgs_arr = explode(',', $value['imgs']);
            $hot_goods[$key]['cover'] = $imgs_arr[0];
        }

        $recommended_goods = Db::name('goods')->where("recommended = 2")->limit(4)->all()->toArray();
        foreach ($recommended_goods as $key => $value) {
            $imgs_arr = explode(',', $value['imgs']);
            $recommended_goods[$key]['cover'] = $imgs_arr[0];
        }

        $this->assign('hot_goods',$hot_goods);
        $this->assign('recommended_goods',$recommended_goods);
        return $this->fetch('mall/mall_index');
    }

    public function list(){
        
        $goods_type_id = input('goods_type_id');

        $where = " 1=1";
        if(!empty($goods_type_id)){
            $where .= " and goods_type = $goods_type_id";
        }

        $goods = Db::name('goods')->where($where)->all()->toArray();

        foreach ($goods as $key => $value) {
            $imgs_arr = explode(',', $value['imgs']);
            $goods[$key]['cover'] = $imgs_arr[0];
        }

        $goods_type = Db::name('goods_type')->all()->toArray();
        $goods_type_arr = array();
        $goods_type_arr[0]['value'] = '';
        $goods_type_arr[0]['label'] = '全部';
        foreach ($goods_type as $key => $value) {
            $goods_type_arr[$key+1]['value'] = $value['id'];
            $goods_type_arr[$key+1]['label'] = $value['name'];
        }
        $this->assign('goods_type_arr',json_encode($goods_type_arr));
        $this->assign('goods',$goods);

        $type_id = empty($goods_type_id) ? '' : $goods_type_id;
        $this->assign('type_id',$type_id);

        
        return $this->fetch('mall/mall_list');
    }

    public function select_address(){
        $id = input('id','');

        $address_list = Db::table('ny_address')->where(["uid" => session('uid')])->order('isdefault asc,createtime desc')->all()->toArray();

        foreach ($address_list as $key => $value) {
            $province = $value['province'];
            $city = $value['city'];
            $district = $value['district'];

            $address_list[$key]['province'] = Db::table('ny_city')->where(["value" => $value['province']])->value('label');
            $address_list[$key]['city'] = Db::table('ny_city')->where(["value" => $value['city']])->value('label');
            $address_list[$key]['district'] = Db::table('ny_city')->where(["value" => $value['district']])->value('label');
        }
        $this->assign("id", $id);
        $this->assign("address_list", $address_list);

        return $this->fetch('mall/address_list');
    }

    public function mall_order(){
        // $controller=request()->controller();
        // $this->assign('controller',$controller);
        // 
        $uid = session('uid');
        $uinfo = Db::name('mobile_user')->where("id = $uid")->find();
        $id = input('id');
        $address_id = input('address_id');
        $goods = Db::name('goods')->where("id = $id")->find();
        $this->assign('goods',$goods);
        $banners = explode(',', $goods['imgs']);
        $this->assign('banners',$banners);
        $this->assign('address_id',$address_id);

        if(!empty($address_id)){
            $address = Db::name('address')->where("id = $address_id")->find();
            $province = Db::name('city')->where("value = {$address['province']}")->value('label');
            $city = Db::name('city')->where("value = {$address['city']}")->value('label');
            $district = Db::name('city')->where("value = {$address['district']}")->value('label');
            $address_info = $province.$city.$district.$address['address'];
            $this->assign('address_info',$address_info);
        }
        $this->assign('uinfo',$uinfo);
        return $this->fetch('mall/mall_order');
    }

}