<?php /*a:1:{s:83:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/order/login/login.html";i:1577366002;}*/ ?>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo Config('title'); ?></title>
    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="/themes/admin_simpleboot3/public/hplus/login/css/style.css">
    <link rel="stylesheet" type="text/css" href="/themes/admin_simpleboot3/public/hplus/login/css/reset.css">
    <style type="text/css">
        .copyright{
            margin: 0px auto;
            width: 368px;
            margin-top: 230px;
            text-align: center;
            margin-left: -9px;
        }
        .login{
            opacity: 0.8
        }
    </style>
</head>
<body>

<div id="particles-js">
    <div class="login">
        <div class="login-top">
            国财财务订单财务管理系统
        </div>
        <div class="login-center clearfix">
            <div class="login-center-img"><img src="/themes/admin_simpleboot3/public/hplus/login/img/name.png"></div>
            <div class="login-center-input">
                <input type="text"  name="username" id="username" placeholder="请输入您的用户名" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的用户名'">
                <div class="login-center-input-text">用户名</div>
            </div>
        </div>
        <div class="login-center clearfix">
            <div class="login-center-img"><img src="/themes/admin_simpleboot3/public/hplus/login/img/password.png"></div>
            <div class="login-center-input">
                <input type="password" name="password"  id="password" value="" placeholder="请输入您的密码" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的密码'">
                <div class="login-center-input-text">密码</div>
            </div>
        </div>
        <div class="login-button">
            登陆
        </div>
        <div class="copyright">版权所有 2018 - 2019 国财财务订单财务管理系统</div>
    </div>
    <div class="sk-rotating-plane"></div>
    <canvas class="particles-js-canvas-el" width="1903" height="479" style="width: 100%; height: 100%;"></canvas>
    
</div>

<!-- scripts -->
<script src="/themes/admin_simpleboot3/public/hplus/login/js/particles.min.js"></script>
<script src="/themes/admin_simpleboot3/public/hplus/login/js/app.js"></script>

<script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
<script src="/themes/admin_simpleboot3/public/login/lib/jquery-plugin/jqueryui/jquery-ui.js"></script>
<script src="/themes/admin_simpleboot3/public/hplus/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript">
    function hasClass(elem, cls) {
      cls = cls || '';
      if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
      return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
    }
     
    function addClass(ele, cls) {
      if (!hasClass(ele, cls)) {
        ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
      }
    }
     
    function removeClass(ele, cls) {
      if (hasClass(ele, cls)) {
        var newClass = ' ' + ele.className.replace(/[\t\r\n]/g, '') + ' ';
        while (newClass.indexOf(' ' + cls + ' ') >= 0) {
          newClass = newClass.replace(' ' + cls + ' ', ' ');
        }
        ele.className = newClass.replace(/^\s+|\s+$/g, '');
      }
    }
        document.querySelector(".login-button").onclick = function(){

            var username = $("#username").val();
            var password = $("#password").val();
            if(username == ''){
                layer.msg('请输入用户名', { offset: '100px' });
                return false;
            }
            if(password == ''){
                layer.msg('请输入密码', { offset: '100px' });
                return false;
            }
            $.ajax({
                url: "<?php echo url('login/dologin'); ?>",
                type: 'post',
                dataType: 'json',
                data:{
                        username:username,
                        password:password
                      },
                success: function (data) {
                    if(data['code'] == 1){
                        addClass(document.querySelector(".login"), "active")
                        setTimeout(function(){
                            addClass(document.querySelector(".sk-rotating-plane"), "active")
                            document.querySelector(".login").style.display = "none"
                        },800)
                        setTimeout(function(){
                            removeClass(document.querySelector(".login"), "active")
                            removeClass(document.querySelector(".sk-rotating-plane"), "active")
                            document.querySelector(".login").style.display = "block"
                            layer.msg(data['msg'], { offset: '100px' })
                            
                        },2000)
                        layer.msg(data['msg'], { offset: '100px' });
                        setTimeout(function(){
                            window.location.href = "<?php echo url('index/index'); ?>";
                        },2100)
                        
                        
                    }else{
                        layer.msg(data['msg'], { offset: '100px' });
                        return false;
                    }
                },
                error: function () {

                },
                complete: function () {

                }
            });

            
        }
</script>

</body></html>