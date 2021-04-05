<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

namespace plugins\nongye;

//Demo插件英文名，改成你的插件英文就行了
use cmf\lib\Plugin;

//TODO 现在代码都覆盖了vendor下的文件 最好用plugin形式 还原vendor下的文件 以便于以后升级composer

//Demo插件英文名，改成你的插件英文就行了
class NongyePlugin extends Plugin
{
    public $info = [
        'name'        => 'nongye', //Demo插件英文名，改成你的插件英文就行了
        'title'       => 'nongyechajian',
        'description' => 'nongyechajian',
        'status'      => 1,
        'author'      => '',
        'version'     => '1.0',
        'demo_url'    => '',
        'author_url'  => '',
    ];

    public $hasAdmin = 0; //插件是否有后台管理界面

    // 插件安装
    public function install()
    {
        return true; //安装成功返回true，失败false
    }

    // 插件卸载
    public function uninstall()
    {
        return true; //卸载成功返回true，失败false
    }

    //实现的footer_start钩子方法
    public function footerStart($param)
    {
        $config = $this->getConfig();
        $this->assign($config);
        echo $this->fetch('widget');
    }
}
