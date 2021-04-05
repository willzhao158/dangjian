<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Released under the MIT License.
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------

namespace app\www\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        return $this->fetch(':index');
    }
    public function help()
    {
        return $this->fetch(':help');
    }
    public function list()
    {
        return $this->fetch(':list');
    }
	public function detail()
    {
        // $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
 
    //分析数据
    // $is_pc = (strpos($agent, 'windows nt')) ? true : false;  
    // $is_iphone = (strpos($agent, 'iphone')) ? true : false;  
    // $is_ipad = (strpos($agent, 'ipad')) ? true : false;  
    // $is_android = (strpos($agent, 'android')) ? true : false;  
        if($this->isMobile()){
            return $this->fetch(':mobile');
        }else{
            return $this->fetch(':detail');
        }
    }
    public function certify()
    {
        return $this->fetch(':certify');
    }
    public function map()
    {
        return $this->fetch(':map');
    }
    public function photo()
    {
        return $this->fetch(':photo');
    }
    // public function mobile()
    // {
    //     return $this->fetch(':mobile');
    // }
    /**
 * 移动端判断
 */
    function isMobile()
    { 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
    return true;
    } 
    // 如果via信息含有wap则一定是移动设备
    if (isset ($_SERVER['HTTP_VIA']))
    { 
    // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
    $clientkeywords = array ('nokia',
    'sony',
    'ericsson',
    'mot',
    'samsung',
    'htc',
    'sgh',
    'lg',
    'sharp',
    'sie-',
    'philips',
    'panasonic',
    'alcatel',
    'lenovo',
    'iphone',
    'ipod',
    'blackberry',
    'meizu',
    'android',
    'netfront',
    'symbian',
    'ucweb',
    'windowsce',
    'palm',
    'operamini',
    'operamobi',
    'openwave',
    'nexusone',
    'cldc',
    'midp',
    'wap',
    'mobile'
    ); 
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
    {
    return true;
    } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
    // 如果只支持wml并且不支持html那一定是移动设备
    // 如果支持wml和html但是wml在html之前则是移动设备
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
    {
    return true;
    } 
    } 
    return false;
    }
}
