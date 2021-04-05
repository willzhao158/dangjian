<?php
namespace app\mobile\model;

use think\Model;
use think\Db;
use app\order\model\LayuiModel;

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
        Db::table('ny_mobile_user')->insert($inser_data);

        $res['code'] = 1;
        $res['msg'] = '注册成功';

        return $res;
	}
}