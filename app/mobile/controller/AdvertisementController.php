<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\CityModel;
use app\mobile\model\ClassifyModel;

class AdvertisementController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
    }



    public function edit(){


        $ad_id = input('id','');
        $advertisement = Db::table('ny_advertisement')->limit(1)->where("id =$ad_id")->find();
        $advertisement['imgs_url'] = explode(',', $advertisement['imgs']);

        $advertisement['type_name'] = ($advertisement['type'] == 1) ? '宣传类广告' : '活动类广告';

        $advertisement['activity_type_name'] = ($advertisement['activity_type'] == 1) ? '58' : '108';

        $ad_places = Db::table('ny_advertisement_place')->where("ad_id =$ad_id")->all()->toArray();
        $place_str = '';
        $place_name_arr = array();
        foreach ($ad_places as $key => $value) {
            $place_str .= $value['province'].','.$value['city'].','.$value['district'].'@';
            $place_name_arr[$key] = $value['province_name'].$value['city_name'].$value['district_name'];
        }
        $this->assign("place_str", $place_str);
        $this->assign("place_name_arr", $place_name_arr);
        $this->assign("advertisement", $advertisement);


        $city = CityModel::getAll();

        $this->assign("city", json_encode($city));

        $res = ClassifyModel::getAll();

        $this->assign("all_classify", json_encode($res));
        return $this->fetch('advertisement/edit');
    }
    
    public function index()
    {
        $uid = session('uid');

        $invoice = Db::table('ny_invoice')->where('uid', $uid)->find();
        if(empty($invoice)){
            return $this->fetch('advertisement/error');
        }

        $exit_ad = Db::table('ny_advertisement')->limit(1)->where("end_time > ".time()." and uid = ".$uid)->order('')->find();

        $shop_info = Db::table('ny_shop')->where("uid  = ".$uid)->find();

        if($shop_info['freeze'] == 2){
            return $this->fetch('advertisement/freeze_error');
        }

        if(!empty($exit_ad)){
            if($exit_ad['pay_status'] == 1){
                $this->assign("exit_ad", $exit_ad);
                return $this->fetch('advertisement/pay_status_error');
            }else{
                return $this->fetch('advertisement/publish_error');
            }
            
        }

    	$city = CityModel::getAll();

        $this->assign("city", json_encode($city));

        $res = ClassifyModel::getAll();

        $this->assign("all_classify", json_encode($res));

        return $this->fetch('advertisement/publish');
    }

    public function show_confirm(){
        $id = input('id');
        $uid = session('uid');
        $mobile = session('mobile');
        $this->assign("uid", $uid);
        $this->assign("mobile", $mobile);
        $this->assign("jid", $id);
        return $this->fetch('advertisement/show_confirm');
    }

    public function confirm(){
        $jid = input('jid');
        $uid = session('uid');
        $mobile = input('mobile');
        $code = input('code','');
        $now = time();
        $res = array();
        
        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误！';
            echo json_encode($res);
            exit;
        }

        $overtime_info = Db::name('my_join')->alias("a")->join('ny_advertisement b ', ' a.ad_id = b.id')->where("a.uid = $uid and b.end_time < $now and (a.status = 1 || a.status = 3) and a.ad_type = 2")->count();
        //var_dump($overtime);
        //Db::name('mobile_user')->where('id', $uid)->update(array('isblack'=>2));
        if($overtime_info >= 3){
            $res['code'] = 2;
            $res['msg'] = '您已违反平台相关规定，请联系在线客服！';
            echo json_encode($res);
            exit;
        }
        
        $join = Db::table('ny_my_join')->where('id', $jid)->find();

        if($join['status'] == 4){
            $res['code'] = 2;
            $res['msg'] = '该彩金券已被使用！';
            echo json_encode($res);
            exit;
        }

        //用户以及商家各加20积分
        //用户加20
        Db::table('ny_mobile_user')->where("id = {$join['uid']}")->setInc('jifen',20);
        //商家加20
        Db::table('ny_mobile_user')->where("id = {$join['au_id']}")->setInc('jifen',20);

        //用户积分log
        $yh_jifen = array(
                    'uid'=>$join['uid'],
                    'number'=>20,
                    'from'=>3,
                    'createtime'=>time(),
                    'ad_id'=>$join['ad_id']
                );
        DB::name('jifen_log')->insert($yh_jifen);
        //商家积分log
        $sj_jifen = array(
                    'uid'=>$join['au_id'],
                    'number'=>20,
                    'from'=>3,
                    'createtime'=>time(),
                    'ad_id'=>$join['ad_id']
                );
        DB::name('jifen_log')->insert($sj_jifen);

        //用户收益为彩金券价格*0.88
        //用户收益表添加记录
        $ad_info = Db::table('ny_advertisement')->where('id', $join['ad_id'])->find();
        

        $income_price = ($ad_info['activity_type'] == 1) ? (58*0.88) : (108*0.88);
        $income_log = array(
                        'uid'=>$join['uid'],
                        'from'=>7,
                        'createtime'=>time(),
                        'ad_id'=>$join['ad_id'],
                        'price'=>$income_price
                    );
        DB::name('income_log')->insert($income_log);
        //用户表income字段更新
        Db::table('ny_mobile_user')->where("id = {$join['uid']}")->setInc('income',$income_price);

        //更新所领优惠券my_join的状态
        Db::name('my_join')->where('id', $join['id'])->update(array('status'=>4));
        


        $res['code'] = 1;
        $res['msg'] = '成功';

        echo json_encode($res);
        exit;
    }

    public function pics()
    {
        $files = $_FILES;
        $res = array();
        foreach ($files as $key => $value) {
            $imgname = date('YmdHis').rand(9999,99999);
            $tmp = $value['tmp_name'];
            $filepath = "upload/advertisement/";;
            if(move_uploaded_file($tmp,$filepath.$imgname.".jpg")){

                $this->compressedImage($filepath.$imgname.".jpg", $filepath.$imgname.".jpg");
                $res[$key] = $filepath.$imgname.".jpg";
                //echo $filepath.$imgname.'qqq';
            }else{
                //echo "上传失败";
            }
        }
        $res = implode(',',$res);
        //var_dump($res);exit;
        echo json_encode($res);exit;

    }

    public function compressedImage($imgsrc, $imgdst) {
        list($width, $height, $type) = getimagesize($imgsrc);
       
        $new_width = $width;//压缩后的图片宽
        $new_height = $height;//压缩后的图片高
 
        if($width >= 600){
            $per = 600 / $width;//计算比例
            $new_width = $width * $per;
            $new_height = $height * $per;
        }
        switch ($type) {
            case 1:
                $giftype = check_gifcartoon($imgsrc);
                if ($giftype) {
                    //header('Content-Type:image/gif');
                    $image_wp = imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    //90代表的是质量、压缩图片容量大小
                    imagejpeg($image_wp, $imgdst, 90);
                    imagedestroy($image_wp);
                    imagedestroy($image);
                }
                break;
            case 2:
                //header('Content-Type:image/jpeg');
                $image_wp = imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                //90代表的是质量、压缩图片容量大小
                imagejpeg($image_wp, $imgdst, 90);
                imagedestroy($image_wp);
                imagedestroy($image);
                break;
            case 3:
                //header('Content-Type:image/png');
                $image_wp = imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                //90代表的是质量、压缩图片容量大小
                imagejpeg($image_wp, $imgdst, 90);
                imagedestroy($image_wp);
                imagedestroy($image);
                break;
        }
    }

    public function edit_publish(){
        $uid = session('uid');

        //判断是否有正在执行的广告
        

        $ad_id = input('ad_id','');
        $showCityInput = input('showCityInput','');
        $showTypeInput = input('showTypeInput','');
        $showKindInput = input('showKindInput','');
        $number = input('number','');
        $subject = input('subject','');
        $imgs = input('imgs','');
        $content = input('content','');
        //$address = input('address','');
        //$mobile = input('mobile','');
        $showDatePicker = input('showDatePicker','');
        $showTicketACInput = input('showTicketACInput','');

        
        $showKindInput = Db::table('ny_shop')->where(["uid" => $uid])->find();
        $kind1 = $showKindInput['shop_kind1'];
        $kind2 = $showKindInput['shop_kind2'];

        if($showTypeInput == 1){
            $price = $number;
        }else{
            if($showTicketACInput == 1){
                $price = 58*$number;
            }else{
                $price = 108*$number;
            }
        }

        //$ordersn = $this->build_order_no();

        $data = array(
                    'type' => $showTypeInput,
                    'number' => $number,
                    'kind1' => $kind1,
                    'kind2' => $kind2,
                    'subject' => $subject,
                    'imgs' => $imgs,
                    'content' => $content,
                    'end_time' => strtotime($showDatePicker.' 23:59:59'),
                    'uid' => session('uid'),
                    'activity_type' => $showTicketACInput,
                    'price' => $price,
                );

        DB::name('advertisement')->where("id = $ad_id")->update($data);
                        
        $citys = explode('@', $showCityInput);   

        DB::name('advertisement_place')->where("ad_id = $ad_id")->delete();

        foreach ($citys as $key => $value){
            if($value){
                $arr = explode(',', $value);
                $data = array();
                $data['ad_id'] = $ad_id;
                $data['province'] = $arr[0];
                $data['city'] = $arr[1];
                $data['district'] = $arr[2];
                $data['province_name'] = Db::table('ny_city')->where(["value" => $arr[0]])->value('label');
                $data['city_name'] = Db::table('ny_city')->where(["value" => $arr[1]])->value('label');
                $data['district_name'] = Db::table('ny_city')->where(["value" => $arr[2]])->value('label');
                DB::name('advertisement_place')->insert($data);
            }
            
        }    
        echo 1;exit;
    }

    public function publish(){

        $uid = session('uid');

        //判断是否有正在执行的广告
        $exit_ad = Db::table('ny_advertisement')->limit(1)->where("end_time > ".time()." and uid = ".$uid)->order('')->find();

        if($exit_ad['pay_status'] == 1){
            echo $exit_ad['id'];exit;
        }
        


        $showCityInput = input('showCityInput','');
        $showTypeInput = input('showTypeInput','');
        $showKindInput = input('showKindInput','');
        $number = input('number','');
        $subject = input('subject','');
        $imgs = input('imgs','');
        $content = input('content','');
        //$address = input('address','');
        $shopLngLat = input('shopLngLat','');
        //$mobile = input('mobile','');
        $showDatePicker = input('showDatePicker','');
        $showTicketACInput = input('showTicketACInput','');

        // $lngLat = explode(',', $shopLngLat);
        // $lat = $lngLat[1];
        // $lng = $lngLat[0];
        $showKindInput = Db::table('ny_shop')->where(["uid" => $uid])->find();
        $kind1 = $showKindInput['shop_kind1'];
        $kind2 = $showKindInput['shop_kind2'];

        if($showTypeInput == 1){
            $price = $number;
        }else{
            if($showTicketACInput == 1){
                $price = 58*$number;
            }else{
                $price = 108*$number;
            }
        }

        $ordersn = $this->build_order_no();

        $data = array(
                    'type' => $showTypeInput,
                    'number' => $number,
                    'kind1' => $kind1,
                    'kind2' => $kind2,
                    'subject' => $subject,
                    'imgs' => $imgs,
                    'content' => $content,
                    'end_time' => strtotime($showDatePicker.' 23:59:59'),
                    'create_time' => time(),
                    'uid' => session('uid'),
                    'ordersn' => $ordersn,
                    'activity_type' => $showTicketACInput,
                    'price' => $price,
                );

        $insert_id = DB::name('advertisement')->insertGetId($data);
                        
        $citys = explode('@', $showCityInput);   

        foreach ($citys as $key => $value){
            if($value){
                $arr = explode(',', $value);
                $data = array();
                $data['ad_id'] = $insert_id;
                $data['province'] = $arr[0];
                $data['city'] = $arr[1];
                $data['district'] = $arr[2];
                $data['province_name'] = Db::table('ny_city')->where(["value" => $arr[0]])->value('label');
                $data['city_name'] = Db::table('ny_city')->where(["value" => $arr[1]])->value('label');
                $data['district_name'] = Db::table('ny_city')->where(["value" => $arr[2]])->value('label');
                DB::name('advertisement_place')->insert($data);
            }
            
        }    
        echo $insert_id;exit;
    }

    public function build_order_no(){
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    public function getAddr($lng,$lat){
        $local="$lng,$lat";
        $regeo_url="https://restapi.amap.com/v3/geocode/regeo";
        $address_location=$regeo_url."?output=JSON&location=$local&key=2cb967558a2140361d2d9c5e08b9a87c";
        $data_location=file_get_contents($address_location);

        $result_local=json_decode($data_location,true);

        if($result_local['status'] == 1){
            return $result_local['regeocode']['formatted_address'];
        }

        return '';

    }


    public function detail(){
        $uid = session('uid');
        $id = input('id','');
        $ad_info = Db::table('ny_advertisement')->where(["id" => $id])->find();

        $detail_imgs = explode(',',$ad_info['imgs']);
        $now = time();
        //活动截止日期之前，如果未提交或者提交未通过，则30天之内不可以参加平台所有彩金券活动
        $is_tijiao = 1;
        $is_tijiao_info = Db::name('my_join')->alias("a")->join('ny_advertisement b ', ' a.ad_id = b.id')->order("b.end_time desc")->where("a.uid = $uid and b.end_time < $now and (a.status = 1 || a.status = 3) and a.ad_type = 2")->find();

        if(!empty($is_tijiao_info) && ($now < ($is_tijiao_info['end_time'] + 60*60*24*30))){
            $is_tijiao = 2;
        }

        //活动截止日期前3次不提交或者未确认则自动拉黑
        $overtime = 1;
        $overtime_info = Db::name('my_join')->alias("a")->join('ny_advertisement b ', ' a.ad_id = b.id')->where("a.uid = $uid and b.end_time < $now and (a.status = 1 || a.status = 3) and a.ad_type = 2")->count();
        //var_dump($overtime);
        //Db::name('mobile_user')->where('id', $uid)->update(array('isblack'=>2));
        if($overtime_info >= 3){
            $overtime = 2;
        }

        //一个月1号到31号只可以参加2个分类别商家活动
        $same_kind = 1;
        $from = strtotime(date('Y-m-01 00:00:00'));
        $end = strtotime(date('Y-m-31 23:59:59'));
        $same_kind_number = Db::name('my_join')->alias("a")->join('ny_advertisement b ', ' a.ad_id = b.id')->where("a.uid = $uid and b.kind2 = {$ad_info['kind2']} and a.ad_type = 2 and a.status != 2")->count();

        //var_dump($same_kind_number);exit;

        if($same_kind_number >= 2){
            $same_kind = 2;
        }

        //半年内是否参加
        //半年内参加其他活动
        $half_year = 1;
        $zuijin_ad = Db::table('ny_my_join')->where("uid = $uid and ad_id != {$ad_info['id']} and ad_type = {$ad_info['type']} and au_id = {$ad_info['uid']}")->limit(1)->order("join_time desc")->find();
        
        if(($now - $zuijin_ad['join_time']) < 60*60*24*31*6){
            $half_year = 2;
        }

        //当月退回3次彩金券，即所有彩金券1个月内都不能领
        $this_month_tuihui = 1;
        $from = strtotime(date('Y-m-01 00:00:00'));
        $end = strtotime(date('Y-m-31 23:59:59'));
        $this_month_tuihui_count = Db::table('ny_my_join')->where("uid = $uid and status = 2 and join_time > $from and join_time < $end and ad_type = 2")->count();
        $next_end = $end + 60*60*24*30;
        if($this_month_tuihui_count >= 3){
            if($now < $next_end){
                $this_month_tuihui = 2;
            }
        }
        


        //已参加人数
        $isnumber = 1;
        $already_join = Db::table('ny_my_join')->where("ad_id = {$ad_info['id']} and status != 2")->count();
        if($already_join >= $ad_info['number']){
            $isnumber = 2;
        }

        //广告类自己是否已经参加
        $isjoin = 1; //否
        $isused = 1;
        $join_info = Db::table('ny_my_join')->where("ad_id = {$ad_info['id']} and uid = $uid and status != 2 and ad_type = 2")->find();
        if(!empty($join_info)){
            $isjoin = 2;
            if($join_info['status'] == 4){
                $isused = 2;
            }
        }

        //宣传类是否已使用
        $isused1 = 1;
        $join_info1 = Db::table('ny_my_join')->where("ad_id = {$ad_info['id']} and uid = $uid and status = 4 and ad_type = 1")->find();
        if(!empty($join_info1)){
            if($join_info1['status'] == 4){
                $isused1 = 2;
            }
        }

        //退回的券无法继续参加本商家活动
        $is_tuihui = 1;
        $now_join = Db::table('ny_my_join')->where("uid = $uid and ad_id = {$ad_info['id']} and ad_type = 2")->find();
        
        if($now_join['status'] == 2){
            $is_tuihui = 2;
        }
        

        $shop = Db::table('ny_shop')->where(["uid" => $ad_info['uid']])->find();
        $shop_address = Db::table('ny_shop_address')->where(["shop_id" => $shop['id']])->all()->toArray();
        foreach ($shop_address as $key => $value) {
            $address = $this->getAddr($value['lng'],$value['lat']);
            $shop_address[$key]['address'] = $address;
        }
        $imgs = explode(',',$shop['imgs1']);

        $ismine = 1;

        if($ad_info['uid'] == $uid){
            $ismine = 2;
        }
        //是否收藏
        $iscollect = 1;
        $collect = Db::table('ny_my_collect')->where(["uid" => $uid,'ad_id'=>$ad_info['id']])->find();
        if(!empty($collect)){
            $iscollect = 2;
        }

        $this->assign("isnumber", $isnumber);
        $this->assign("isused1", $isused1);
        $this->assign("isused", $isused);
        $this->assign("overtime", $overtime);
        $this->assign("is_tijiao", $is_tijiao);
        $this->assign("same_kind", $same_kind);
        $this->assign("this_month_tuihui", $this_month_tuihui);
        $this->assign("is_tuihui", $is_tuihui);
        $this->assign("half_year", $half_year);
        $this->assign("isjoin", $isjoin);
        $this->assign("detail_imgs", $detail_imgs);
        $this->assign("already_join", $already_join);
        $this->assign("ad_info", $ad_info);
        $this->assign("imgs", $imgs);
        $this->assign("ismine", $ismine);
        $this->assign("iscollect", $iscollect);
        $this->assign("shop_address", $shop_address);
        return $this->fetch('advertisement/detail');
    }

    public function join(){
        $uid = session('uid');
        $ad_id = input('ad_id','');
        $ad_type = input('ad_type','');
        $au_id = input('au_id','');

        $join_info = Db::table('ny_my_join')->where(["uid" => $uid,'ad_id'=>$ad_id])->find();
        $res = array();
        if(!empty($join_info)){
            //已参加
            $res['code'] = 2;
            if($join_info['status'] == 1){
                $res['msg'] = '请在【我的活动彩金劵】中查看获取的活动彩金劵';
            }else{
                $res['msg'] = '您已无法再次参加该商家活动';
            }
            echo json_encode($res);
            exit;
        }

        $ad_info = Db::table('ny_advertisement')->where(["id" => $ad_id])->find();
        $already_join = Db::table('ny_my_join')->where("ad_id = {$ad_info['id']} and status != 2")->count();
        if($already_join >= $ad_info['number']){
            if($ad_info['type'] == 1){
                $msg = '您关注的名额已满！';
            }else{
                $msg = '您参加的名额已满！';
            }
            $res['code'] = 2;
            $res['msg'] = $msg;
            echo json_encode($res);
            exit;
        }



        $data = array(
                    'ad_id'=>$ad_id,
                    'uid'=>$uid,
                    'ad_type'=>$ad_type,
                    'join_time'=>time(),
                    'au_id'=>$au_id
                );
        DB::name('my_join')->insert($data);
        //未参加
        $res['code'] = 1;
        $res['msg'] = '';
        echo json_encode($res);
        exit;
    }

    public function collect(){
        $uid = session('uid');
        $ad_id = input('ad_id','');
        $action = input('action','');

        if($action == 1){
            $data = array(
                    'ad_id'=>$ad_id,
                    'uid'=>$uid,
                    'createtime'=>time(),
                );
            DB::name('my_collect')->insert($data);
        }else{
            $data = array(
                    'ad_id'=>$ad_id,
                    'uid'=>$uid,
                    'createtime'=>time(),
                );
            Db::name('my_collect')->where(["uid" => $uid,'ad_id'=>$ad_id])->delete();
        }
    }

    public function my_advertisement(){
        $uid = session('uid');
        $my_ads = Db::name('advertisement')->where(["uid" => $uid,"status"=>2])->order('create_time desc')->all()->toArray();
        $this->assign("my_ads", $my_ads);
        return $this->fetch('advertisement/my_advertisement');
    }

    public function cus_detail(){
        $uid = session('uid');
        $ad_id = input('ad_id');
        $collects = Db::name('my_collect')->where(['ad_id'=>$ad_id])->all()->toArray();
        foreach ($collects as $key => $value) {
            $user = Db::name('mobile_user')->where(["id" => $value['uid']])->find();
            $collects[$key]['name'] = $user['name'];
            $collects[$key]['mobile'] = substr_replace($user['mobile'],'****',3,4);
            if($user['level']==1){
                $collects[$key]['level_name'] = '普通用户';
            }elseif($user['level']==2){
                $collects[$key]['level_name'] = 'VIP商家';
            }elseif($user['level']==3){
                $collects[$key]['level_name'] = '合作商';
            }
            
        }
        $joins = Db::name('my_join')->where(['ad_id'=>$ad_id])->all()->toArray();
        foreach ($joins as $key => $value) {
            $user = Db::name('mobile_user')->where(["id" => $value['uid']])->find();
            $joins[$key]['name'] = $user['name'];
            $joins[$key]['mobile'] = $user['mobile'];
            $joins[$key]['back_mobile'] = substr_replace($user['mobile'],'****',3,4);
            if($user['level']==1){
                $joins[$key]['level_name'] = '普通用户';
            }elseif($user['level']==2){
                $joins[$key]['level_name'] = 'VIP商家';
            }elseif($user['level']==3){
                $joins[$key]['level_name'] = '合作商';
            }

            //是否能打电话
            $joins[$key]['not_show'] = 1;
            if($value['ad_type'] == 1){
                if($value['status']==1){
                    $joins[$key]['status_name'] = '未使用';
                }elseif($value['status']==4){
                    $joins[$key]['status_name'] = '已使用';
                }
                $joins[$key]['not_show'] = 2;
            }elseif ($value['ad_type'] == 2) {
                if($value['status']==1){
                    $joins[$key]['status_name'] = '未使用';
                }elseif($value['status']==2){
                    $joins[$key]['status_name'] = '已退回';
                    $joins[$key]['not_show'] = 2;
                }elseif($value['status']==3){
                    $joins[$key]['status_name'] = '已提交';
                }elseif($value['status']==4){
                    $joins[$key]['status_name'] = '已到店';
                }
            }
            
        }
        $this->assign("collects", $collects);
        $this->assign("joins", $joins);
        return $this->fetch('advertisement/cus_detail');
    }
}