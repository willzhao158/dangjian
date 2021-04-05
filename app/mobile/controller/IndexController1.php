<?php
namespace app\mobile\controller;

use think\DB;

class IndexController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        // $model = new OrderModel();
        // $model->table= $this->table;
        // $this->model = $model;

    }
    
    public function index()
    {
     
        

        $banners = Db::table('ny_banner')->all()->toArray();
        $this->assign("banners", $banners);

        $all_classify = Db::table('ny_classify')->where("parent = 0")->order('sort asc')->all()->toArray();

        $this->assign("all_classify", $all_classify);

        $anounces = Db::table('ny_anounce')->all()->toArray();
        $this->assign("anounces", $anounces);

        return $this->fetch('index/index');
    }

    public function index_second()
    {
        $kind1 = input('kind1');
        $this->assign("kind1", $kind1);

        $classify = Db::table('ny_classify')->where("id = $kind1")->find();
        $this->assign("classify", $classify);

        $banners = Db::table('ny_banner')->all()->toArray();
        $this->assign("banners", $banners);

        $all_classify = Db::table('ny_classify')->where("parent = $kind1")->order('sort asc')->all()->toArray();

        $this->assign("all_classify", $all_classify);

        $anounces = Db::table('ny_anounce')->all()->toArray();
        $this->assign("anounces", $anounces);

        return $this->fetch('index/index_second');
    }

    public function index_third()
    {
        $kind1 = input('kind1');
        $kind2 = input('kind2');
        $this->assign("kind1", $kind1);
        $this->assign("kind2", $kind2);

        $classify = Db::table('ny_classify')->where("id = $kind2")->find();
        $this->assign("classify", $classify);

        $banners = Db::table('ny_banner')->all()->toArray();
        $this->assign("banners", $banners);

        // $all_classify = Db::table('ny_classify')->where("parent = 0")->order('sort asc')->all()->toArray();

        // $this->assign("all_classify", $all_classify);

        $anounces = Db::table('ny_anounce')->all()->toArray();
        $this->assign("anounces", $anounces);

        return $this->fetch('index/index_third');
    }

    public function getAd(){
        $kind1 = input('kind1','');
        $kind2 = input('kind2','');
        $location = input('location','');
        $page = input('page','');
        $count = 1;
        $start = ($page-1)*$count;

        $location = json_decode($location);

        
        $province = $location->province;
        $city = $location->city;
        $district = $location->district;

        // $province = '江苏省';
        // $city = '扬州市';
        // $district = '邗江区';

        $all_ad = Db::table('ny_advertisement_place')->where(["province_name" => $province,"city_name" => $city,"district_name" => $district])->order('id desc')->limit($start,$count)->all()->toArray();

        $res = array();
        $now = time();
        $where = '';
        if(empty($kind1) && empty($kind2)){
            $where = '1=1';
        }
        if(!empty($kind1) && empty($kind2)){
            $where = "kind1 = $kind1";
        }
        if(!empty($kind1) && !empty($kind2)){
            $where = "kind1 = $kind1 and kind2 = $kind2";
        }
        foreach ($all_ad as $key => $value) {
            $ad_info = Db::table('ny_advertisement')->where($where." and id = {$value['ad_id']} and end_time >= $now and status = 2")->all()->toArray();
            if(!empty($ad_info)){
                $imgs = explode(',', $ad_info[0]['imgs']);
                $ad_info[0]['cover'] = $imgs[0];
                $ad_info[0]['count'] = $ad_info[0]['end_time'] - time();
                $ad_info[0]['link'] = url("advertisement/detail")."?id=".$ad_info[0]['id'];
                $ad_info[0]['type_name'] = ($ad_info[0]['type'] == 1) ? '宣传类' : '活动类';
                $ad_info[0]['ac_number'] = ($ad_info[0]['type'] == 1) ? '关注名额:'.$ad_info[0]['number'] : '活动名额:'.$ad_info[0]['number'];
                $res[$key] = $ad_info[0];
            }else{
                continue;
            }
            


        }

        echo json_encode($res);exit;
    }

    
}