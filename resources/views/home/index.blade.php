@extends('home.layout.app')

@section('content')
    <style type="text/css">
        .mui-preview-image.mui-fullscreen {
            position: fixed;
            z-index: 20;
            background-color: #000;
        }
        .mui-preview-header,
        .mui-preview-footer {
            position: absolute;
            width: 100%;
            left: 0;
            z-index: 10;
        }
        .mui-preview-header {
            height: 44px;
            top: 0;
        }
        .mui-preview-footer {
            height: 50px;
            bottom: 0px;
        }
        .mui-preview-header .mui-preview-indicator {
            display: block;
            line-height: 25px;
            color: #fff;
            text-align: center;
            margin: 15px auto 4;
            width: 70px;
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            font-size: 16px;
            left:45%;
        }
        .mui-preview-image {
            display: none;
            -webkit-animation-duration: 0.5s;
            animation-duration: 0.5s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }
        .mui-preview-image.mui-preview-in {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }
        .mui-preview-image.mui-preview-out {
            background: none;
            -webkit-animation-name: fadeOut;
            animation-name: fadeOut;
        }
        .mui-preview-image.mui-preview-out .mui-preview-header,
        .mui-preview-image.mui-preview-out .mui-preview-footer {
            display: none;
        }
        .mui-zoom-scroller {
            position: absolute;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            -webkit-backface-visibility: hidden;
        }
        .mui-zoom {
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }
        .mui-slider .mui-slider-group .mui-slider-item img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }
        .mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
            width: 100%;
        }
        .mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
            display: inline-table;
        }
        .mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
            display: table-cell;
            vertical-align: middle;
        }
        .mui-preview-loading {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .mui-preview-loading.mui-active {
            display: block;
        }
        .mui-preview-loading .mui-spinner-white {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -25px;
            margin-top: -25px;
            height: 50px;
            width: 50px;
        }
        .mui-preview-image img.mui-transitioning {
            -webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }
        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @-webkit-keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        p img {
            max-width: 100%;
            height: auto;
        }
        .mui-slider .mui-slider-group .mui-slider-item{
            top:30%;
        }
        .mui-preview-header, .mui-preview-footer{
            left:40%;
        }
    </style>
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable">
    <!--侧滑菜单部分-->
    <aside id="offCanvasSide" class="mui-off-canvas-left">
        <div id="offCanvasSideScroll" class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted" id="aside-menu">
                    <li class="mui-table-view-cell">
                        <a href="javascript:;" class="mui-navigate-right" id="linkPage">Post Ad</a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a href="javascript:;" class="mui-navigate-right" id="buyPage">Buy Credit</a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a href="javascript:;" class="mui-navigate-right" id="videoPage">My Account</a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a href="javascript:;">NearBy</a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <!--主界面部分-->
    <div class="mui-inner-wrap">
        <header class="mui-bar mui-bar-nav">
            <a href="#offCanvasSide" class="mui-icon mui-action-menu mui-icon-bars mui-pull-left"></a>
            <div class="mui-icon-right-nav mui-pull-right search">
                <input type="text" class="mui-input-clear" placeholder="">
                <a href="javascript:;" class="mui-icon-search mui-icon"></a>
            </div>
        </header>
        <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
            <div style="width:100%;height:45px;background: red">
                <div style="width:90%;margin:0 auto;padding:10px 0;color:black; text-align: center; font-weight: bold; font-size:14px">Escortbabe</div>
            </div>
            <div style="width:100%;height:30px;background: black;padding:5px 20px;font-size:12px">
                <a style="color:white"  href="javascript:;" class="mui-control-item">Home</a>
                <span style="color:white" class="spliter">></span>
                <a style="color:white" href="javascript:;" class="mui-control-item selected-city">Melbourne</a>
                <span style="color:white" class="spliter">></span>
                <a style="color:white" href="javascript:;" class="mui-control-item">escorts</a>
            </div>
            <div class="content">
                <div class="link-area" id="parent-cities">
                    <a href="javascript:;">All</a>

                </div>
                <div class="link-area" id="sub-cities">
                </div>

                <!--swiper-->
                <div id="slider" class="mui-slider">
                    <div class="mui-slider-group mui-slider-loop">
                        <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                        <div class="mui-slider-item mui-slider-item-duplicate">
                            <a href="#">
                                <img src="img/3.jpg">
                            </a>
                        </div>
                        <!-- 第一张 -->
                        <div class="mui-slider-item">
                            <a href="#">
                                <img src="img/1.jpg">
                            </a>
                        </div>
                        <!-- 第二张 -->
                        <div class="mui-slider-item">
                            <a href="#">
                                <img src="img/2.jpg">
                            </a>
                        </div>
                        <!-- 第三张 -->
                        <div class="mui-slider-item">
                            <a href="#">
                                <img src="img/3.jpg">
                            </a>
                        </div>
                        <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
                        <div class="mui-slider-item mui-slider-item-duplicate">
                            <a href="#">
                                <img src="img/1.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="mui-slider-indicator">
                        <div class="mui-indicator mui-active"></div>
                        <div class="mui-indicator"></div>
                        <div class="mui-indicator"></div>
                    </div>
                </div>

                <!--table-->
                <div class="table pt-md tab-list">
                    <a  href="javascript:;" class="mui-control-item tab" data-index="1">top</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item tab" data-index="2">gallery</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item tab" data-index="3">vedio</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item tab" data-index="4">date</a>
                </div>
                <div id="advertisement-item">

                </div>
            </div>
        </div>
        <!-- off-canvas backdrop -->
        <div class="mui-off-canvas-backdrop"></div>
    </div>
</div>
<div id="popover" class="mui-popover code-content">
    <div class="mui-popup mui-popup-in">
        <div class="mui-popup-inner">
            <div class="mui-popup-title">
                <img src="img/code.png" class="code"/>
            </div>
            <div class="mui-popup-text">Please contact customer service to get authentication code</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('/js/home/index.js')}}"></script>
<script src="{{asset('/js/home/mui.previewimage.js')}}"></script>
<script src="{{asset('/js/home/mui.zoom.js')}}"></script>

<script type="text/javascript">
    $(function($){
        mui.init();
        $('.mui-inner-wrap').on('drag', function(event) {
            event.stopPropagation();
        });

        mui('body').on('tap', '#buyPage', function () {
            var session_user = $('meta[name=session-token]').attr('content')
            if (! session_user){
                Helper.redirect('/login')
            } else {
                mui('#offCanvasWrapper').offCanvas('close');
                mui('#popover').popover('toggle');
            }
        });

        mui('body').on('tap', '.tab', function () {
            var index = $(this).data('index');
            $('.mui-control-content').hide();
            $('#item' + index).show();
        })

        mui.previewImage();
    })
</script>
    @verbatim

        <script type="text/html" id="aside-city">
            {{# layui.each(d.cities, function(index, item){}}
            <li class="mui-table-view-cell">
                <a href="javascript:;" data-id="{{ item.id }}" class="mui-navigate-right aside-parent-cities">
                    {{ item.city_name }}
                </a>
            </li>
            {{#  }); }}
        </script>

        <script type="text/html" id="parent-city">
            {{# layui.each(d.cities, function(index, item){}}
                <span class="spliter">|</span>
                <a data-id="{{item.id}}" href="javascript:;" class="parent-cities">{{item.city_name}}</a>
            {{#  }); }}

        </script>

        <script type="text/html" id="sub-city">
            {{# layui.each(d.sub_cities, function(index, item){}}
                {{# if (index != 0) {}}
                <span class="spliter">|</span>
                {{# } }}
                <a data-id="{{item.id}}" href="javascript:;" class="sub-cities">{{item.city_name}}</a>
            {{#  }); }}
        </script>

        <script type="text/html" id="advertisement">
            <div id="item1" class="mui-control-content mui-active">
                <ul class="news-list">
                    {{# layui.each(d.advertisement_list, function(index, item){}}
                    <li data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">{{item.content}}</li>
                    {{# }); }}
                </ul>
            </div>
            <div id="item2" class="mui-control-content mui-active" style="display: none">
                <ul class="news-list">
                    {{# layui.each(d.advertisement_list, function(index, item){}}
                    <li style="display: flex;flex-direction: row" data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">
                        {{# layui.each(item.media, function(i, mediaItem){}}
                            {{# if(mediaItem.media_type ==='image/jpeg' || mediaItem.media_type ==='image/png'){}}
                            <img data-preview-src="" data-preview-group="{{index}}" style="margin-right: 3px" width="20%" height="20%" src="{{mediaItem.media_url}}"/>
                            {{#} }}
                        {{# });}}
                    </li>
                    {{# }); }}
                </ul>
            </div>
            <div id="item3" class="mui-control-content mui-active" style="display: none">
                <ul class="news-list">
                    {{# layui.each(d.advertisement_list, function(index, item){}}
                    <li data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">
                        {{# layui.each(item.media, function(i, mediaItem){}}
                            {{# if(mediaItem.media_type ==='video/mp4'){}}
                                <video width="100%" height="20%" src="{{mediaItem.media_url}}" controls="controls"></video>
                            {{#} }}
                        {{# });}}

                    </li>
                    {{# }); }}
                </ul>
            </div>
        </script>


        <script type="text/html" id="vip-advertisement">

        </script>

    @endverbatim
@endsection