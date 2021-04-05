<?php /*a:1:{s:93:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/address/address_edit.html";i:1590385179;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>编辑收货地址</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
    <style>
        html,body{background-color: #ffffff;}
    </style>
</head>
<body>

    <div class="container">
        <div class="weui-form">
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">联系人</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" value="<?php echo $address['name']; ?>" id="name" type="text" placeholder="收货人姓名"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" value="<?php echo $address['mobile']; ?>" id="mobile" pattern="[0-9]*" placeholder="收货人手机号码"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">地区</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showCityInput" value="<?php echo $address['city']; ?>"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showCityPicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">地址</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="address" placeholder="楼号 门牌"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active weui-cell_switch">
                            <div class="weui-cell__bd"><label class="weui-label">设为默认</label></div>
                            <div class="weui-cell__ft">
                                <input class="weui-switch" type="checkbox" name="isdefault" checked="checked"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="">保存</a>
                <a class="weui-btn weui-btn_warn" href="javascript:" id="">删除收货地址</a>
            </div>
        </div>
    </div>

    <!-- success toast-->
    <div id="toastSuccess" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">操作成功</p>
        </div>
    </div>
    <!-- success toast-->

    <!-- error toast-->
    <div id="toastError" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-warn weui-icon_msg weui-icon_toast"></i>
            <p class="weui-toast__content">请检查您的输入</p>
        </div>
    </div>
    <!-- error toast-->

    <!-- loading toast-->
    <div id="toastLoading" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">正在加载...</p>
        </div>
    </div>
    <!-- loading toast-->

    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript">
        function showToastSuccess(msg){
            if ($("#toastSuccess").css('display') != 'none') return;
            $("#toastSuccess").fadeIn(100);
            $("#toastSuccess .weui-toast__content").html(msg)
            setTimeout(function () {
                $("#toastSuccess").fadeOut(100);
            }, 2000);
        }
        function showToastError(msg){
            if ($("#toastError").css('display') != 'none') return;
            $("#toastError").fadeIn(100);
            $("#toastError .weui-toast__content").html(msg)
            setTimeout(function () {
                $("#toastError").fadeOut(100);
            }, 2000);
        }
        function showToastLoading(msg){
            $("#toastLoading").fadeIn(100);
            $("#toastLoading .weui-toast__content").html(msg)
        }
        function hideToastLoading(){
            $("#toastLoading").fadeOut(100);
        }
        
        $(function(){
            var areaList = <?php echo $allcity; ?>;
            $('#showCityPicker').on('click', function () {
                weui.picker(areaList, {
                    defaultValue: $("#showCityInput").val().split(","),
                    onConfirm: function (result) {
                        $("#showCityInput").val([result[0].value,result[1].value,result[2].value])
                        $('#showCityPicker').val(result[0].label+" "+result[1].label+" "+result[2].label);
                    },
                    title: '请选择'
                });
            });
        })
    </script>
</body>
</html>