webpackJsonp([8],{cZm0:function(e,t){},kj58:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={data:function(){return{vm:{searchKey:"",searchDate:"",currentPage:1,pageSize:10,pageTotal:100},pickerOptions:{shortcuts:[{text:"最近一周",onClick:function(e){var t=new Date,s=new Date;s.setTime(s.getTime()-6048e5),e.$emit("pick",[s,t])}},{text:"最近一个月",onClick:function(e){var t=new Date,s=new Date;s.setTime(s.getTime()-2592e6),e.$emit("pick",[s,t])}},{text:"最近三个月",onClick:function(e){var t=new Date,s=new Date;s.setTime(s.getTime()-7776e6),e.$emit("pick",[s,t])}}]},url:"https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",srcList:["https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg","https://fuss10.elemecdn.com/1/8e/aeffeb4de74e2fde4bd74fc7b4486jpeg.jpeg"],url1:"https://fuss10.elemecdn.com/a/3f/3302e58f9a181d2509f3dc0fa68b0jpeg.jpeg",srcList1:["https://fuss10.elemecdn.com/a/3f/3302e58f9a181d2509f3dc0fa68b0jpeg.jpeg","https://fuss10.elemecdn.com/1/34/19aa98b1fcb2781c4fba33d850549jpeg.jpeg","https://fuss10.elemecdn.com/0/6f/e35ff375812e6b0020b6b4e8f9583jpeg.jpeg","https://fuss10.elemecdn.com/9/bb/e27858e973f5d7d3904835f46abbdjpeg.jpeg","https://fuss10.elemecdn.com/d/e6/c4d93a3805b3ce3f323f7974e6f78jpeg.jpeg","https://fuss10.elemecdn.com/3/28/bbf893f792f03a54408b3b7a7ebf0jpeg.jpeg","https://fuss10.elemecdn.com/2/11/6535bcfb26e4c79b48ddde44f4b6fjpeg.jpeg"],dialogVisible:!1,form:{plot:"东里旺旺葡萄园",tourTime:"",tourPics:[]},rules:{tourTime:[{required:!0,message:"请选择日期",trigger:"change"}],tourPics:[{type:"array",required:!0,message:"请上传图片",trigger:"change"}]}}},computed:{tableHeight:function(){return document.documentElement.clientHeight-275}},methods:{search:function(){},add:function(){this.dialogVisible=!0},edit:function(e){this.resetForm(),this.dialogVisible=!0,this.form=e},save:function(){var e=this;this.$refs.form.validate(function(t){if(!t)return e.$message.error("请检查您的输入！"),!1;console.log(e.form),e.dialogVisible=!1})},resetForm:function(){this.form={plot:"东里旺旺葡萄园",tourTime:"",tourPics:[]}},handleSizeChange:function(e){console.log(e)},handleCurrentChange:function(e){console.log(e)}}},a={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"page-container"},[s("el-aside",{staticClass:"page-nav-left"},[s("div",{staticClass:"aside-bar"},[s("el-menu",{attrs:{"default-active":"2"}},[s("router-link",{attrs:{to:"/farming/task"}},[s("el-menu-item",{attrs:{index:"0"}},[s("i",{staticClass:"el-icon-date"}),e._v(" "),s("span",{attrs:{slot:"title"},slot:"title"},[e._v("任务管理")])])],1),e._v(" "),s("router-link",{attrs:{to:"/farming/seed"}},[s("el-menu-item",{attrs:{index:"1"}},[s("i",{staticClass:"el-icon-coin"}),e._v(" "),s("span",{attrs:{slot:"title"},slot:"title"},[e._v("种子管理")])])],1),e._v(" "),s("router-link",{attrs:{to:"/farming/tour"}},[s("el-menu-item",{attrs:{index:"2"}},[s("i",{staticClass:"el-icon-truck"}),e._v(" "),s("span",{attrs:{slot:"title"},slot:"title"},[e._v("巡园管理")])])],1),e._v(" "),s("router-link",{attrs:{to:"/farming/work"}},[s("el-menu-item",{attrs:{index:"3"}},[s("i",{staticClass:"el-icon-notebook-1"}),e._v(" "),s("span",{attrs:{slot:"title"},slot:"title"},[e._v("工作汇报")])])],1)],1)],1)]),e._v(" "),s("el-main",{staticClass:"m-l-220 m-t-20 bg-white"},[s("div",{staticClass:"flex flex-align-center flex-pack-justify"},[s("div",{staticClass:"flex flex-align-center"},[s("el-input",{staticClass:"m-r-15",staticStyle:{width:"200px"},attrs:{size:"small",placeholder:"请输入巡园记录","suffix-icon":"el-icon-search"},model:{value:e.vm.searchKey,callback:function(t){e.$set(e.vm,"searchKey",t)},expression:"vm.searchKey"}}),e._v(" "),s("el-date-picker",{staticClass:"m-r-15",attrs:{size:"small",type:"datetimerange","picker-options":e.pickerOptions,"range-separator":"至","start-placeholder":"开始日期","end-placeholder":"结束日期",align:"right"},model:{value:e.vm.searchDate,callback:function(t){e.$set(e.vm,"searchDate",t)},expression:"vm.searchDate"}}),e._v(" "),s("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.search}},[e._v("搜索")])],1),e._v(" "),s("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.add}},[e._v("添加巡园记录")])],1),e._v(" "),s("div",{staticClass:"tour-list m-t-30 clearfix"},[s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url,"preview-src-list":e.srcList}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url1,"preview-src-list":e.srcList1}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url,"preview-src-list":e.srcList}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url1,"preview-src-list":e.srcList1}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url,"preview-src-list":e.srcList}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url1,"preview-src-list":e.srcList1}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url,"preview-src-list":e.srcList}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1),e._v(" "),s("div",{staticClass:"tour-item"},[s("el-image",{attrs:{src:e.url1,"preview-src-list":e.srcList1}}),e._v(" "),s("p",[e._v("2019-09-28 12:20:56")])],1)]),e._v(" "),s("el-row",{staticClass:"m-t-30"},[s("el-col",[s("el-pagination",{staticClass:"text-right",attrs:{background:"",layout:"total, prev, pager, next","current-page":e.vm.currentPage,"page-size":e.vm.pageSize,total:e.vm.pageTotal},on:{"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange,"update:currentPage":function(t){return e.$set(e.vm,"currentPage",t)},"update:current-page":function(t){return e.$set(e.vm,"currentPage",t)}}})],1)],1),e._v(" "),s("el-dialog",{attrs:{title:"巡园记录",visible:e.dialogVisible,width:"800px","close-on-click-modal":!1},on:{"update:visible":function(t){e.dialogVisible=t}}},[s("el-form",{ref:"form",attrs:{size:"small",rules:e.rules,model:e.form,"label-width":"150px"}},[s("el-form-item",{attrs:{label:"所属地块",prop:"plot"}},[s("el-input",{staticStyle:{width:"260px"},attrs:{disabled:""},model:{value:e.form.plot,callback:function(t){e.$set(e.form,"plot",t)},expression:"form.plot"}})],1),e._v(" "),s("el-form-item",{attrs:{label:"巡园时间",prop:"tourTime"}},[s("el-date-picker",{staticStyle:{width:"260px"},attrs:{type:"datetime",placeholder:"选择日期"},model:{value:e.form.tourTime,callback:function(t){e.$set(e.form,"tourTime",t)},expression:"form.tourTime"}})],1),e._v(" "),s("el-form-item",{attrs:{label:"巡园图片",prop:"tourPics"}},[s("el-upload",{attrs:{multiple:"",action:"https://jsonplaceholder.typicode.com/posts/",limit:10,"file-list":e.form.tourPics}},[s("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")]),e._v(" "),s("div",{attrs:{slot:"tip"},slot:"tip"},[e._v("只能上传jpg/png文件，且不超过500kb")])],1)],1)],1),e._v(" "),s("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[s("el-button",{attrs:{size:"small"},on:{click:function(t){e.dialogVisible=!1}}},[e._v("取消")]),e._v(" "),s("el-button",{attrs:{size:"small",type:"primary"},on:{click:e.save}},[e._v("保存")])],1)],1)],1)],1)},staticRenderFns:[]};var r=s("VU/8")(i,a,!1,function(e){s("cZm0")},null,null);t.default=r.exports}});
//# sourceMappingURL=8.747c1bb762bdc799ee91.js.map