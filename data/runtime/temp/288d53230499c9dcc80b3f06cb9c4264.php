<?php /*a:2:{s:89:"D:\xampp\htdocs\guocai.yzata.cn\public/themes/admin_simpleboot3/order\index\show_con.html";i:1578969205;s:80:"D:\xampp\htdocs\guocai.yzata.cn\public/themes/admin_simpleboot3/public\farm.html";i:1577019110;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/layuiadmin/style/admin.css" media="all">

    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo app('request')->module(); ?>'/*当前应用名*/
        };
        var SystemName = "国财财务订单财务管理系统";
        var area = ['100%','100%'];

        

    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });


       

       
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
</head>
<body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <form class="layui-form" >
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <div class="uploadimg">
                                <?php if(is_array($urls) || $urls instanceof \think\Collection || $urls instanceof \think\Paginator): $i = 0; $__LIST__ = $urls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$url): $mod = ($i % 2 );++$i;?>
                                    <img src="<?php echo $url; ?>" style="margin:5px">
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="/themes/admin_simpleboot3/public/layuiadmin/layui/layui.js"></script>
<script type="text/javascript">
layui.use(['layer','form','upload'], function(){
    var form   = layui.form
        ,$     = layui.$
        ,upload = layui.upload
        ,layer = layui.layer;

    upload.render({
        elem: '#sample'
        ,url: '/Base/upload'
        ,done: function(res){
            if(res.code == 0){
                layer.msg(res.msg,{icon:2});
                return;
            }
            console.log(res);
            var upload = $('.uploadimg');
            upload.html('');
            upload.append('<img src="/'+res.msg+'" style="margin:5px">');

            $('input[name="sample"]').val(res.msg);
        }
    });

    form.on('submit(menu)',function(res){
        form.render();
        var submit = {
            url:'/Index/editPic',
            type:'POST',
            dataType:'json',
            data:new FormData(res.form),
            cache:false,
            processData:false,
            contentType:false,
            success:function(data){
                console.log(data);
                if(data.code){
                    layer.msg(data.msg,{icon:1});
                    setTimeout(function(){
                        parent.layer.closeAll();
                        
                    },1000);
                }else{
                    layer.msg(data.msg,{icon:2});
                }
            }
        };
        $.ajax(submit);
        return false;
    });


});
</script>

</html>