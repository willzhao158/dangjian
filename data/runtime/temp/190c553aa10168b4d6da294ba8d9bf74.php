<?php /*a:2:{s:82:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/order/index/main.html";i:1577870175;s:77:"/www/wwwroot/guocai.yzata.cn/public/themes/admin_simpleboot3/public/farm.html";i:1577019110;}*/ ?>
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
  <form class="layui-form" action="" onsubmit="return false;">
    <div class="layui-fluid">
      <div class="layui-card">
        <div class="layui-card-body">
          <div class="demoTable">
            <div class="layui-inline">
              <input class="layui-input" name="" id="contra_num" autocomplete="off" placeholder="请输入合同编号">
            </div>
            <div class="layui-inline">
              <select name="" id="pro_name" lay-verify="required" lay-search="">
                <option value="">请选择产品名称</option>
                <?php if(is_array($products) || $products instanceof \think\Collection || $products instanceof \think\Paginator): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
            <div class="layui-inline">
              <input class="layui-input" name="" id="investor" autocomplete="off" placeholder="请输入投资人">
            </div>
            <div class="layui-inline">
              <select name="" id="company" lay-filter='company' lay-event="company" lay-verify="required" lay-search="">
                <option value="">请选择公司</option>
                <?php if(is_array($companys) || $companys instanceof \think\Collection || $companys instanceof \think\Paginator): $i = 0; $__LIST__ = $companys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$company): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $company['name']; ?>"><?php echo $company['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
            <div class="layui-inline">
              <select name="" id="adviser" lay-verify="required" lay-search="">
                <!-- <option value="">请选择投资顾问</option>
                <?php if(is_array($advisers) || $advisers instanceof \think\Collection || $advisers instanceof \think\Paginator): $i = 0; $__LIST__ = $advisers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$adviser): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $adviser['name']; ?>"><?php echo $adviser['name']; ?>  <?php echo $adviser['company']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?> -->
              </select>
            </div>
            <div class="layui-inline">
              <input type="text" class="layui-input" id="sign_date" placeholder="请选择签订日期">
            </div>
            <br><br>
            <div class="layui-inline">
              <select name="" id="exam_status"  lay-verify="required" lay-search="">
                <option value="">请选择审核状态</option>
                <option value="未审核">未审核</option>
                <option value="终审成功">终审成功</option>
              </select>
            </div>
            
            
            <br><br>
            <button class="layui-btn" data-type="reload">搜索</button>
            <?php if($user['level']!=='业务经理'): ?>
            <button class="layui-btn " data-type="addPlace">新增订单</button>
            <button class="layui-btn " data-type="delPlace">删除订单</button>
            <?php endif; ?>
          </div>
        </div>
        <div class="layui-card-body">
          <table class="layui-hide" id="Place" lay-filter="Place"></table> 
        </div>
      </div>
    </div> 
  </form>
</body>
<style type="text/css">
.layui-table-cell {            overflow: visible !important;        } 
/* 使得下拉框与单元格刚好合适 */       
td .layui-form-select{
  margin-top: -10px;
  margin-left: -15px;
  margin-right: -15px;
} 
.layui-table-main{height: 505px;}
.laytable-cell-1-0-12{overflow: hidden !important;}
.laytable-cell-1-0-13{overflow: hidden !important;}
.laytable-cell-1-0-21{overflow: hidden !important;} 
.laytable-cell-1-0-22{overflow: hidden !important;} 
</style>


<!-- <script type="text/html" id="barCol">
    <a class="layui-btn layui-btn-xs" lay-event="edit">回款计划</a>
    
    <a class="layui-btn layui-btn-xs" lay-event="upload">合同上传</a>
    
</script>
<script type="text/html" id="show_link">
  {{#  if(d.con_link != null){ }}
    <a class="layui-btn layui-btn-xs" lay-event="show_con">查看</a>
  {{#  } }} 
</script> -->
<script type="text/html" id="selproduct" >    
  <select name='product' lay-filter='product' lay-event="select_product" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.pro_name==''?'selected':''}}>请选择</option>
    <?php if(is_array($products) || $products instanceof \think\Collection || $products instanceof \think\Paginator): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $product['name']; ?>" {{d.pro_name=='<?php echo $product['name']; ?>'?'selected':''}}><?php echo $product['name']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </select>
</script>
<script type="text/html" id="seladviser" >    
  <select name='adviser' lay-filter='adviser' lay-event="adviser" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.adviser==''?'selected':''}}>请选择</option>
    <?php if(is_array($advisers) || $advisers instanceof \think\Collection || $advisers instanceof \think\Paginator): $i = 0; $__LIST__ = $advisers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$adviser): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $adviser['name']; ?>_<?php echo $adviser['id']; ?>_<?php echo $adviser['company']; ?>" {{d.adviser=='<?php echo $adviser['name']; ?>'?'selected':''}}><?php echo $adviser['name']; ?> <?php echo $adviser['company']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </select>
</script>
<script type="text/html" id="selinterest_way">    
  <select name='interest_way' lay-filter='interest_way' lay-event="interest_way" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.interest_way==''?'selected':''}}>请选择</option>
    <?php if(is_array($interest_ways) || $interest_ways instanceof \think\Collection || $interest_ways instanceof \think\Paginator): $i = 0; $__LIST__ = $interest_ways;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$interest_way): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $interest_way['name']; ?>" {{d.interest_way=='<?php echo $interest_way['name']; ?>'?'selected':''}}><?php echo $interest_way['name']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </select>
</script>
<script type="text/html" id="selinv_term" >    
  <select name='inv_term' lay-filter='inv_term' lay-event="inv_term" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.inv_term==''?'selected':''}}>请选择</option>
    <?php if(is_array($inv_terms) || $inv_terms instanceof \think\Collection || $inv_terms instanceof \think\Paginator): $i = 0; $__LIST__ = $inv_terms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$inv_term): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $inv_term['name']; ?>" {{d.inv_term=='<?php echo $inv_term['name']; ?>'?'selected':''}}><?php echo $inv_term['name']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </select>
</script>
<script type="text/html" id="selid_type" >    
  <select name='id_type' lay-filter='id_type' lay-event="id_type" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.id_type==''?'selected':''}}>请选择</option>
    <?php if(is_array($id_types) || $id_types instanceof \think\Collection || $id_types instanceof \think\Paginator): $i = 0; $__LIST__ = $id_types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$id_type): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $id_type['name']; ?>" {{d.id_type=='<?php echo $id_type['name']; ?>'?'selected':''}}><?php echo $id_type['name']; ?></option>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </select>
</script>
<script type="text/html" id="selpay_way" >    
  <select name='pay_way' lay-filter='pay_way' lay-event="pay_way" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.pay_way==''?'selected':''}}>请选择</option>
      <option value="银行转账" {{d.pay_way=='银行转账'?'selected':''}}>银行转账</option>
      <option value="POS机" {{d.pay_way=='POS机'?'selected':''}}>POS机</option>
  </select>
</script>
<script type="text/html" id="selexam_status" >    
  <select name='exam_status' lay-filter='exam_status' lay-event="exam_status" lay-search='' data-id="{{ d.id }}">
    <option value="" {{d.exam_status==''?'selected':''}}>请选择</option>
      <option value="未审核" {{d.exam_status=='未审核'?'selected':''}}>未审核</option>
      <option value="终审成功" {{d.exam_status=='终审成功'?'selected':''}}>终审成功</option>
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
    elem: '#sign_date' //指定元素
    ,range: '~'
  });
  //方法级渲染
  table.render({
    elem: '#Place'
    ,url: '/index/datalist/'
    ,cols: [[
      {checkbox: true, fixed: true},
      {field:'id', title: 'ID', width:80, sort: true, fixed: true}
      ,{field:'contra_num', title: '合同编号',width:140, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'pro_name', title: '产品名称',width:140,toolbar: '#selproduct'}
      ,{field:'investor', title: '投资人',width:140, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'inv_price', title: '投资金额',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'annu_return', title: '年华收益',width:80, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'sign_date', title: '签订日期',width:100, edit: 'text',event: 'date', data_field: "dBeginDate"}
      ,{field:'inv_term', title: '投资期限',width:100,edit: 'text',toolbar: '#selinv_term'}
      ,{field:'adviser', title: '投资顾问',width:100,toolbar: '#seladviser',edit: 'text'}
      ,{field:'interest_way', title: '付息方式',width:100,toolbar: '#selinterest_way',edit: 'text'}
      ,{field:'id_type', title: '证件类型',width:100,toolbar: '#selid_type',edit: 'text'}
      ,{field:'id_num', title: '证件号码',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'mobile', title: '手机号码',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'inbank', title: '汇入银',width:200, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'bank_no', title: '银行账号',width:200, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'bank', title: '开户银行',width:200, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'pay_way', title: '支付方式',width:140,edit: 'text',toolbar: '#selpay_way'}
      ,{field:'pay_no', title: '参考号',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'pay_money', title: '金额',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'exam_status', title: '审核状态',width:100, <?php if($user['level']!=='业务经理'): ?> edit: 'text',<?php endif; ?>toolbar: '#selexam_status'}
      ,{field:'address', title: '通讯地址',width:200,<?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      ,{field:'remark', title: '备注信息',width:250,<?php if($user['level']!=='业务经理'): ?> edit: 'text'<?php endif; ?>}
      // ,{fixed: 'right', title:'操作', toolbar: '#barCol', width:150}
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
            company: $('#company').val(),
            pro_name: $('#pro_name').val(),
            contra_num: $('#contra_num').val(),
            investor: $('#investor').val(),
            adviser: $('#adviser').val(),
            exam_status: $('#exam_status').val(),
            sign_date: $('#sign_date').val(),
        }
      }, 'data');
    },
    addPlace:function(){
      $.post('/index/addone',{id:''},function(res){
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
          $.post('/index/delaction',{params:id.join(',')},function(res){
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

  form.on('select(product)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,pro_name:data.value};
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

  form.on('select(adviser)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,adviser:data.value};
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

  form.on('select(inv_term)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,inv_term:data.value};
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

  form.on('select(company)', function(data){
    var company = data.value;
    $.post('/index/getadvbycom',{company:company},function(res){
      if(res){
        var str = '<option value="">请选择投资顾问</option>';
        for(i in res){
            str += "<option value='"+res[i]['name']+"'>"+res[i]['name']+"</option>";
        }
        $("#adviser").html(str);
        form.render();
      }else{
        
      }
      //layer.close(load);
    });
  });

  <?php if($user['level']=='总公司'): ?>
  form.on('select(exam_status)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,exam_status:data.value};
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
  <?php endif; if($user['level']!=='业务经理'): ?>
  form.on('select(interest_way)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,interest_way:data.value};
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

  form.on('select(id_type)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,id_type:data.value};
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

  form.on('select(pay_way)', function(data){
    //alert(data.value);
    let id = $(data.elem).data('id');
    // console.log(obj);
    // console.log(id+'->'+obj.value);
    var update = {id:id,pay_way:data.value};
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
  <?php endif; ?>
  //监听单元格编辑
  table.on('edit(Place)', function(obj){
    var value = obj.value //得到修改后的值
    ,data = obj.data //得到所在行所有键值
    ,field = obj.field; //得到字段
    var update = {id:data.id,[field]:value};
    var load = layer.load(0,{shade:0.5});
    $.post('/index/editaction',{params:update},function(res){
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
          , done: function (value, date) {

            var update = {id:data.id,[field]:value};
            var load = layer.load(0,{shade:0.5});
            $.post('/index/editaction',{params:update},function(res){
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