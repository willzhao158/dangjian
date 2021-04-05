<?php

namespace app\mobile\controller;

use think\DB;
use app\mobile\model\CityModel;

class AddressController extends BaseController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function address_list(){

        $address_list = Db::table('ny_address')->where(["uid" => session('uid')])->order('isdefault asc,createtime desc')->all()->toArray();

        foreach ($address_list as $key => $value) {
            $province = $value['province'];
            $city = $value['city'];
            $district = $value['district'];

            $address_list[$key]['province'] = Db::table('ny_city')->where(["value" => $value['province']])->value('label');
            $address_list[$key]['city'] = Db::table('ny_city')->where(["value" => $value['city']])->value('label');
            $address_list[$key]['district'] = Db::table('ny_city')->where(["value" => $value['district']])->value('label');
        }

        $this->assign("address_list", $address_list);

        return $this->fetch('address/address_list');

    }

    public function address_add(){

        $city = CityModel::getAll();

        $this->assign("city", json_encode($city));

        return $this->fetch('address/address_add');

    }

    public function address_edit(){

        $id = input('id','');

        $address = Db::table('ny_address')->where('id', $id)->find();

        $address['city_id'] = $address['province'].','.$address['city'].','.$address['district'];

        $address['province_name'] = Db::table('ny_city')->where(["value" => $address['province']])->value('label');
        $address['city_name'] = Db::table('ny_city')->where(["value" => $address['city']])->value('label');
        $address['district_name'] = Db::table('ny_city')->where(["value" => $address['district']])->value('label');



        $this->assign("address", $address);


        $city = CityModel::getAll();

        $this->assign("allcity", json_encode($city));
        $this->assign("id", $id);

        return $this->fetch('address/address_edit');

    }

    public function edit(){
        $id = input('id','');
        $name = input('name','');
        $mobile = input('mobile','');
        $address = input('address','');
        $city = input('city','');
        $isdefault = input('isdefault','');

        $city_arr = explode(',',$city);
        $province = $city_arr[0];
        $city = $city_arr[1];
        $district = $city_arr[2];



        $inser_data = array(
                            'id'=>$id,
                            'mobile'=>$mobile,
                            'name'=>$name,
                            'address'=>$address,
                            'province'=>$province,
                            'city'=>$city,
                            'district'=>$district,
                            'createtime'=>time(),
                            'isdefault'=>$isdefault,
                            'uid'=>session('uid')
                        );

        if($isdefault == 1){
            Db::table('ny_address')->where('uid', session('uid'))->update(array('isdefault'=>2));
        }
        
        Db::table('ny_address')->update($inser_data);
        echo 1;exit;
    }

    public function delete(){
        $id = input('id','');
        Db::table('ny_address')->where(["id" => $id])->delete();
        echo 1;exit;
    }

    public function add(){
        $name = input('name','');
        $mobile = input('mobile','');
        $address = input('address','');
        $city = input('city','');
        $isdefault = input('isdefault','');

        $city_arr = explode(',',$city);
        $province = $city_arr[0];
        $city = $city_arr[1];
        $district = $city_arr[2];



        $inser_data = array(
                            'mobile'=>$mobile,
                            'name'=>$name,
                            'address'=>$address,
                            'province'=>$province,
                            'city'=>$city,
                            'district'=>$district,
                            'createtime'=>time(),
                            'isdefault'=>$isdefault,
                            'uid'=>session('uid')
                        );

        if($isdefault == 1){
            Db::table('ny_address')->where('uid', session('uid'))->update(array('isdefault'=>2));
        }
        
        Db::table('ny_address')->insert($inser_data);
        echo 1;exit;
    }
}