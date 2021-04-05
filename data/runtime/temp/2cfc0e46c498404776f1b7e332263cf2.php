<?php /*a:1:{s:81:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/order/user/info.html";i:1577021683;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>国财财务订单财务管理系统</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="/themes/admin_simpleboot3/public/hplus/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/hplus/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/hplus/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/hplus/css/animate.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/hplus/css/style.css?v=4.1.0" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/hplus/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <script>
        //全局变量
        var GV = {
            HOST: "<?php echo (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] !== '')?$_SERVER['HTTP_HOST']:''); ?>",
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/"
        };
    </script>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>修改信息</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal js-ajax-form" action="<?php echo url('order/user/info'); ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">昵称</label>

                                <div class="col-sm-10">
                                    <input type="text" name="user_nickname" value="<?php echo $user['user_nickname']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">性别</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="sex">
                                        <option value="0" <?php if($user['sex']==0): ?>selected<?php endif; ?>>保密</option>
                                        <option value="1" <?php if($user['sex']==1): ?>selected<?php endif; ?>>男</option>
                                        <option value="2" <?php if($user['sex']==2): ?>selected<?php endif; ?>>女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">生日</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="birthday" id="birthday" value="<?php echo date('Y-m-d',$user['birthday']); ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">个人网址</label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="提示信息" class="form-control" name="user_url" value="<?php echo $user['user_url']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">个性签名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="signature" class="form-control" value="<?php echo $user['signature']; ?>">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-w-m btn-primary js-ajax-submit">保存</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/themes/admin_simpleboot3/public/hplus/js/jquery.min.js?v=2.1.4"></script>
    <script src="/themes/admin_simpleboot3/public/hplus/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/themes/admin_simpleboot3/public/hplus/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- 自定义js -->
    <script src="/themes/admin_simpleboot3/public/hplus/js/content.js?v=1.0.0"></script>

    <!-- iCheck -->
    <script src="/themes/admin_simpleboot3/public/hplus/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#birthday').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        });
    </script>
    <script src="/static/js/wind.js"></script>
    <script src="/static/js/admin.js"></script>

</body>

</html>
