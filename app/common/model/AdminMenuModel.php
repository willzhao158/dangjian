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

use think\Model;
use think\facade\Cache;

class AdminMenuModel extends \app\admin\model\AdminMenuModel
{
    /**
     * 菜单树状结构集合
     */
    public function menuTree($id=0)
    {
        $data = $this->getTree($id);

        return $data;
    }
    /**
     * 按父ID查找菜单子项
     * @param int     $parentId 父菜单ID
     * @param boolean $withSelf 是否包括他自己
     * @return array|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function adminMenu($parentId, $withSelf = false)
    {
        //父节点ID
        $parentId = intval($parentId);
        $result   = $this->where(['parent_id' => $parentId, 'status' => 1])->order("list_order", "ASC")->select();

        if ($withSelf) {
            $result2[] = $this->where('id', $parentId)->find();
            $result    = array_merge($result2, $result);
        }

        //权限检查
        if (cmf_get_current_admin_id() == 1) {
            //如果是超级管理员 直接通过
            return $result;
        }

        $array = [];

        foreach ($result as $v) {

            //方法
            $action = $v['action'];

            //public开头的通过
            if (preg_match('/^public_/', $action)) {
                $array[] = $v;
            } else {

                if (preg_match('/^ajax_([a-z]+)_/', $action, $_match)) {

                    $action = $_match[1];
                }

                $ruleName = strtolower($v['app'] . "/" . $v['controller'] . "/" . $action);
                if (nongye_auth_check(cmf_get_current_admin_id(), $ruleName)) {
                    $array[] = $v;
                }

            }
        }

        return $array;
    }



    /**
     * 取得树形结构的菜单
     * @param        $myId
     * @param string $parent
     * @param int    $Level
     * @return bool|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getTree($myId, $parent = "", $Level = 1)
    {
        $data = $this->adminMenu($myId);
        $Level++;
        if (count($data) > 0) {
            $ret = NULL;
            foreach ($data as $a) {
                $id         = $a['id'];
                $app        = $a['app'];
                $controller = ucwords($a['controller']);
                $action     = $a['action'];

                //附带参数
                $params = "";
                if (!empty($a['param'])) {
                    $params = htmlspecialchars_decode($a['param']);
                }

                if (strpos($app, 'plugin/') === 0) {
                    $pluginName = str_replace('plugin/', '', $app);
                    $url        = cmf_plugin_url($pluginName . "://{$controller}/{$action}{$params}");
                } else {
                    $url = url("{$app}/{$controller}/{$action}", $params);
                }

                $app = str_replace('/', '_', $app);

                $array = [
                    "icon"                    => $a['icon'],
                    "id"                      => $id,
                    "name"                    => $a['name'],
                    "parent"                  => $parent,
                    "url"                     => $a['force_target_url'] != '' ? $a['force_target_url'] : $url,
                    "type"                    => $a['type'],
                    "enable_force_target_url" => $a['force_target_url'] != '',
                    'lang'                    => strtoupper($app . '_' . $controller . '_' . $action),
                ];


                $ret[$id . $app] = $array;
                $child           = $this->getTree($a['id'], $id, $Level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $Level <= 4) {
                    $ret[$id . $app]['items'] = $child;
                }
            }
            return $ret;
        }

        return false;
    }


    /**
     * 更新缓存
     * @param null $data
     * @return array|null
     */
    public function menuCache($data = null)
    {
        if (empty($data)) {
            $data = $this->order("list_order", "ASC")->column('*');
            Cache::set('Menu', $data, 0);
        } else {
            Cache::set('Menu', $data, 0);
        }
        return $data;
    }
}
