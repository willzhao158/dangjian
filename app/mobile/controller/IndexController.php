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
     
        $uid = session('uid');
        $user = Db::name('mobile_user')->where('id', $uid)->find();
        if($user['isblack'] == 2){
            return $this->fetch('index/black');
            return false;
        }

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
        //$page = 1;
        $count = 5;
        $start = ($page-1)*$count;

        $location = json_decode($location);

        
        $province = $location->province;
        $city = $location->city;
        $district = $location->district;

        // $province = '江苏省';
        // $city = '扬州市';
        // $district = '邗江区';

        //$all_ad = Db::table('ny_advertisement_place')->where(["province_name" => $province,"city_name" => $city,"district_name" => $district])->order('id desc')->limit($start,$count)->all()->toArray();

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

        $all_ad = Db::name('advertisement_place')->alias("a")->join('ny_advertisement b', ' a.ad_id = b.id')->order("is_top desc")->where("$where and b.status = 2 and a.province_name = '$province' and a.city_name = '$city' and a.district_name = '$district' and b.end_time > $now")->order("b.type asc,create_time asc")->limit($start,$count)->all()->toArray();




        foreach ($all_ad as $key => $value) {

            //名额没了就不显示
            if($value['type'] == 2){
                $number = $value['number'];
                $canjia = Db::table('ny_my_join')->where("ad_id = {$value['id']} and status != 2")->count();
                if($canjia >= $number){
                    unset($all_ad[$key]);
                    continue;
                }
            }
            


            $imgs = explode(',', $value['imgs']);
            $all_ad[$key]['cover'] = $imgs[0];
            $all_ad[$key]['count'] = $value['end_time'] - time();
            $all_ad[$key]['link'] = url("advertisement/detail")."?id=".$value['id'];
            $all_ad[$key]['type_name'] = ($value['type'] == 1) ? '宣传类' : '活动类';
            $all_ad[$key]['ac_number'] = ($value['type'] == 1) ? '关注名额:'.$value['number'] : '活动名额:'.$value['number'];
        }




        echo json_encode($all_ad);exit;
    }

    
}