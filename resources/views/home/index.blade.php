@extends('home.layout.app')

@section('content')
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
                <div class="table pt-md">
                    <a  href="javascript:;" class="mui-control-item">top</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item">gallery</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item">vedio</a>
                    <span class="spliter">|</span>
                    <a  href="javascript:;" class="mui-control-item">date</a>
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

<script type="text/javascript">
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
                    {{# layui.each(d.advertisement_list.advertisement, function(index, item){}}
                    <li data-id="{{item.id}}" data-user-id="{{item.user[0].id}}">{{item.content}}</li>
                    {{# }); }}
                </ul>
            </div>
        </script>


        <script type="text/html" id="vip-advertisement">

        </script>

    @endverbatim
@endsection