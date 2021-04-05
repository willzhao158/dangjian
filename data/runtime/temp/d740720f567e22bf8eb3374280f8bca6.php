<?php /*a:2:{s:84:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/admin/banner/index.html";i:1589620444;s:78:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/public/admin.html";i:1589619552;}*/ ?>
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
        var SystemName = "泡泡同城";
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
<body>
	<div class="layui-fluid">
		<div class="layui-card">
			<div class="layui-card-body">
				<div class="demoTable">
				  <div class="layui-inline">
				    <input class="layui-input" name="id" id="demoReload" autocomplete="off" placeholder="请输入认证产品名称">
          </div>
<!--          <a class="layui-btn search_btn "  id="searchBtn"  data-type="getInfo" style="margin-left: 15px;">搜索</a>-->
          <button class="layui-btn " data-type="addbanner">新增</button>
          <button class="layui-btn " data-type="delbanner">删除</button>
				  <button class="layui-btn " data-type="bannerreload">刷新</button>
				</div>
				
			</div>
			<div class="layui-card-body">
				<table class="layui-hide" id="banner" lay-filter="banner"></table>
			</div>
		</div>
	</div>
</body>
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script src="/themes/admin_simpleboot3/public/layuiadmin/layui/layui.js"></script>
<script type="text/javascript">
layui.use(['table','layer'], function(){
  var table = layui.table ,$ = layui.$, layer = layui.layer;

  //方法级渲染
  table.render({
    elem: '#banner'
    ,url: '/banner/datalist'
    ,cols: [[
    {checkbox: true, fixed: true},
      {field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
      ,{field:'cname', title: '图片',sort: true}
      ,{field:'cername', title: '链接'}
      ,{fixed: 'right', title: '操作', width:130, align:'center', toolbar: '#barDemo'}
    ]]
    ,id: 'bannerReload'
    ,page: true
    ,done:function(res){
    }
  });
  var $ = layui.$, active = {
    reload: function(){
      var demoReload = $('#demoReload');
      //执行重载
      table.reload('bannerReload', {
        page: {
          curr:1 //重新从第 1 页开始
        }
        ,where: {
            name:demoReload.val()
        }
      }, 'data');
    },
    addbanner:function(){
        layer.open({
          type:2,
          area:area,
          title:SystemName,
          content:'/banner/add'
        });
    },
    delbanner:function(){
		var that = this;
		var checkStatus = table.checkStatus('bannerReload');
		var data = checkStatus.data;
        var id = new Array();
        data.forEach(function(item){
        	id.push(item.id);
        });
        active.delaction(id.join(','));
    },
    delaction:function(params){
       layer.confirm('确定删除吗？',{icon:3},function(index){
        $.post('/farm/banner/delaction',{params:params},function(res){
          if(res.code){
            layer.msg(res.msg,{icon:1});
            setTimeout(function(){
              table.reload('bannerReload');
            },1000);
          }else{
            layer.msg(res.msg,{icon:2});
          }
        });
      });
    },
    bannerreload:function(){
    	table.reload('bannerReload');
    },
    edit:function(obj){
      layer.open({
        type:2,
        area:area,
        title:SystemName,
        content:'/farm/banner/edit/id/' + obj.data.id
      });
    },
    del:function(obj){
      active.delaction(obj.data.id);
    }
  };
  window.fun = active;
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
  table.on('tool(banner)',function(obj){
      active[obj.event] ? active[obj.event].call(this,obj) : '';
  });
  //监听单元格编辑
  table.on('edit(banner)', function(obj){
    var value = obj.value //得到修改后的值
    ,data = obj.data //得到所在行所有键值
    ,field = obj.field; //得到字段
    var update = {id:data.id,[field]:value};
    var load = layer.load(0,{shade:0});
    $.post('/farm/banner/editaction',{params:update},function(res){
    	if(res.code){
    		layer.msg(res.msg);
    	}else{
    		layer.msg(res.msg);
    	}
      table.reload('bannerReload');
    	layer.close(load);
    });
  });
});
</script>
</html>