<?php /*a:1:{s:94:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/advertisement/publish.html";i:1590394402;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>发布广告</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
</head>
<body>

    <div class="container">
        <div class="weui-form">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">发布广告</h2>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">所属地区</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showCityInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showCityPicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active city-collection" id="cityCollection">
                            
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">广告类型</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showTypeInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showTypePicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">目录分类</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showKindInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showKindPicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">主题</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请输入主题"/>
                            </div>
                        </div>
                        <div class="weui-cell  weui-cell_uploader">
                            <div class="weui-cell__bd">
                                <div class="weui-uploader">
                                    <div class="weui-uploader__hd">
                                        <p class="weui-uploader__title">图片</p>
                                    </div>
                                    <div class="weui-uploader__bd">
                                        <ul class="weui-uploader__files uploader-files">
                                            <!-- <li class="weui-uploader__file" style="background-image: url(/themes/admin_simpleboot3/public/massets/images/2.png);">
                                                <i class="weui-uploader__delete iconfont iconclose-circle"></i>
                                            </li> -->
                                        </ul>
                                        <div class="weui-uploader__input-box">
                                            <input class="weui-uploader__input uploader-input" type="file" accept="image/*" multiple/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">文字说明</label></div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <textarea class="weui-textarea" placeholder="文字说明" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">店铺地址</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" id="address" type="text" placeholder="请输入店铺地址"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div id="map" style="width: 100%;height: 4rem;"></div> 
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入联系电话"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">获客数量</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入获客数量"/>
                            </div>
                        </div>

                        <!-- 宣传类 -->
                        <div class="weui-cell weui-cell_active type-advertise" style="display: none;">
                            <div class="weui-cell__hd"><label class="weui-label">广告宣传劵</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showTicketADInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showTicketADPicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active type-advertise" style="display: none;">
                            <div class="weui-cell__hd"><label class="weui-label">一元抢购劵</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" placeholder="满多少元抵多少元"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active type-advertise" style="display: none;">
                            <div class="weui-cell__hd"><label class="weui-label">广告截止日期</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showDateADPicker"/>
                            </div>
                        </div>

                        <!-- 活动类 -->
                        <div class="weui-cell weui-cell_active type-activity" style="display: none;">
                            <div class="weui-cell__hd"><label class="weui-label">活动彩金劵</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showTicketACInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showTicketACPicker"/>
                            </div>
                        </div>

                        <div class="weui-cell weui-cell_active type-activity" style="display: none;">
                            <div class="weui-cell__hd"><label class="weui-label">广告截止日期</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showDateACPicker"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <p class="text-center font-16 color-999">所需金额：<strong class="font-24 color-primary">￥9999</strong></p>
                <a class="weui-btn weui-btn_primary m-t-30" href="javascript:" id="">发布</a>
            </div>
        </div>
    </div>

    <!-- gallery -->
    <div class="weui-gallery" id="gallery">
        <span class="weui-gallery__img" id="galleryImg"></span>
    </div>
    <!-- gallery -->

    <!-- success toast-->
    <div id="toastSuccess" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">操作成功</p>
        </div>
    </div>
    <!-- success toast-->

    <!-- error toast-->
    <div id="toastError" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-warn weui-icon_msg weui-icon_toast"></i>
            <p class="weui-toast__content">请检查您的输入</p>
        </div>
    </div>
    <!-- error toast-->

    <!-- loading toast-->
    <div id="toastLoading" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">正在加载...</p>
        </div>
    </div>
    <!-- loading toast-->

    <!-- 免责声明 dialog -->
    <div class="js_dialog" id="explainDialog">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">泡泡同城免责声明</strong></div>
            <div class="weui-dialog__bd">1、上传的广告图片不可出现低俗、违规内容；2、标题文字中不可出现敏感字体；3、若收到投诉举报，经过核实，确定违规后，将进行封号处理；4、若发布的广告触犯国家法律，将由广告发布者承担所有责任。</div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="hideExplainDialog();">知道了</a>
            </div>
        </div>
    </div>
     <!-- 免责声明 dialog -->

     
    <!-- 余额不足请充值 dialog -->
    <div class="js_dialog" id="rechargeDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd">余额不足请充值</div>
            <div class="weui-dialog__ft">
                <a href="" class="weui-dialog__btn weui-dialog__btn_primary">去充值</a>
            </div>
        </div>
    </div>
     <!-- 余额不足请充值 dialog -->

    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=c33813dceb855ebf5e4a2b088b1fdc65&plugin=AMap.Geocoder"></script> 
    <script type="text/javascript">
        function showToastSuccess(msg){
            if ($("#toastSuccess").css('display') != 'none') return;
            $("#toastSuccess").fadeIn(100);
            $("#toastSuccess .weui-toast__content").html(msg)
            setTimeout(function () {
                $("#toastSuccess").fadeOut(100);
            }, 2000);
        }
        function showToastError(msg){
            if ($("#toastError").css('display') != 'none') return;
            $("#toastError").fadeIn(100);
            $("#toastError .weui-toast__content").html(msg)
            setTimeout(function () {
                $("#toastError").fadeOut(100);
            }, 2000);
        }
        function showToastLoading(msg){
            $("#toastLoading").fadeIn(100);
            $("#toastLoading .weui-toast__content").html(msg)
        }
        function hideToastLoading(){
            $("#toastLoading").fadeOut(100);
        }
        function hideExplainDialog(){
            $("#explainDialog").fadeOut(100);
        }
        
        $(function(){

            // 所属地区
            var areaList = []
            $.ajax({
                url: "/themes/admin_simpleboot3/public/massets/json/city.json",
                type: "GET",
                success: function(res){
                    areaList = res
                }
            });
            $('#showCityPicker').on('click', function () {
                weui.picker(areaList, {
                    defaultValue: [320000,321000,321002],
                    onConfirm: function (result) {
                        $("#showCityInput").val([result[0].value,result[1].value,result[2].value])
                        $('#showCityPicker').val(result[0].label+" "+result[1].label+" "+result[2].label);
                        $("#cityCollection").show()
                        $("#cityCollection").append('<span>'+result[0].label+result[1].label+result[2].label+'<i class="iconfont iconclose"></i></span>')
                    },
                    title: '请选择'
                });
            });

            // 删除地区
            $("#cityCollection").on("click","span i",function(){
                $(this).parent().remove()
                if($("#cityCollection span").length == 0){
                    $("#cityCollection").hide()
                    $("#showCityInput").val("")
                    $("#showCityPicker").val("")
                }
            })

            // 广告类型
            $('#showTypePicker').on('click', function () {
                weui.picker([{
                    value: 1,
                    label: '宣传类'
                },{
                    value: 2,
                    label: '活动类'
                }], {
                    defaultValue: [1],
                    onConfirm: function (result) {
                        $("#showTypeInput").val(result[0].value);
                        $('#showTypePicker').val(result[0].label);
                        if(result[0].label == "宣传类"){
                            $(".type-advertise").show()
                            $(".type-activity").hide()
                        }else if(result[0].label == "活动类"){
                            $(".type-activity").show()
                            $(".type-advertise").hide()
                        }
                    },
                    title: '请选择'
                });
            });

            // 目录分类
            $('#showKindPicker').on('click', function () {
                weui.picker([{
                    value: 1,
                    label: '目录分类1'
                },{
                    value: 2,
                    label: '目录分类2'
                }], {
                    defaultValue: [1],
                    onConfirm: function (result) {
                        $("#showKindInput").val(result[0].value)
                        $('#showKindPicker').val(result[0].label);
                    },
                    title: '请选择'
                });
            });
            // 广告宣传劵
            $('#showTicketADPicker').on('click', function () {
                weui.picker([{
                    value: 1,
                    label: '1元'
                }], {
                    defaultValue: [1],
                    onConfirm: function (result) {
                        $("#showTicketADInput").val(result[0].value)
                        $('#showTicketADPicker').val(result[0].label);
                    },
                    title: '请选择'
                });
            });

            // 活动彩金劵
            $('#showTicketACPicker').on('click', function () {
                weui.picker([{
                    value: 1,
                    label: '58元'
                },{
                    value: 2,
                    label: '108元'
                }], {
                    defaultValue: [1],
                    onConfirm: function (result) {
                        $("#showTicketACInput").val(result[0].value)
                        $('#showTicketACPicker').val(result[0].label);
                    },
                    title: '请选择'
                });
            });

            // 广告截止日期（宣传类）
            $('#showDateADPicker').on('click', function () {
                weui.datePicker({
                    start: new Date(),
                    end: new Date(new Date().getFullYear(),new Date().getMonth()+3,new Date().getDate()),
                    onConfirm: function (result) {
                        $('#showDateADPicker').val(result[0].label+result[1].label+result[2].label)
                    },
                    title: '请选择'
                });
            });
            
            // 广告截止日期（活动类）
            $('#showDateACPicker').on('click', function () {
                weui.datePicker({
                    start: new Date(),
                    end: new Date(new Date().getFullYear(),new Date().getMonth()+2,new Date().getDate()),
                    onConfirm: function (result) {
                        $('#showDateACPicker').val(result[0].label+result[1].label+result[2].label)
                    },
                    title: '请选择'
                });
            });
        
            // 上传图片
            var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"><i class="weui-uploader__delete iconfont iconclose-circle"></i></li>'
            $(".uploader-input").on("change", function(e){
                var _this = this
                var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
                for (var i = 0, len = files.length; i < len; ++i) {
                    var file = files[i];
                    if (url) {
                        src = url.createObjectURL(file);
                    } else {
                        src = e.target.result;
                    }
                    $(_this).parent().prev(".uploader-files").append($(tmpl.replace('#url#', src)));
                }
            });
            $(".uploader-files").on("click", "li", function(){
                $("#galleryImg").attr("style", this.getAttribute("style"));
                $("#gallery").fadeIn(100);
            });
            $(".uploader-files").on("click", ".weui-uploader__delete", function(e){
                $(this).parent().remove()
                e.stopPropagation()
            });
            $("#gallery").on("click", function(){
                $("#gallery").fadeOut(100);
            });

            // 地图定位
            var map = new AMap.Map("map", {
                resizeEnable: true
            });
            var geocoder = new AMap.Geocoder();
            var marker = new AMap.Marker();
            function geoCode() {
                var address  = $('#address').val();
                geocoder.getLocation(address, function(status, result) {
                    if (status === 'complete'&&result.geocodes.length) {
                        var lnglat = result.geocodes[0].location
                        marker.setPosition(lnglat);
                        map.add(marker);
                        map.setFitView(marker);
                    }else{
                        log.error('根据地址查询位置失败');
                    }
                });
            }
            $("#address").on("blur",function(){
                geoCode();
            })
        })
    </script>
</body>
</html>