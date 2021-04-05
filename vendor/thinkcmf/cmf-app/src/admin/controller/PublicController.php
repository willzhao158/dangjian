<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;

class PublicController extends AdminBaseController
{
    public function initialize()
    {
    }

    /**
     * 后台登陆界面
     */
    public function login()
    {
        $loginAllowed = session("__LOGIN_BY_CMF_ADMIN_PW__");
        if (empty($loginAllowed)) {
            //$this->error('非法登录!', cmf_get_root() . '/');
            return redirect(cmf_get_root() . "/");
        }

        $admin_id = session('ADMIN_ID');
        if (!empty($admin_id)) {//已经登录
            return redirect(url("admin/Index/index"));
        } else {
            session("__SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS__", true);
            $result = hook_one('admin_login');
            if (!empty($result)) {
                return $result;
            }
            return $this->fetch(":login");
        }
    }

    /**
     * 登录验证
     */
    public function doLogin()
    {
        if (hook_one('admin_custom_login_open')) {
            $this->error('您已经通过插件自定义后台登录！');
        }

        $loginAllowed = session("__LOGIN_BY_CMF_ADMIN_PW__");
        if (empty($loginAllowed)) {
            $this->error('非法登录!', cmf_get_root() . '/');
        }

        $captcha = $this->request->param('captcha');
        // if (empty($captcha)) {
        //     $this->error(lang('CAPTCHA_REQUIRED'));
        // }
        //验证码
        // if (!cmf_captcha_check($captcha)) {
        //     $this->error(lang('CAPTCHA_NOT_RIGHT'));
        // }

        $name = $this->request->param("username");
        if (empty($name)) {
            $this->error(lang('USERNAME_OR_EMAIL_EMPTY'));
        }
        $pass = $this->request->param("password");
        if (empty($pass)) {
            $this->error(lang('PASSWORD_REQUIRED'));
        }
        if (strpos($name, "@") > 0) {//邮箱登陆
            $where['user_email'] = $name;
        } else {
            $where['user_login'] = $name;
        }

        $result = Db::name('user')->where($where)->find();

        if (!empty($result) && $result['user_type'] == 1) {
            if (cmf_compare_password($pass, $result['user_pass'])) {

                $flag = \app\common\model\UserModel::userLoginSession($result);
                if ($flag[0]) {
                    $this->success(lang('LOGIN_SUCCESS'), url("admin/Index/index"));
                } else {
                    $this->error($flag[1]);
                }

            } else {
                $this->error(lang('PASSWORD_NOT_RIGHT'));
            }
        } else {
            $this->error(lang('USERNAME_NOT_EXIST'));
        }
    }

    /**
     * 后台管理员退出
     */
    public function logout()
    {
        session('ADMIN_ID', null);
        return redirect(url('/', [], false, true));
    }
}