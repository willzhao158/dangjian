webpackJsonp([20],{LjS5:function(e,t,l){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={data:function(){return{vm:{searchKey:"",searchType:"",currentPage:1,pageSize:10,pageTotal:100},typeList:[{value:"选项1",label:""},{value:"选项2",label:"双皮奶"},{value:"选项3",label:"蚵仔煎"},{value:"选项4",label:"龙须面"},{value:"选项5",label:"北京烤鸭"}],dataList:[{plot:"东里旺旺葡萄园",certifyType:"绿色食品认证",product:"阳光玫瑰（东兰）",certifyNo:"20190927",certifyOrg:"XXX机构",certifyTime:"2019-09-30",certifyValid:"2018-06-14"},{plot:"东里旺旺葡萄园",certifyType:"绿色食品认证",product:"阳光玫瑰（东兰）",certifyNo:"20190927",certifyOrg:"XXX机构",certifyTime:"2019-09-30",certifyValid:"2018-06-14"},{plot:"东里旺旺葡萄园",certifyType:"绿色食品认证",product:"阳光玫瑰（东兰）",certifyNo:"20190927",certifyOrg:"XXX机构",certifyTime:"2019-09-30",certifyValid:"2018-06-14"}],dialogVisible:!1,form:{plot:"东里旺旺葡萄园",certifyType:"",product:"",certifyNo:"",certifyTime:"",certifyOrg:"",certifyValid:""},productList:[],rules:{certifyType:[{required:!0,message:"请选择认证类型",trigger:"change"}],product:[{required:!0,message:"请选择产品",trigger:"change"}]}}},computed:{tableHeight:function(){return document.documentElement.clientHeight-275}},methods:{search:function(){},add:function(){this.dialogVisible=!0},edit:function(e){this.resetForm(),this.dialogVisible=!0,this.form=e},save:function(){var e=this;this.$refs.form.validate(function(t){if(!t)return e.$message.error("请检查您的输入！"),!1;console.log(e.form),e.dialogVisible=!1})},resetForm:function(){this.form={plot:"东里旺旺葡萄园",certifyType:"",product:"",certifyNo:"",certifyTime:"",certifyOrg:"",certifyValid:""}},handleSizeChange:function(e){console.log(e)},handleCurrentChange:function(e){console.log(e)}}},r={render:function(){var e=this,t=e.$createElement,l=e._self._c||t;return l("div",{staticClass:"page-container"},[l("el-aside",{staticClass:"page-nav-left"},[l("div",{staticClass:"aside-bar"},[l("el-menu",{attrs:{"default-active":"0"}},[l("router-link",{attrs:{to:"/trace/batch"}},[l("el-menu-item",{attrs:{index:"0"}},[l("i",{staticClass:"el-icon-position"}),e._v(" "),l("span",{attrs:{slot:"title"},slot:"title"},[e._v("溯源管理")])])],1),e._v(" "),l("router-link",{attrs:{to:"/trace/certify"}},[l("el-menu-item",{attrs:{index:"1"}},[l("i",{staticClass:"el-icon-circle-check"}),e._v(" "),l("span",{attrs:{slot:"title"},slot:"title"},[e._v("认证管理")])])],1),e._v(" "),l("router-link",{attrs:{to:"/trace/detect"}},[l("el-menu-item",{attrs:{index:"2"}},[l("i",{staticClass:"el-icon-set-up"}),e._v(" "),l("span",{attrs:{slot:"title"},slot:"title"},[e._v("检测管理")])])],1),e._v(" "),l("router-link",{attrs:{to:"/trace/process"}},[l("el-menu-item",{attrs:{index:"3"}},[l("i",{staticClass:"el-icon-setting"}),e._v(" "),l("span",{attrs:{slot:"title"},slot:"title"},[e._v("加工管理")])])],1),e._v(" "),l("router-link",{attrs:{to:"/trace/delivery"}},[l("el-menu-item",{attrs:{index:"4"}},[l("i",{staticClass:"el-icon-truck"}),e._v(" "),l("span",{attrs:{slot:"title"},slot:"title"},[e._v("配送管理")])])],1)],1)],1)]),e._v(" "),l("el-main",{staticClass:"m-l-220 m-t-20 bg-white"},[l("div",{staticClass:"flex flex-align-center flex-pack-justify"},[l("div",{staticClass:"flex flex-align-center"},[l("el-select",{staticClass:"m-r-30",attrs:{size:"small",placeholder:"请选择认证类型"},model:{value:e.vm.searchType,callback:function(t){e.$set(e.vm,"searchType",t)},expression:"vm.searchType"}},e._l(e.typeList,function(e){return l("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})}),1),e._v(" "),l("el-input",{staticClass:"m-r-30",staticStyle:{width:"200px"},attrs:{size:"small",placeholder:"搜索认证产品名称","suffix-icon":"el-icon-search"},model:{value:e.vm.searchKey,callback:function(t){e.$set(e.vm,"searchKey",t)},expression:"vm.searchKey"}}),e._v(" "),l("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.search}},[e._v("搜索")])],1),e._v(" "),l("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.add}},[e._v("添加认证记录")])],1),e._v(" "),l("el-row",{staticClass:"m-t-30"},[l("el-col",{attrs:{span:24}})],1),e._v(" "),l("el-row",{staticClass:"m-t-30"},[l("el-col",[l("el-pagination",{staticClass:"text-right",attrs:{background:"",layout:"total, prev, pager, next","current-page":e.vm.currentPage,"page-size":e.vm.pageSize,total:e.vm.pageTotal},on:{"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange,"update:currentPage":function(t){return e.$set(e.vm,"currentPage",t)},"update:current-page":function(t){return e.$set(e.vm,"currentPage",t)}}})],1)],1),e._v(" "),l("el-dialog",{attrs:{title:"加工记录",visible:e.dialogVisible,width:"800px","close-on-click-modal":!1},on:{"update:visible":function(t){e.dialogVisible=t}}},[l("el-form",{ref:"form",attrs:{size:"small",rules:e.rules,model:e.form,"label-width":"150px"}},[l("el-form-item",{attrs:{label:"所属地块",prop:"plot"}},[l("el-input",{staticStyle:{width:"260px"},attrs:{disabled:""},model:{value:e.form.plot,callback:function(t){e.$set(e.form,"plot",t)},expression:"form.plot"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"认证类型",prop:"certifyType"}},[l("el-select",{staticStyle:{width:"260px"},attrs:{filterable:"",placeholder:"请选择认证类型"},model:{value:e.form.certifyType,callback:function(t){e.$set(e.form,"certifyType",t)},expression:"form.certifyType"}},e._l(e.typeList,function(e){return l("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})}),1)],1),e._v(" "),l("el-form-item",{attrs:{label:"认证产品",prop:"product"}},[l("el-select",{staticStyle:{width:"260px"},attrs:{filterable:"",placeholder:"请选择产品"},model:{value:e.form.product,callback:function(t){e.$set(e.form,"product",t)},expression:"form.product"}},e._l(e.productList,function(e){return l("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})}),1)],1),e._v(" "),l("el-form-item",{attrs:{label:"证书编号",prop:"certifyNo"}},[l("el-input",{staticStyle:{width:"260px"},model:{value:e.form.certifyNo,callback:function(t){e.$set(e.form,"certifyNo",t)},expression:"form.certifyNo"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"颁证日期",prop:"certifyTime"}},[l("el-date-picker",{staticStyle:{width:"260px"},attrs:{type:"date",placeholder:"选择日期"},model:{value:e.form.certifyTime,callback:function(t){e.$set(e.form,"certifyTime",t)},expression:"form.certifyTime"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"颁证机构",prop:"certifyOrg"}},[l("el-input",{staticStyle:{width:"260px"},model:{value:e.form.certifyOrg,callback:function(t){e.$set(e.form,"certifyOrg",t)},expression:"form.certifyOrg"}})],1),e._v(" "),l("el-form-item",{attrs:{label:"有效日期",prop:"certifyValid"}},[l("el-date-picker",{staticStyle:{width:"260px"},attrs:{type:"date",placeholder:"选择日期"},model:{value:e.form.certifyValid,callback:function(t){e.$set(e.form,"certifyValid",t)},expression:"form.certifyValid"}})],1)],1),e._v(" "),l("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[l("el-button",{attrs:{size:"small"},on:{click:function(t){e.dialogVisible=!1}}},[e._v("取消")]),e._v(" "),l("el-button",{attrs:{size:"small",type:"primary"},on:{click:e.save}},[e._v("保存")])],1)],1)],1)],1)},staticRenderFns:[]};var a=l("VU/8")(i,r,!1,function(e){l("sTaV")},null,null);t.default=a.exports},sTaV:function(e,t){}});
//# sourceMappingURL=20.c4bdfb0781b5953efb08.js.map