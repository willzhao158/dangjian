<?php /*a:1:{s:93:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/address/address_list.html";i:1590376624;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>收货地址</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
</head>
<body>

    <div class="container">
        <ul class="address-list">
            <?php if(is_array($address_list) || $address_list instanceof \think\Collection || $address_list instanceof \think\Paginator): $i = 0; $__LIST__ = $address_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$address): $mod = ($i % 2 );++$i;?>
                <li class="flex flex-align-center flex-pack-justify">
                    <div class="flex-1">
                        <div class="flex flex-align-center">
                            <h1><?php echo $address['name']; ?></h1>
                            <span><?php echo $address['mobile']; ?></span>
                        </div>
                        <p><?php if($address['isdefault']==1): ?><small>默认</small><?php endif; ?><?php echo $address['province']; ?><?php echo $address['city']; ?><?php echo $address['district']; ?><?php echo $address['address']; ?></p>
                    </div>
                    <a href="address_edit?id=<?php echo $address['id']; ?>">编辑</a>
                </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <a href="address_add.html" class="weui-btn weui-btn_primary m-t-30">新增收货地址</a>
    </div>

    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript">
        $(function(){
            
        })
    </script>
</body>
</html>