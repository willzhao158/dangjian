<?php
namespace app\mobile\controller;

use think\DB;
use app\mobile\model\ClassifyModel;
use app\mobile\model\CityModel;

class ShopController extends BaseController
{
    

    public function initialize(){
        parent::initialize();
        $model = new ClassifyModel();
        // $model->table= $this->table;
        $this->model = $model;


    }
    
    public function auth()
    {

        $uid = session('uid');
        $status = Db::name('shop')->where(['uid'=>$uid])->value('status');
        $user = Db::name('mobile_user')->where(['id'=>$uid,'cancel'=>1])->find();

        if($user['level'] == 1){
            return $this->fetch('shop/vip_fail');
        }

        if($status == 1){
            Header("Location:".url('tips/examine')); 
            exit;
        }elseif($status == 2){
            Header("Location:".url('tips/fail')); 
            exit;
        }elseif($status == 3){
            Header("Location:".url('tips/success_tip')); 
            exit;
        }

        $city = CityModel::getAll();
        $all_classify = ClassifyModel::getAll();
        $this->assign("city", json_encode($city));
        $this->assign("all_classify", json_encode($all_classify));
        return $this->fetch('shop/auth');
        

    }

    public function shop_manage()
    {
        $uid = session('uid');
        $status = Db::name('shop')->where(['uid'=>$uid])->value('status');
        $user = Db::name('mobile_user')->where(['id'=>$uid,'cancel'=>1])->find();

        if($user['level'] == 1){
            return $this->fetch('shop/vip_fail');
        }

        if(empty($status)){
            return $this->fetch('shop/first');
        }

        if($status == 1){
            Header("Location:".url('tips/examine')); 
            exit;
        }elseif($status == 2){
            Header("Location:".url('tips/fail')); 
            exit;
        }else{
            return $this->fetch('shop/shop_manage');
        }

    }

    public function edit(){

        $uid = session('uid');

        $res = ClassifyModel::getAll();

        $city = CityModel::getAll();

        $shop_info = Db::name('shop')->where('uid', $uid)->find();

        $shop_province = Db::name('city')->where('value', $shop_info['province'])->value('label');

        $shop_city = Db::name('city')->where('value', $shop_info['city'])->value('label');

        $shop_district = Db::name('city')->where('value', $shop_info['district'])->value('label');

        $shop_kind1 = Db::name('classify')->where('id', $shop_info['shop_kind1'])->value('name');
        $shop_kind2 = Db::name('classify')->where('id', $shop_info['shop_kind2'])->value('name');

        $shop_address = Db::name('shop_address')->where('shop_id', $shop_info['id'])->all()->toArray();

        $address_str = '';
        foreach ($shop_address as $key => $value) {
            $address_str .= $value['name'].'&'.$value['mobile'].'&'.$value['address'].'&'.$value['lng'].'&'.$value['lat'].'@';
        }


        $imgs1_arr = explode(',', $shop_info['imgs1']);
        $imgs2_arr = explode(',', $shop_info['imgs2']);
        $imgs3_arr = explode(',', $shop_info['imgs3']);

        $this->assign("all_classify", json_encode($res));
        $this->assign("city", json_encode($city));
        $this->assign("shop_info", $shop_info);
        $this->assign("shop_address", $shop_address);
        $this->assign("imgs1_arr", $imgs1_arr);
        $this->assign("imgs2_arr", $imgs2_arr);
        $this->assign("imgs3_arr", $imgs3_arr);

        $this->assign("shop_city", $shop_city);
        $this->assign("shop_district", $shop_district);
        $this->assign("shop_province", $shop_province);

        $this->assign("shop_kind1", $shop_kind1);
        $this->assign("shop_kind2", $shop_kind2);

        $this->assign("address_str", $address_str);

        return $this->fetch('shop/edit');
    }

    public function edit_data(){
        $city = input('city','');
        $shop_type = input('shop_type','');
        $shop_kind = input('shop_kind','');
        $imgs1 = input('imgs1','');
        $imgs2 = input('imgs2','');
        $imgs3 = input('imgs3','');
        $shopAddress = input('shopAddress','');
        $uid = session('uid');
        $shopAddress_arr = explode('@',$shopAddress);

        $city_arr = explode(',', $city);
        $province = $city_arr[0];
        $city = $city_arr[1];
        $district = $city_arr[2];

        $shop_kind_arr = explode(',', $shop_kind);
        $shop_kind1 = $shop_kind_arr[0];
        $shop_kind2 = $shop_kind_arr[1];

        $shop_info = Db::name('shop')->where('uid', $uid)->find();

        Db::name('shop_address')->where('shop_id', $shop_info['id'])->delete();

        $data = array(
                            'province'=>$province,
                            'city'=>$city,
                            'district'=>$district,
                            'shop_type'=>$shop_type,
                            'shop_kind1'=>$shop_kind1,
                            'shop_kind2'=>$shop_kind2,
                            'imgs1'=>$imgs1,
                            'imgs2'=>$imgs2,
                            'imgs3'=>$imgs3,
                            'status'=>1,
                            'createtime'=>time(),
                        );
        DB::name('shop')->where(['uid'=>session('uid')])->update($data);

        

        foreach ($shopAddress_arr as $key => $value) {
            if(!empty($value)){
                $info = explode('&', $value);
                $data = array(
                                'name'=>$info[0],
                                'mobile'=>$info[1],
                                'address'=>$info[2],
                                'lng'=>$info[3],
                                'lat'=>$info[4],
                                'shop_id'=>$shop_info['id'],
                            );
                DB::name('shop_address')->insert($data);
            }
            
        }

        echo 1;exit;
    }

    public function add(){
        $city = input('city','');
        $shop_type = input('shop_type','');
        $shop_kind = input('shop_kind','');
        $imgs1 = input('imgs1','');
        $imgs2 = input('imgs2','');
        $imgs3 = input('imgs3','');
        $shopAddress = input('shopAddress','');
        $shopAddress_arr = explode('@',$shopAddress);

        $city_arr = explode(',', $city);
        $province = $city_arr[0];
        $city = $city_arr[1];
        $district = $city_arr[2];

        $shop_kind_arr = explode(',', $shop_kind);
        $shop_kind1 = $shop_kind_arr[0];
        $shop_kind2 = $shop_kind_arr[1];

        $insert = array(
                            'province'=>$province,
                            'city'=>$city,
                            'district'=>$district,
                            'shop_type'=>$shop_type,
                            'shop_kind1'=>$shop_kind1,
                            'shop_kind2'=>$shop_kind2,
                            'imgs1'=>$imgs1,
                            'imgs2'=>$imgs2,
                            'imgs3'=>$imgs3,
                            'uid'=>session('uid'),
                            'createtime'=>time(),
                        );
        $insert_id = DB::name('shop')->insertGetId($insert);
        foreach ($shopAddress_arr as $key => $value) {
            if(!empty($value)){
                $info = explode('&', $value);
                $data = array(
                                'name'=>$info[0],
                                'mobile'=>$info[1],
                                'address'=>$info[2],
                                'lng'=>$info[3],
                                'lat'=>$info[4],
                                'shop_id'=>$insert_id,
                            );
                DB::name('shop_address')->insert($data);
            }
            
        }

        echo 1;exit;
    }

    public function merchant_form()
    {

        $res = ClassifyModel::getAll();

        $this->assign("all_classify", json_encode($res));
        $city = CityModel::getAll();
        $this->assign("city", json_encode($city));
        return $this->fetch('shop/merchant_form');
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

    public function pics()
    {
        $files = $_FILES;
        $img_type = input('type');
        $res = array();
        foreach ($files as $key => $value) {
            $imgname = date('YmdHis').rand(9999,99999);
            $tmp = $value['tmp_name'];
            $filepath = "upload/shop/";;
            if(move_uploaded_file($tmp,$filepath.$imgname.".jpg")){

                //指定图片路径

                if($img_type == 1){
                    ini_set ('memory_limit', '128M') ;
                    $this->compressedImage($filepath.$imgname.".jpg", $filepath.$imgname.".jpg");
                    //1.配置图片路径  
                    $src = $_SERVER['DOCUMENT_ROOT'].$filepath.$imgname.".jpg";
                    //2.获取图片信息  
                    $info = getimagesize($src);  
                    //3.通过编号获取图像类型  
                    $type = image_type_to_extension($info[2],false);  
                    //4.在内存中创建和图像类型一样的图像  
                    $fun = "imagecreatefrom".$type;  
                    //5.图片复制到内存  
                    $image = $fun($src);  


                    $width = imagesx ( $image );
                    $height = imagesy ( $image );

                    $target = imagecreatetruecolor ( $width, $height );
 
                    $white = imagecolorallocate ( $target, 255, 255, 255 );
                    imagefill ( $target, 0, 0, $white );

                    $fontSize = 10;
                    $font = $_SERVER['DOCUMENT_ROOT']."1.ttf";  
                    $content = "仅限泡泡同城商家认证使用";  
                    $fontBox = imagettfbbox($fontSize, 0, $font, $content);//文字水平居中实质
                      

                    /*操作图片*/  
                    //1.设置字体的路径  
                    
                    //echo $font;exit;
                    //2.填写水印内容  
                    
                    //3.设置字体颜色和透明度  
                    $color = imagecolorallocatealpha($image, 255, 0, 0, 75);
                    //4.写入文字 (图片资源，字体大小，旋转角度，坐标x，坐标y，颜色，字体文件，内容) 
                    imagettftext($image, 20, 20, ceil(($width - $fontBox[2]) / 2)-20, 290, $color, $font, $content);  

                    /*输出图片*/  
                    //浏览器输出  
                    $fun = "image".$type;

                    //$fun($image);  
                    
                    $fun($image,$src); 
                    ImageDestroy($image);

                    $res[$key] = $filepath.$imgname.".jpg";
                }
                $this->compressedImage($filepath.$imgname.".jpg", $filepath.$imgname.".jpg");
                
                $res[$key] = $filepath.$imgname.".jpg";
                
                //
                


                
                //echo $filepath.$imgname.'qqq';
            }else{
                //echo "上传失败";
            }
        }
        $res = implode(',',$res);
        //var_dump($res);exit;
        echo json_encode($res);exit;

    }
}