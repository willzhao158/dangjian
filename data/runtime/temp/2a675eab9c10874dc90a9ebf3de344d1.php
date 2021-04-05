<?php /*a:1:{s:91:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/shop/merchant_form.html";i:1590397969;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商家认证</title>
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
                <h2 class="weui-form__title">商家认证</h2>
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
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">商家类型</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showTypeInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showTypePicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">商家分类</label></div>
                            <div class="weui-cell__bd">
                                <input type="hidden" name="" id="showKindInput"/>
                                <input class="weui-input" type="text" placeholder="请选择" readonly id="showKindPicker"/>
                            </div>
                        </div>
                        <div class="weui-cell weui-cell_active">
                            <div class="weui-cell__hd"><label class="weui-label">店铺地址</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="点击添加" readonly id="showShopAddr"/>
                            </div>
                        </div>
                        <input type="hidden" id="shopAddress" value="">
                        <div class="shop-addr-list">
                            <div class="weui-cell weui-cell_active">
                                <div class="weui-cell__bd">
                                    <div class="flex flex-align-center flex-pack-justify shop-addr-item">
                                        <div class="flex-1">
                                            <div class="flex flex-align-center">
                                                <h1>店铺名称</h1>
                                                <p>15241521245</p>
                                            </div>
                                            <h6>店铺地址店铺地址</h6>
                                            <input type="hidden" value="">
                                        </div>
                                        <a href="javascript:;" class="weui-btn weui-btn_warn btn-delete-addr">删除</a>
                                     </div>
                                </div>
                            </div>
                            <div class="weui-cell weui-cell_active">
                                <div class="weui-cell__bd">
                                    <div class="flex flex-align-center flex-pack-justify shop-addr-item">
                                        <div class="flex-1">
                                            <div class="flex flex-align-center">
                                                <h1>店铺名称</h1>
                                                <p>15241521245</p>
                                            </div>
                                            <h6>店铺地址店铺地址</h6>
                                            <input type="hidden" value="">
                                        </div>
                                        <a href="javascript:;" class="weui-btn weui-btn_warn btn-delete-addr">删除</a>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell  weui-cell_uploader">
                            <div class="weui-cell__bd">
                                <div class="weui-uploader">
                                    <div class="weui-uploader__hd">
                                        <p class="weui-uploader__title">店铺照片</p>
                                        <div class="weui-uploader__info">门头1张、店内实景4张(请横拍)</div>
                                    </div>
                                    <div class="weui-uploader__bd">
                                        <ul class="weui-uploader__files uploader-files">
                                        </ul>
                                        <div class="weui-uploader__input-box">
                                            <input class="img-input" name="imgs1" type="hidden" id="imgs1">
                                            <input class="weui-uploader__input uploader-input" type="file" accept="image/*" multiple/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell  weui-cell_uploader">
                            <div class="weui-cell__bd">
                                <div class="weui-uploader">
                                    <div class="weui-uploader__hd">
                                        <p class="weui-uploader__title">营业执照</p>
                                        <div class="weui-uploader__info">仅限泡泡同城商家认证使用</div>
                                    </div>
                                    <div class="weui-uploader__bd">
                                        <ul class="weui-uploader__files uploader-files">
                                        </ul>
                                        <div class="weui-uploader__input-box">
                                            <input class="img-input" name="imgs2" type="hidden" id="imgs2">
                                            <input class="weui-uploader__input uploader-input" type="file" accept="image/*" multiple/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell  weui-cell_uploader">
                            <div class="weui-cell__bd">
                                <div class="weui-uploader">
                                    <div class="weui-uploader__hd">
                                        <p class="weui-uploader__title">法人身份证</p>
                                        <div class="weui-uploader__info">仅限泡泡同城商家认证使用</div>
                                    </div>
                                    <div class="weui-uploader__bd">
                                        <ul class="weui-uploader__files uploader-files">
                                        </ul>
                                        <div class="weui-uploader__input-box">
                                            <input class="img-input" name="imgs3" type="hidden" id="imgs3">
                                            <input class="weui-uploader__input uploader-input" type="file" accept="image/*" multiple/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="submit_data">提交</a>
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
    <!-- 店铺地址 dialog -->
    <div class="js_dialog" id="shopAddrDialog" style="display: none;">
        <div class="weui-mask"></div>
        <div id="shopAddrDialogWin" class="weui-half-screen-dialog">
            <div class="weui-half-screen-dialog__hd">
                <div class="weui-half-screen-dialog__hd__side">
                    <button class="weui-icon-btn" onclick="hideShopAddrDialog();">关闭<i class="weui-icon-close-thin"></i></button>
                </div>
                <div class="weui-half-screen-dialog__hd__main">
                    <strong class="weui-half-screen-dialog__title">添加店铺地址</strong>
                </div>
            </div>
            <div class="weui-half-screen-dialog__bd">
                <div class="weui-form" style="padding: 0">
                    <div class="weui-form__control-area">
                        <div class="weui-cells__group weui-cells__group_form">
                            <div class="weui-cells weui-cells_form">
                                <div class="weui-cell weui-cell_active">
                                    <div class="weui-cell__hd"><label class="weui-label">店铺名称</label></div>
                                    <div class="weui-cell__bd">
                                        <input class="weui-input" type="text" placeholder="请输入店铺名称" id="shopName"/>
                                    </div>
                                </div>
                                <div class="weui-cell weui-cell_active">
                                    <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
                                    <div class="weui-cell__bd">
                                        <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入联系电话" id="shopTel"/>
                                    </div>
                                </div>
                                <div class="weui-cell weui-cell_active">
                                    <div class="weui-cell__hd"><label class="weui-label">店铺地址</label></div>
                                    <div class="weui-cell__bd">
                                        <input class="weui-input" type="text" placeholder="请输入店铺地址" id="shopAddr"/>
                                    </div>
                                </div>
                                <div class="weui-cell weui-cell_active">
                                    <div class="weui-cell__hd"><label class="weui-label">地图标注</label></div>
                                </div>
                                <div class="weui-cell weui-cell_active">
                                    <div class="weui-cell__bd">
                                        <input type="hidden" id="shopLnglat">
                                        <div id="map" style="width: 100%;height: 4rem;"></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="weui-form__opr-area">
                        <a class="weui-btn weui-btn_primary" href="javascript:" id="saveShopInfo">保存</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 店铺地址 dialog -->
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
        function hideShopAddrDialog(){
            $("#shopAddrDialog").fadeOut(200);
            $("#shopAddrDialogWin").removeClass('weui-half-screen-dialog_show');
        }
        $(function(){
            // 所属地区
            var areaList = <?php echo $city; ?>;
            // $.ajax({
            //     url: "<?php echo url('city/index'); ?>",
            //     type: "get",
            //     dataType:'json',
            //     success: function(res){
            //         areaList = res
            //     }
            // });
            $('#showCityPicker').on('click', function () {
                weui.picker(areaList, {
                    defaultValue: [320000,321000,321002],
                    onConfirm: function (result) {
                        $("#showCityInput").val([result[0].value,result[1].value,result[2].value])
                        $('#showCityPicker').val(result[0].label+" "+result[1].label+" "+result[2].label);
                    },
                    title: '请选择'
                });
            });
            // 商家类型
            $('#showTypePicker').on('click', function () {
                weui.picker([{
                    value: 1,
                    label: '个商'
                },{
                    value: 2,
                    label: '企业'
                }], {
                    defaultValue: [1],
                    onConfirm: function (result) {
                        $("#showTypeInput").val(result[0].value)
                        $('#showTypePicker').val(result[0].label);
                    },
                    title: '请选择'
                });
            });
            // 商家分类
            $('#showKindPicker').on('click', function () {
                weui.picker(<?php echo $all_classify; ?>, {
                    defaultValue: [100,101],
                    onConfirm: function (result) {
                        $("#showKindInput").val([result[0].value,result[1].value])
                        $('#showKindPicker').val(result[0].label+" "+result[1].label);
                    },
                    title: '请选择'
                });
            });
            // 重置弹框表单
            function resetDialogForm(){
                $("#shopName").val('')
                $("#shopTel").val('')
                $("#shopAddr").val('')
                $("#shopLnglat").val('')
            }
            // 店铺地址
            $('#showShopAddr').on('click', function(){
                $("#shopAddrDialog").fadeIn(200);
                $("#shopAddrDialogWin").addClass('weui-half-screen-dialog_show');
                resetDialogForm()
            });
            $("#saveShopInfo").on("click",function(){
                var value = []
                var html = '<div class="weui-cell weui-cell_active">'
                                +'<div class="weui-cell__bd">'
                                    +'<div class="flex flex-align-center flex-pack-justify shop-addr-item">'
                                        +'<div class="flex-1">'
                                            +'<div class="flex flex-align-center">'
                                                +'<h1>'+$("#shopName").val()+'</h1>'
                                                +'<p>'+$("#shopTel").val()+'</p>'
                                                +'</div>'
                                                +'<h6>'+$("#shopAddr").val()+'</h6>'
                                                +'<input type="hidden" value="'+$("#shopLnglat").val()+'">'
                                            +'</div>'
                                        +'<a href="javascript:;" class="weui-btn weui-btn_warn btn-delete-addr">删除</a>'
                                     +'</div>'
                                +'</div>'
                            +'</div>';
                $(".shop-addr-list").append(html);
                value.push($("#shopName").val()+"&"+$("#shopTel").val()+"&"+$("#shopAddr").val()+"&"+$("#shopLnglat").val())
                $("#shopAddress").val(value)
                hideShopAddrDialog();
            })
            $(document).on("click",".btn-delete-addr",function(){
                $(this).parents(".weui-cell").remove()
            })

            // 地图定位
            var center;
            var map = new AMap.Map("map", {
                resizeEnable: true,
                center: [116.418481,39.90833],
                zoom: 15
            });
            var geocoder = new AMap.Geocoder();
            function geoCode() {
                var address = $('#shopAddr').val();
                geocoder.getLocation(address, function(status, result) {
                    if (status === 'complete'&&result.geocodes.length) {
                        var lnglat = result.geocodes[0].location
                        map.setCenter(lnglat);
                    }else{
                        log.error('根据地址查询位置失败');
                    }
                });
            }
            $("#shopAddr").on("blur",function(){
                geoCode();
            })
            map.on('click',function(e){
                center = e.lnglat
                $("#shopLnglat").val(center)
                map.clearMap();
                var marker = new AMap.Marker({
                    position: center,
                });
                marker.setMap(map);
            })

            // 图片删除
            $(".weui-uploader__files").on("click", ".weui-uploader__delete", function(e){
                var imgs = $(this).parents(".weui-uploader__bd").find(".img-input").val().split(",")
                var index = $(this).parent().index()
                imgs.splice(index,1)
                $(this).parents(".weui-uploader__bd").find(".img-input").val(imgs.join(","))
                $(this).parent().remove()
                e.stopPropagation()
            });
            // 上传图片
            var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"><img class="weui-uploader__delete" src="/themes/admin_simpleboot3/public/massets/images/icon_delete.png"></li>'
            $(".uploader-input").on("change", function(e){
                var _this = this
                var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
                var formData = new FormData();
                for (var i = 0, len = files.length; i < len; ++i) {
                    var file = files[i];
                    formData.append('photo'+i, file);
                    if (url) {
                        src = url.createObjectURL(file);
                    } else {
                        src = e.target.result;
                    }
                    $(_this).parent().prev(".uploader-files").append($(tmpl.replace('#url#', src)));
                }
                $.ajax({
                    url: "<?php echo url('shop/pics'); ?>",
                    type: 'post',
                    dataType: 'json',
                    async: false,
                    contentType:false,
                    processData:false,
                    data:formData,
                    beforeSend: function(){
                        //showLoading();
                    },
                    success: function (data) {
                        var imgs = $(_this).prev().val();
                        if(imgs == ''){
                            $(_this).prev().val(data);
                        }else{
                            imgs = imgs+','+data;
                            $(_this).prev().val(imgs);
                        }
                        //hideLoading();
                    },
                    error: function () {
                    },
                });
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
            $("#submit_data").click(function(){
                var address = $("#address").val();
                var furniture = $("#imgs1").val();
                var floor = $("input[name='floor']:checked").val();
                var before = $("#imgs2").val();
                var after = $("#imgs3").val();
                var window_open = $("input[name='window']:checked").val();
                var window_imgs = $("#imgs4").val();
                if(address == ''){
                    showToastError('请输入地点');
                    return false;
                }
                if(furniture == ''){
                    showToastError('请上传家具设备消毒图片');
                    return false;
                }
                if(before == ''){
                    showToastError('请上传清扫前图片');
                    return false;
                }
                if(after == ''){
                    showToastError('请上传清扫后图片');
                    return false;
                }
                if(window_imgs == ''){
                    showToastError('请上传开窗通风情况图片');
                    return false;
                }
                $.ajax({
                    url: "/?m=repair&d=we&a=savehygiene",
                    type: 'post',
                    dataType: 'json',
                    data:{
                        address:address,
                        furniture:furniture,
                        floor:floor,
                        before:before,
                        after:after,
                        window_open:window_open,
                        window_imgs:window_imgs,
                    },
                    success: function (data) {
                        showToastSuccess('提交成功');
                        setTimeout(function(){ window.history.go(-1); }, 1500);
                    },
                    error: function () {
                    },
                });
            });
        })
    </script>
</body>
</html>