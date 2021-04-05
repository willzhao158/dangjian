<?php /*a:2:{s:84:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/mobile/index/index.html";i:1590141556;s:79:"/www/wwwroot/paopao.yzata.cn/public/themes/admin_simpleboot3/public/footer.html";i:1590141498;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/font/font-ant/iconfont.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/weui/weui.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/lib/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/base.css">
    <link rel="stylesheet" href="/themes/admin_simpleboot3/public/massets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- ============= 定位+搜索 start ============== -->
        <div class="index-top flex flex-align-center flex-pack-justify">
            <a href="" class="position-area"><i class="iconfont iconaim"></i><span id="lname">定位中</span></a>
            <div class="weui-search-bar flex-1" id="searchBar">
                <form class="weui-search-bar__form">
                    <div class="weui-search-bar__box">
                        <i class="weui-icon-search"></i>
                        <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="请输入搜索内容" required/>
                    </div>
                </form>
            </div>
        </div>
        <!-- ============= 定位+搜索 end ============== -->

        <!-- ============= 轮播图广告位 start ============== -->
        <div class="index-banner swiper-container">
            <div class="swiper-wrapper">
                <?php if(is_array($banners) || $banners instanceof \think\Collection || $banners instanceof \think\Paginator): $i = 0; $__LIST__ = $banners;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?>
                    <div class="swiper-slide">
                        <a href="<?php if(empty($banner['link']) != true): ?><?php echo $banner['link']; else: ?>javascript:void(0);<?php endif; ?>"><img src="../<?php echo $banner['img']; ?>" alt=""></a>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                
                <!-- <div class="swiper-slide">
                    <a href=""><img src="/themes/admin_simpleboot3/public/massets/images/1.jpg" alt=""></a>
                </div>
                <div class="swiper-slide">
                    <a href=""><img src="/themes/admin_simpleboot3/public/massets/images/1.jpg" alt=""></a>
                </div>
                <div class="swiper-slide">
                    <a href=""><img src="/themes/admin_simpleboot3/public/massets/images/1.jpg" alt=""></a>
                </div>
                <div class="swiper-slide">
                    <a href=""><img src="/themes/admin_simpleboot3/public/massets/images/1.jpg" alt=""></a>
                </div>
                <div class="swiper-slide">
                    <a href=""><img src="/themes/admin_simpleboot3/public/massets/images/1.jpg" alt=""></a>
                </div> -->
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <!-- ============= 轮播图广告位 end ============== -->

        <!-- ============= 首页菜单 start ============== -->
        <div class="index-menu clearfix">
            <?php if(is_array($all_classify) || $all_classify instanceof \think\Collection || $all_classify instanceof \think\Paginator): $i = 0; $__LIST__ = $all_classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$classify): $mod = ($i % 2 );++$i;?>
                <a href="" class="menu-item">
                    <img src="../<?php echo $classify['img']; ?>" alt="">
                    <p><?php echo $classify['name']; ?></p>
                </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <!-- ============= 首页菜单 end ============== -->

        <!-- ============= 公告 start ============== -->
        <div class="index-notice flex flex-align-center flex-pack-justify">
            <h1>公告</h1>
            <div class="swiper-container flex-1">
                <div class="swiper-wrapper">
                    <?php if(is_array($anounces) || $anounces instanceof \think\Collection || $anounces instanceof \think\Paginator): $i = 0; $__LIST__ = $anounces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$anounce): $mod = ($i % 2 );++$i;?>
                        <div class="swiper-slide text-es1"><?php echo $anounce['content']; ?></div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>    
                </div>
            </div>
        </div>
        <!-- ============= 公告 end ============== -->

        <!-- ============= 列表 start ============== -->
        <div class="list-good">
            <a href="good_detail.html" class="good-item">
                <div class="good-img">
                    <p class="good-time">00时00分00秒</p>
                </div>
                <div class="good-info">产品描述产品描述产品描述产品描述产品描述品描述产品描述产品描述产品描述</div>
                <div class="good-sale flex flex-align-center flex-pack-justify">
                    <div class="flex flex-align-center">
                        <h1>￥99.9</h1>
                        <del>门市价￥999</del>
                    </div>
                    <p>销售量：9999</p>
                </div>
            </a>
            <a href="good_detail.html" class="good-item">
                <div class="good-img">
                    <p class="good-time">00时00分00秒</p>
                </div>
                <div class="good-info">产品描述产品描述产品描述产品描述产品描述品描述产品描述产品描述产品描述</div>
                <div class="good-sale flex flex-align-center flex-pack-justify">
                    <div class="flex flex-align-center">
                        <h1>￥99.9</h1>
                        <del>门市价￥999</del>
                    </div>
                    <p>销售量：9999</p>
                </div>
            </a>
            <a href="good_detail.html" class="good-item">
                <div class="good-img">
                    <p class="good-time">00时00分00秒</p>
                </div>
                <div class="good-info">产品描述产品描述产品描述产品描述产品描述品描述产品描述产品描述产品描述</div>
                <div class="good-sale flex flex-align-center flex-pack-justify">
                    <div class="flex flex-align-center">
                        <h1>￥99.9</h1>
                        <del>门市价￥999</del>
                    </div>
                    <p>销售量：9999</p>
                </div>
            </a>
        </div>
        <!-- ============= 列表 end ============== -->
        
    </div>

    <!-- ============= 悬浮按钮（客服+回到顶部）start ============== -->
    <div class="fix-button">
        <a href="javascript:;">客服</a><br>
        <a href="javascript:;" id="goToTop"><i class="iconfont iconvertical-align-top"></i></a>
    </div>
    <!-- ============= 悬浮按钮（客服+回到顶部）end ============== -->

    <!-- ============= 底部导航 start ============== -->
    <div class="weui-tabbar">
    <a class="weui-tabbar__item weui-bar__item_on" href="<?php echo url('index/index'); ?>">
        <i class="weui-tabbar__icon iconfont iconhome"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a class="weui-tabbar__item" href="share.html">
        <i class="weui-tabbar__icon iconfont iconshare"></i>
        <p class="weui-tabbar__label">分享</p>
    </a>
    <a class="weui-tabbar__item" href="mall.html">
        <i class="weui-tabbar__icon iconfont iconshopping"></i>
        <p class="weui-tabbar__label">积分商城</p>
    </a>
    <a class="weui-tabbar__item" href="<?php echo url('my/index'); ?>">
        <i class="weui-tabbar__icon iconfont iconuser"></i>
        <p class="weui-tabbar__label">我的</p>
    </a>
</div>
    
    <!-- ============= 底部导航 end ============== -->

    <script src="/themes/admin_simpleboot3/public/massets/lib/jquery/1.12.4/jquery.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/weui/weui.min.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/flexible/flexible.js"></script>
    <script src="/themes/admin_simpleboot3/public/massets/lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript">
        $(function(){

            // 轮播图
            var indexBanner = new Swiper ('.index-banner', {
                loop: true,
                autoplay: true,
                pagination: {
                    el: '.index-banner .swiper-pagination',
                }
            })  
            // 公告 
            var noticeBanner = new Swiper('.index-notice .swiper-container', {
                direction: 'vertical',
                autoplay: true,
                slidesPerView: 1
            });   

            // 回到顶部
            $("#goToTop").on("click",function(){
                $('html,body').animate({scrollTop: 0},'slow');
            })


            // 商品加载更多
            var page = 1,
                timers = null;

            var LoadingDataFn = function() {
                var dom = '';
                for (var i = 0; i < 3; i++) {
                    dom += '<a href="good_detail.html" class="good-item">'
                                +'<div class="good-img">'
                                    +'<p class="good-time">00时00分00秒</p>'
                                    +'</div>'
                                +'<div class="good-info">产品描述产品描述产品描述产品描述产品描述品描述产品描述产品描述产品描述</div>'
                                +'<div class="good-sale flex flex-align-center flex-pack-justify">'
                                    +'<div class="flex flex-align-center">'
                                        +'<h1>￥99.9</h1>'
                                        +'<del>门市价￥999</del>'
                                        +'</div>'
                                    +'<p>销售量：9999</p>'
                                +'</div>'
                            +'</a>';
                }
                $('.list-good').append(dom);
            };
            $(window).scroll(function() {
                if (($(window).height() + $(window).scrollTop() + 60) >= $(document).height()) {
                    clearTimeout(timers);
                    timers = setTimeout(function() {
                        page++;
                        console.log("第" + page + "页");
                        LoadingDataFn();
                    }, 300);
                }
            });

            //初始化， 第一次加载
            LoadingDataFn();
        })
    </script>
    <script src="https://webapi.amap.com/maps?v=1.4.15&key=2f5bc3950cfdbdfed65791bf7d829392"></script>
    <script type="text/javascript">
        //定位


        var mapObj = new AMap.Map('iCenter');
        mapObj.plugin('AMap.Geolocation', function () {
            geolocation = new AMap.Geolocation({
                enableHighAccuracy: true, // 是否使用高精度定位，默认:true
                timeout: 10000,           // 超过10秒后停止定位，默认：无穷大
                maximumAge: 0,            // 定位结果缓存0毫秒，默认：0
            });
            mapObj.addControl(geolocation);
            geolocation.getCurrentPosition();
            AMap.event.addListener(geolocation, 'complete', onComplete); // 返回定位信息
            AMap.event.addListener(geolocation, 'error', onError);       // 返回定位出错信息
        });

        function onComplete(obj){
            var res = JSON.stringify(obj.addressComponent, null, 4);
            $("#lname").html(obj.addressComponent.district);
        }

        function onError(obj) {
            alert(obj.info + '--' + obj.message);
            console.log(obj);
        }
    </script>
</body>
</html>