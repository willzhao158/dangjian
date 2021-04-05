<?php
namespace app\mobile\model;

use think\Model;
use think\Db;
use app\order\model\LayuiModel;

Class LoginModel extends Model
{
	static function Login(){
		$mobile = input('mobile','');
        $code = input('code','');

        $res = array();
        
        $user = Db::table('ny_mobile_user')->where(['mobile' => $mobile])->find();

        if(empty($user)){
            $res['code'] = 3;
            $res['msg'] = '此账号不存在,请您先注册';
            return $res;
        }

        $send_code = Db::table('ny_sms')->limit(1)->where(['mobile' => $mobile])->order('createtime desc')->value('code');

        if($send_code != $code){
            $res['code'] = 2;
            $res['msg'] = '验证码错误';
            return $res;
        }
        
        $array = array(
                        'last_login_time'=>time(),
                        'last_login_ip'=>get_client_ip(0, true),
                    );

        Db::table('ny_mobile_user')->where('id', $user['id'])->update($array);

        $res['code'] = 1;
        $res['msg'] = '登录成功';

        session('uid', $user["id"]);
        session('name', $user["name"]);
        session('mobile', $user['mobile']);

        return $res;
	}
}