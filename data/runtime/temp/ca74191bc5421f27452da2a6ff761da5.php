<?php /*a:1:{s:82:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/my/my_vip.html";i:1590200291;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>升级VIP</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
</head>
<body>
    <div class="container">
        <img src="/themes/admin_simpleboot3/public/massets/images/2.png" width="100%" alt="">
        <a href="javascript:;" class="btn-upgrade">立即升级</a>
    </div>
    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.btn-upgrade').on('click', function () {
                weui.picker([{
                    label: '支付宝',
                    value: 0
                }, {
                    label: '余额支付',
                    value: 1
                }], {
                    onConfirm: function (result) {
                        console.log(result);
                    },
                    title: '请选择支付方式'
                });
            });
        })
    </script>
</body>
</html>