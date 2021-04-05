<?php /*a:2:{s:85:"D:\xampp\htdocs\guocai.yzata.cn\public/themes/admin_simpleboot3/order\user\index.html";i:1578293644;s:80:"D:\xampp\htdocs\guocai.yzata.cn\public/themes/admin_simpleboot3/public\farm.html";i:1577019110;}*/ ?>
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
            <input class="layui-input" name="" id="user_login" autocomplete="off" placeholder="请输入用户名称">
          </div>
          
          <div class="layui-inline">
            <select name='' class="layui-input" id="level" style="width: 100px;">
              <option value="">请选择角色</option>
              <?php if($user['level']=='总公司'): ?>
              <option value="总公司">总公司</option>
              <?php endif; ?>
              <option value="分公司">分公司</option>
              <option value="业务经理">业务经理</option>
              
            </select>
          </div>
          
          <button class="layui-btn" data-type="reload">搜索</button>
          <button class="layui-btn " data-type="addPlace">新增用户</button>
          <button class="layui-btn " data-type="delPlace">删除用户</button>
        </div>
      </div>
      <div class="layui-card-body">
        <table class="layui-hide" id="Place" lay-filter="Place"></table> 
      </div>
    </div>
  </div> 
</body>
<style type="text/css">
.layui-table-cell {            overflow: visible !important;        } 
/* 使得下拉框与单元格刚好合适 */       
td .layui-form-select{
  margin-top: -10px;
  margin-left: -15px;
  margin-right: -15px;
} 

</style>
<style type="text/css">
  .layui-table-body, .layui-table-box, .layui-table-cell{
  overflow:visible
}
</style>
<script type="text/html" id="barCol">
    <a class="layui-btn layui-btn-xs" lay-event="edit">回款计划</a>
    
    <a class="layui-btn layui-btn-xs" lay-event="upload">合同上传</a>
    
</script>
<script type="text/html" id="show_link">
  {{#  if(d.con_link != null){ }}
    <a class="layui-btn layui-btn-xs" lay-event="show_con">查看</a>
  {{#  } }} 
</script>
<script type="text/html" id="selectLevel" >    
  <select name='level' lay-filter='level' lay-event="level" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.level==''?'selected':''}}>请选择</option>
    <?php if($user['level']=='总公司'): ?>
      <option value="总公司" {{d.level=='总公司'?'selected':''}}>总公司</option>
    <?php endif; ?>
      <option value="分公司" {{d.level=='分公司'?'selected':''}}>分公司</option>

      <option value="业务经理" {{d.level=='业务经理'?'selected':''}}>业务经理</option>
    
  </select>
</script>
<script type="text/html" id="selectCom" >    
  <select name='company' lay-filter='company' lay-event="company" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.company==''?'selected':''}}>请选择</option>
    <?php if(is_array($companys) || $companys instanceof \think\Collection || $companys instanceof \think\Paginator): $i = 0; $__LIST__ = $companys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $company['name']; ?>" {{d.company=='<?php echo $company['name']; ?>'?'selected':''}}><?php echo $company['name']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>    
  </select>
</script>
<script src="/themes/admin_simpleboot3/public/layuiadmin/layui/layui.js"></script>
<script type="text/javascript">
layui.use(['laydate','table','layer','form'], function(){
  var table = layui.table
      ,layer = layui.layer;
  var form   = layui.form;
  var laydate = layui.laydate;
  laydate.render({
    elem: '#deliver_time' //指定元素
    ,range: '~'
  });
  //方法级渲染
  table.render({
    elem: '#Place'
    ,url: '/user/datalist/'
    ,cols: [[
      {checkbox: true, fixed: true},
      {field:'id', title: 'ID', sort: true, fixed: true}
      ,{field:'user_login', title: '用户',   edit: 'text'}
      ,{field:'user_nickname', title: '昵称', edit: 'text'}
      ,{field:'user_pass', title: '密码', edit: 'text'}
      ,{field:'create_time', title: '创建时间',}
      ,{field:'last_login_ip', title: '上次登录IP'}
      ,{field:'last_login_time', title: '上次登录时间'}
      ,{field:'company', title: '所属公司',toolbar: '#selectCom'}
      ,{field:'level', title: '角色',toolbar: '#selectLevel'}
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
            user_login: $('#user_login').val(),
            level: $('#level').val(),
        }
      }, 'data');
    },
    addPlace:function(){
      $.post('/user/addone',{id:''},function(res){
        if(res.code){
          table.reload('PlaceReload');
          layer.msg(res.msg,{icon:1});
        }else{
          layer.msg(res.msg,{icon:2});
        }
      });
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
          $.post('/user/delaction',{params:id.join(',')},function(res){
            if(res.code){
              table.reload('PlaceReload');
              layer.msg(res.msg,{icon:1});
            }else{
              layer.msg(res.msg,{icon:2});
            }
          });
        });

       


    },
  };
  window.fun = active;
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });

  form.on('select(company)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,company:data.value};
    $.post('/user/editaction',{params:update},function(res){
      if(res.code){
        layer.msg(res.msg);
      }else{
        table.reload('PlaceReload');
        layer.msg(res.msg);
      }
      //layer.close(load);
    });
  });
  form.on('select(level)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,level:data.value};
    $.post('/user/editaction',{params:update},function(res){
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
    $.post('/user/editaction',{params:update},function(res){
      if(res.code){
        table.reload('PlaceReload');
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
    };
  });
  
});
</script>
</html>