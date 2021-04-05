<?php /*a:2:{s:81:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/my/index.html";i:1590394013;s:79:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/public/footer.html";i:1590141498;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="ucenter-header">
            <div class="user-info flex flex-align-center">
                <!-- <div class="user-img"></div> -->
                <div class="flex-1">
                    <h1><?php echo $user['name']; ?></h1>
                    <p>Id号：<?php echo $user['id']; ?></p>
                    <p>注册时间：<?php echo date('Y-m-d',$user['createtime'])?></p>
                </div>
                <a href="<?php echo url('charge/index'); ?>" class="btn-charge">充值</a>
            </div>
            <ul class="user-num flex">
                <li class="flex-1">
                    <p><?php echo $user['jifen']; ?></p>
                    <p>积分</p>
                </li>
                <li class="flex-1">
                    <a href="my_fans.html">
                        <p>9999</p>
                        <p>粉丝</p>
                    </a>
                </li>
                <li class="flex-1">
                    <p>9999</p>
                    <p>团队</p>
                </li>
            </ul>
        </div>
        <div class="ucenter-body">
            <a class="upgrade-banner flex flex-align-center flex-pack-justify" href="<?php echo url('my/my_vip'); ?>">
                <p>升级VIP商家享有更多权益</p>
                <span>了解详情</span>
            </a>
            <a class="upgrade-banner flex flex-align-center flex-pack-justify" href="<?php echo url('shop/auth'); ?>">
                <p>商家认证</p>
                <span>了解详情</span>
            </a>
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="my_wallet.html">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconwallet"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>我的钱包</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href=""><!-- 普通 -->
                    <div class="weui-cell__hd">
                        <i class="iconfont iconbook"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>我的活动劵</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href=""><!-- vip -->
                    <div class="weui-cell__hd">
                        <i class="iconfont iconbook"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>我的广告券</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconbook"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>我的抢购劵</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="my_message.html">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconmessage"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>消息中心</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="my_collect.html">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconstar"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>我的收藏</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="my_phone.html">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconphone"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>修改手机号</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="<?php echo url('address/address_list'); ?>">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconlocation"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>收货地址</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="javascript:;" id="cancelAccount">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconlogout"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>帐号注销</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="javascript:;" id="appDown">
                    <div class="weui-cell__hd">
                        <i class="iconfont icondownload"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>app下载</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="javascript:;" id="appShare">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconshare"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>分享</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconquestion-circle"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>操作教程</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconcontrol"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>推广规则</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <!-- 普通用户 -->
                <!-- <a class="weui-cell weui-cell_access upgrade-vip" href="javascript:;">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconsafetycertificate"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>商家认证</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access  upgrade-vip" href="javascript:;">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconappstore"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>门店管理</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a> -->
                <!-- VIP -->
                <a class="weui-cell weui-cell_access upgrade-vip" href="merchant_form.html">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconsafetycertificate"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>商家认证</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access upgrade-vip" href="<?php echo url('shop/shop_manage'); ?>">
                    <div class="weui-cell__hd">
                        <i class="iconfont iconappstore"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>门店管理</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
        </div>
    </div>
    <!-- ============= 底部导航 start ============== -->
    <div class="weui-tabbar">
    <a class="weui-tabbar__item weui-bar__item_on" href="<?php echo url('index/index'); ?>">
        <i class="weui-tabbar__icon iconfont iconhome"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a class="weui-tabbar__item" href="share.html">
        <i class="weui-tabbar__icon iconfont iconshare"></i>
        <p class="weui-tabbar__label">分享</p>
    </a>
    <a class="weui-tabbar__item" href="mall.html">
        <i class="weui-tabbar__icon iconfont iconshopping"></i>
        <p class="weui-tabbar__label">积分商城</p>
    </a>
    <a class="weui-tabbar__item" href="<?php echo url('my/index'); ?>">
        <i class="weui-tabbar__icon iconfont iconuser"></i>
        <p class="weui-tabbar__label">我的</p>
    </a>
</div>
    <!-- ============= 底部导航 end ============== -->
    <!-- 帐号注销须知 start -->
    <div class="js_dialog" id="cancelAccountDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">帐号注销须知</strong></div>
            <div class="weui-dialog__bd">帐号注销须知帐号注销须知帐号注销须知帐号注销须知帐号注销须知帐号注销须知帐号注销须知</div>
            <div class="weui-dialog__ft">
                <a href="javascript:" class="weui-dialog__btn weui-dialog__btn_default" onclick="hideCancelAccountDialog()">取消</a>
                <a href="javascript:" class="weui-dialog__btn weui-dialog__btn_primary" id="btnCancelAccount">确定</a>
            </div>
        </div>
    </div>
    <!-- 帐号注销须知 end -->
    <!-- app下载 start -->
    <div class="js_dialog" id="appDownDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">app下载</strong></div>
            <div class="weui-dialog__bd">
                <img src="assets/images/2.png" alt="">
            </div>
            <div class="weui-dialog__ft">
                <a href="javascript:" class="weui-dialog__btn weui-dialog__btn_primary" onclick="hideAppDownDialog()">关闭</a>
            </div>
        </div>
    </div>
    <!-- app下载 end -->
    <!-- 分享 start -->
    <div class="js_dialog" id="appShareDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">分享</strong></div>
            <div class="weui-dialog__bd">
                <img src="assets/images/2.png" alt="">
            </div>
            <div class="weui-dialog__ft">
                <a href="javascript:" class="weui-dialog__btn weui-dialog__btn_primary" onclick="hideAppShareDialog()">关闭</a>
            </div>
        </div>
    </div>
    <!-- 分享 end -->
    
    <!-- 请升级为VIP商家 start -->
    <div class="js_dialog" id="upgradeVipDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd">请升级为VIP商家</div>
            <div class="weui-dialog__ft">
                <a href="my_vip.html" class="weui-dialog__btn weui-dialog__btn_primary">去升级</a>
            </div>
        </div>
    </div>
    <!-- 请升级为VIP商家 end -->
    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript">
        function hideCancelAccountDialog(){
            $("#cancelAccountDialog").fadeOut(200);
        }
        function hideAppDownDialog(){
            $("#appDownDialog").fadeOut(200);
        }
        function hideAppShareDialog(){
            $("#appShareDialog").fadeOut(200);
        }
        function hideUpgradeVipDialog(){
            $("#upgradeVipDialog").fadeOut(200);
        }
        $(function(){
            // 帐号注销
            $("#cancelAccount").on("click",function(){
                $("#cancelAccountDialog").fadeIn(200);
            })
            $("#btnCancelAccount").on("click",function(){
            })
            // app下载
            $("#appDown").on("click",function(){
                $("#appDownDialog").fadeIn(200);
            })
            // 分享
            $("#appShare").on("click",function(){
                $("#appShareDialog").fadeIn(200);
            })
            // 升级为VIP商家
            $(".upgrade-vip").on("click",function(){
                $("#upgradeVipDialog").fadeIn(200);
            })
        })
    </script>
</body>
</html>