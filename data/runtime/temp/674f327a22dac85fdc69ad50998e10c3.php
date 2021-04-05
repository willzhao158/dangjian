<?php /*a:1:{s:81:"D:\xampp\htdocs\guocai.yzata.cn\public/themes/admin_simpleboot3/admin\\login.html";i:1577366005;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title>瑞丰智慧农业云平台</title>
    <link rel="shortcut icon" href="/themes/admin_simpleboot3/public/login/images/favicon.ico" />
   
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/login/lib/jquery-plugin/jqueryui/jquery-ui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/login/lib/CloudTools/css/icfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/login/lib/CloudTools/css/toolcloud.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/login/css/login.css">
</head>
<body>
    <div class="page login-page">
        <div class="top-bar">
            <div class="top-l">
                <div class="logo">
                    <img src="/themes/admin_simpleboot3/public/login/images/logo2.png">
                </div>
            </div>
        </div>
        <div class="login-form mt80">
            <div class="title">
                <h2>瑞丰智慧农业云平台</h2>
                <p>使用瑞丰智慧农业云平台，令农业生产更科学高效</p>
            </div>
            <form class="js-ajax-form" onsubmit="check()" action="<?php echo url('public/doLogin'); ?>" method="post">
                <ul>
                    <li>
                        <input type="text" class="form-text form-text-block" placeholder="<?php echo lang('USERNAME_OR_EMAIL'); ?>" name="username" id="input_username" autocomplete="off" title="<?php echo lang('USERNAME_OR_EMAIL'); ?>"
                               value="<?php echo cookie('admin_username'); ?>" data-rule-required="true" data-msg-required="">
                    </li>
                    <li class="mt20">
                        <input type="password" name="password" id="input_password"  class="form-text form-text-block"  id="txtPassword" autocomplete="off" placeholder="<?php echo lang('PASSWORD'); ?>" title="<?php echo lang('PASSWORD'); ?>" data-rule-required="true"
                               data-msg-required="">
                    </li>
                    <li class="mt40">
                        <!-- <a href="javascript:;" class="btn btn-primary btn-block" id="J_btnUserLogin"><?php echo lang('LOGIN'); ?></a> -->
                        <button class="btn btn-primary btn-block js-ajax-submit" type="submit" style="margin-left: 0px;font-size: 20px" data-loadingmsg="<?php echo lang('LOADING'); ?>">
                            <?php echo lang('LOGIN'); ?>
                        </button>
                    </li>
                </ul>
            </form>
        </div>
        <div class="content-display">
            <div class="item img-r">
                <div class="img"><img src="/themes/admin_simpleboot3/public/login/images/img_home_001.png"></div>
                <div class="text">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>全产业链智慧农业服务</p>
                    </div>
                    <p>瑞丰智慧农业云平台采用全新&nbsp;“软件+服务”&nbsp;系统架构，</p>
                    <p>通过无缝整合第三方服务，</p>
                    <p style="width: 440px;">为客户提供从生产端&nbsp;“农业物联网监控”&nbsp;、“农业标准化生产管理”，
                    到销售端&nbsp;“农产品安全追溯”&nbsp;的全产业链智慧农业服务。</p>
                </div>
            </div>
            <div class="item">
                <div class="text slide-right">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>50多种智能设备支持</p>
                    </div>
                    <p>瑞丰智慧农业云平台可支持50多种传感控制设备，</p>
                    <p>3公里超远距离组网通讯，</p>
                    <p>5毫瓦超低功耗待机，</p>
                    <p>24小时全天候监控，</p>
                    <p>为客户提供从种植到养殖的农业物联网监控解决方案。</p>
                </div>
                <div class="img slide-left"><img src="/themes/admin_simpleboot3/public/login/images/img_home_002.png"></div>
            </div>
            <div class="item img-r">
                <div class="img slide-right"><img src="/themes/admin_simpleboot3/public/login/images/img_home_003.png"></div>
                <div class="text slide-left">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>农业标准化生产系统全<br>新上线</p>
                    </div>
                    <p>瑞丰智慧农业云平台上线“农业标准化生产系统”，</p>
                    <p>为农作物品类建立生产管理模型，</p>
                    <p>将农业生产从因人而异的传统模式，</p>
                    <p>变革为标准化管理的现代模式，</p>
                    <p>通过数据驱动农业生产标准化落地，</p>
                    <p>为黑龙江鸡东县高标准农田指定服务系统。</p>
                </div>
            </div>
            <div class="item">
                <div class="text slide-right">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>一物一码农产品安全<br>追溯</p>
                    </div>
                    <p>瑞丰智慧农业云平台为农产品建立可视化产品档案，</p>
                    <p>实现从农田到餐桌双向可追溯，</p>
                    <p>通过一物一码技术实现产品防伪鉴真，</p>
                    <p>并精准获取客户分布数据。</p>
                </div>
                <div class="img slide-left"><img src="/themes/admin_simpleboot3/public/login/images/img_home_004.png"></div>
            </div>
            <div class="item img-r">
                <div class="img slide-right"><img src="/themes/admin_simpleboot3/public/login/images/img_home_005.png"></div>
                <div class="text slide-left">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>强大的智能预警系统</p>
                    </div>
                    <p>瑞丰智慧农业云平台预警范围从物联网设备数据预警，</p>
                    <p>扩展到未来天气、病虫害、农事任务多维度预警，</p>
                    <p>让客户感受前所未有的洞察预见能力。</p>
                </div>
            </div>
            <div class="item">
                <div class="text slide-right">
                    <div class="tit">
                        <div class="ico"></div>
                        <p>农业大数据全景展示</p>
                    </div>
                    <p>瑞丰智慧农业云平台全新推出农业大数据报表系统，</p>
                    <p>利用数据科学技术，</p>
                    <p>提取从环境、农资、生理、产量库存，</p>
                    <p>到农事、用工等农业生产关键元素，</p>
                    <p>为客户提供多维度、可视化的大数据全景展示。</p>
                </div>
                <div class="img slide-left"><img src="/themes/admin_simpleboot3/public/login/images/img_home_006.png"></div>
            </div>
            <div class="item_bottom_ico">
                <div class="item img-r slide-bottom" style="padding-bottom: 200px;">
                    <div class="img"><img src="/themes/admin_simpleboot3/public/login/images/img_home_007.png"></div>
                    <div class="text">
                        <div class="tit">
                            <div class="ico"></div>
                            <p>更好更酷的用户体验</p>
                        </div>
                        <p>瑞丰智慧农业云平台针对用户界面进行了专业及个性化的设计，</p>
                        <p>旨在为用户提供更直观的数据展示，</p>
                        <p>更便捷的系统交互，以及更炫酷的用户体验。</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright slide-bottom">版权所有 2018 - <span id="copyrightYear"></span> 国财财务订单财务管理系统</div>
    </div>
    
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/login/lib/jquery-plugin/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: ''/*当前应用名*/
        };
    </script>
    <script src="/static/js/wind.js"></script>
    <script src="/static/js/admin.js"></script>
    <script>
        (function () {
            document.getElementById('input_username').focus();

            let now = new Date();
            let year = now.getFullYear();
            $("#copyrightYear").html(year)
        })();
        function check(){
            if($("#input_username1").val() == ''){
                alert("请输入用户名！")
                return
            }else if($("#txtPassword").val() == ''){
                alert("请输入密码！")
                return
            }
        }
    </script>
</body>
</html>
