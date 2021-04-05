<?php
namespace app\mobile\model;

use think\Model;
use think\Db;
use app\order\model\LayuiModel;
use app\mobile\model\RuleModel;

Class RegisterModel extends Model
{
	static function register(){
		$mobile = input('mobile','');
        $code = input('code','');
        $name = input('name','');
        $sfz = input('sfz','');
        $reference = input('reference','');

        if(!empty($reference)){
            $reference = $reference + 0;
        }
        

        $res = array();

        $user = Db::table('ny_mobile_user')->where(['mobile' => $mobile])->value('id');

        if($user){
            $res['code'] = 2;
            $res['msg'] = '此手机号已被注册';
            return $res;
        }

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');


        if($send_code != $code){
			$res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }

        $top_reference = Db::table('ny_mobile_user')->limit(1)->where(['id' => $reference])->value('reference');

        

        $inser_data = array(
        					'mobile'=>$mobile,
        					'name'=>$name,
        					'sfz'=>$sfz,
        					'reference'=>$reference,
        					'createtime'=>time(),
        					'top_reference'=>$top_reference,
        				);
        $id = Db::table('ny_mobile_user')->insertGetId($inser_data);

        //积分分成
        RuleModel::login_rule($id,$reference,$top_reference);

        //生成用户专属二维码
        require_once($_SERVER['DOCUMENT_ROOT']."../vendor/phpqrcode/phpqrcode.php");
        $data = "https://yzpaopao.com/register/index?code=$id"; //二维码内容 
        // 纠错级别：L、M、Q、H
        $level = 'L';
        // 点的大小：1到10,用于手机端4就可以了
        $size = 10;
        // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
        $qrcode_name = $id.'.png';
        $path = $_SERVER['DOCUMENT_ROOT']."../public/upload/qrcode/$qrcode_name";
        // 生成的文件名
        //$fileName = $path.$size.'.png';
        $res = \QRcode::png($data, $path, $level, $size);

        $res['code'] = 1;
        $res['msg'] = '注册成功';

        return $res;
	}
}