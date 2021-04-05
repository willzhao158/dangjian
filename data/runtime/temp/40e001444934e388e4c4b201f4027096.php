<?php /*a:2:{s:85:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/order/index/id_type.html";i:1577370679;s:77:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/public/farm.html";i:1577019110;}*/ ?>
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
<body>
  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-card-body">
        <div class="demoTable">
          <div class="layui-inline">
            <input class="layui-input" name="id" id="demoReload" autocomplete="off" placeholder="请输入证件类型">
          </div>
          <button class="layui-btn" data-type="reload">搜索</button>
          <button class="layui-btn " data-type="addPlace">新增证件类型</button>
          <button class="layui-btn " data-type="delPlace">删除证件类型</button>
          <button class="layui-btn " data-type="Placereload">刷新</button>
        </div>
      </div>
      <div class="layui-card-body">
        <table class="layui-hide" id="Place" lay-filter="Place"></table> 
      </div>
    </div>
  </div> 
</body>
<script src="/themes/admin_simpleboot3/public/layuiadmin/layui/layui.js"></script>
<script type="text/javascript">
layui.use(['table','layer','form','laydate'], function(){
  var table = layui.table
      ,layer = layui.layer
      ,laydate = layui.laydate;
  var form   = layui.form;
  //方法级渲染
  table.render({
    elem: '#Place'
    ,url: "/index/getidtype/"
    ,cols: [[
      {checkbox: true, fixed: true}
      ,{field:'name', title: '证件类型', edit: 'text'}
    ]]
    ,id: 'PlaceReload'
    ,page: true
    
  });
 
  var $ = layui.$, active = {
    reload: function(){
      var demoReload = $('#demoReload');
      
      //执行重载
      table.reload('PlaceReload', {
        page: {
          curr: 1 //重新从第 1 页开始
        }
        ,where: {
            name: demoReload.val()
        }
      }, 'data');
    },
    addPlace:function(){
      $.post('/index/addidtype',function(res){
        if(res.code){
          table.reload('PlaceReload');
          layer.msg(res.msg,{icon:1});
        }else{
          layer.msg(res.msg,{icon:2});
        }
      });
      // layer.open({
      //   type:2,
      //   area:area,
      //   title:SystemName,
      //   content:'/index/add'
      // });
    },
    delPlace:function(){
    var that = this;
    var checkStatus = table.checkStatus('PlaceReload');
    var data = checkStatus.data;
        var id = new Array();
        data.forEach(function(item){
          id.push(item.id);
        });
        
        layer.confirm('确定删除吗？',{icon:3},function(index){
          $.post('/index/delidtype',{params:id.join(',')},function(res){
            if(res.code){
              table.reload('PlaceReload');
              layer.msg(res.msg,{icon:1});
            }else{
              layer.msg(res.msg,{icon:2});
            }
          });
        });

       


    },
    Placereload:function(){
      table.reload('PlaceReload');
    }
  };
  window.fun = active;
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });

  form.on('select(tran_company)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,tran_company:data.value};
    $.post('/index/editidtype',{params:update},function(res){
      if(res.code){
        layer.msg(res.msg);
      }else{
        table.reload('PlaceReload');
        layer.msg(res.msg);
      }
      //layer.close(load);
    });
  });

  form.on('select(back_way)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,back_way:data.value};
    $.post('/index/editaction',{params:update},function(res){
      if(res.code){
        layer.msg(res.msg);
      }else{
        table.reload('PlaceReload');
        layer.msg(res.msg);
      }
      //layer.close(load);
    });
  });

  form.on('select(xinghuo)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,isxinghuo:data.value};
    $.post('/index/editaction',{params:update},function(res){
      if(res.code){
        layer.msg(res.msg);
      }else{
        table.reload('PlaceReload');
        layer.msg(res.msg);
      }
      //layer.close(load);
    });
  });

  //监听单元格编辑
  table.on('edit(Place)', function(obj){
    var value = obj.value //得到修改后的值
    ,data = obj.data //得到所在行所有键值
    ,field = obj.field; //得到字段
    var update = {id:data.id,[field]:value};
    var load = layer.load(0,{shade:0.5});
    $.post('/index/editidtype',{params:update},function(res){
      if(res.code){
        layer.msg(res.msg);
      }else{
        table.reload('PlaceReload');
        layer.msg(res.msg);
      }
      layer.close(load);
    });

  });

  table.on('tool(Place)', function(obj){
    var data = obj.data //获得当前行数据
    ,layEvent = obj.event; //获得 lay-event 对应的值
    var newdata = {};
    switch(obj.event){
      case 'edit':
        layer.open({
            type:2,
            area:area,
            title:SystemName,
            content:'/index/edit/id/'+data.id+'.html'
        });
        break;
      case 'upload':
        layer.open({
            type:2,
            area:area,
            title:SystemName,
            content:'/index/addupload/id/'+data.id+'.html'
        });
        break;
      case 'show_con':
        layer.open({
            type:2,
            area:area,
            title:SystemName,
            content:'/index/show_con/id/'+data.id+'.html'
        });
        break;
      case 'date':
        var field = $(this).data('field');
        laydate.render({
          elem: this.firstChild
          , show: true //直接显示
          ,type: 'month'
          , done: function (value, date) {

            var update = {id:data.id,[field]:value};
            var load = layer.load(0,{shade:0.5});
            $.post('/index/editback',{params:update},function(res){
              if(res.code){
                layer.msg(res.msg);
              }else{
                table.reload('PlaceReload');
                layer.msg(res.msg);
              }
              layer.close(load);
            });
          }
        });
        break;
    };
  });
  
});
</script>
</html>