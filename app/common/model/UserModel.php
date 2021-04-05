<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\common\model;

use think\Db;
use think\Model;
use think\facade\Cache;

class UserModel extends \app\admin\model\UserModel
{

    /**
     * @param $companyId
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCompanyAdministrator($companyId)
    {
        $userId = Db::name('RoleUser')
            ->alias("a")
            ->join('__ROLE__ r', 'a.role_id = r.id')
            ->where(["r.name" => "超级管理员", "r.status" => 1, "a.companyid" => $companyId, "r.companyid" => $companyId])
            ->field('user_id')
            ->find();

        return (new UserModel())->where(['id' => $userId, 'companyid' => $companyId, 'user_status' => 1])->find()->toArray();
    }


    /**
     * 统一在一处 写入用户session && cookie
     * @param array  $result           Db:name('user')return的array
     * @param bool   $alwaysFlushToken 是否强制刷新token
     * @param string $deviceType       用户登陆device
     * @return array [登陆是否成功, error string]
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function userLoginSession($result, $alwaysFlushToken = false, $deviceType = 'web')
    {

        // $groups = Db::name('RoleUser')
        //     ->alias("a")
        //     ->join('__ROLE__ b', 'a.role_id =b.id')
        //     ->where(["user_id" => $result["id"], "status" => 1])
        //     ->value("role_id");
        // if ($result["id"] != 1 && (empty($groups) || empty($result['user_status']))) {

        //     return [false, lang('USE_DISABLED')];
        // }

        // if ($result['id'] != 1 && Db::name('company')->where(['id' => $result['companyid'], 'status' => 1])->count() == 0) {
        //     return [false, '企业已被禁用'];
        // }

        //登入成功页面跳转
        session('ADMIN_ID', $result["id"]);
        session('name', $result["user_login"]);
        session('company', $result['companyid']);
        $result['last_login_ip']   = get_client_ip(0, true);
        $result['last_login_time'] = time();
        $token                     = cmf_generate_user_token($result["id"], $deviceType);
        if ($alwaysFlushToken || !empty($token)) {
            session('token', $token);
        }
        Db::name('user')->update($result);
        cookie("admin_username", $result['user_login'], 3600 * 24 * 30);
        session("__LOGIN_BY_CMF_ADMIN_PW__", null);

        return [true, ''];
    }

}
