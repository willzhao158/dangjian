<?php /*a:1:{s:78:"D:\xampp\htdocs\paopao\public/themes/admin_simpleboot3/mobile\login\login.html";i:1589536152;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
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
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">用户登录</h2>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" id="mobile" pattern="[0-9]*" placeholder="请输入手机号"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" pattern="[0-9]*" placeholder="输入验证码"/>
                            </div>
                            <div class="weui-cell__ft">
                                <button class="weui-btn weui-btn_default btn-get-code" id="getCode">获取验证码</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="">登录</a>
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
    <script src="/themes/admin_simpleboot3/public/massets/lib/common.js"></script>
    <script type="text/javascript">
        
        function sendsms(mobile){
            $.ajax({
                url: "<?php echo url('login/sendcms'); ?>",
                type: 'post',
                dataType: 'json',
                data: {mobile: mobile},
                success: function (data) {

                },
                error: function () {

                },
                complete: function () {

                }
            });
        }
        
        $(function(){
            // 获取验证码
            $("#getCode").on("click",function(){

                var mobile = $("#mobile").val();

                if(mobile == ''){
                    showToastError('请输入手机号码');
                    return false;
                }

                if(!isPhoneNo(mobile)){
                    showToastError('请输入正确的手机号码');
                    return false;
                }


                sendsms(mobile);

                $(this).attr("disabled","disabled")
                $(this).addClass("weui-btn_disabled")
                var time = 60;
                var timer = setInterval(function(){
                    time--;
                    $("#getCode").html("倒计时"+time+"s");
                    if(time == 0){
                        clearInterval(timer)
                        $("#getCode").html("重新获取")
                        $("#getCode").removeAttr("disabled")
                        $("#getCode").removeClass("weui-btn_disabled")
                    }
                },1000)
            })
        })
    </script>
</body>
</html>