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
    <script src="{{asset('/js/home/mui.previewimage.js')}}"></script>
    <script src="{{asset('/js/home/mui.zoom.js')}}"></script>
        <!--主界面部分-->
        <div class="mui-inner-wrap">
            <header class="mui-bar mui-bar-nav" style="background: black">
                <a id="goBack" href="javascript:;" class="mui-icon mui-action-menu mui-icon mui-icon-back mui-pull-left" style="color: white"></a>
            </header>
            <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
                <div class="content mui-content-padded mui-scroll">

                    <h3 class="pb-sm">{{$detail['title']}}</h3>
                    <p style="margin-top: 10px;">
                        <div>Publisher:&nbsp;&nbsp;{{$user_ad['nickname']}}</div>
                        <div>Date:&nbsp;&nbsp;{{$detail['created_at']}}</div>
                    </p>

                    <p style="margin-top: 25px;margin-bottom: 15px;">
                        Content:
                    </p>
                    <p style="margin-top: 15px;margin-bottom: 15px;color:black;padding:0 20px">
                        {!! $detail['content'] !!}
                    </p>
                    <p style="margin-top: 25px;margin-bottom: 15px">
                        Related Media:
                    </p>
                    @foreach ($detail['media'] as $media)
                        @if ($media->media_type === 'video')
                            <video width="100%" height="20%" controls="controls">
                                <source src="{{$media->media_url}}" type="video/mp4"></source>
                                当前浏览器不支持 video直接播放
                            </video>
                            @break
                        @endif

                     @endforeach
                    <!--list-->
                    @foreach ($detail['media'] as $media)
                        @if ($media->media_type === 'image')
                            <div style="width:100%"><img data-preview-src="" data-preview-group="1"  style="width:100%" src="{{$media->media_url}}"/></div>
                        @endif
                    @endforeach

                    <!--list-->
                    <p style="margin-top:25px">
                        Related Link:
                    </p>
                    <ul class="news-list">
                        @foreach($user_ad['advertisement'] as $advertisement)
                        <li data-id="{{$advertisement['id']}}" data-user-id="{{$user_ad['id']}}" class="user-ads">{{$advertisement['title']}}</li>
                        @endforeach
                    </ul>
                    <button id="send_to_friend" class="mui-btn mui-btn-danger mui-btn-outlined">email to friend</button>
                    <div class="friendly-links" id="friendly-links" style="font-size: 12px">

                        <div style="color:red">This site is restricted to persons 18 years or over<br/>
                            All Rights Reserved ©2018 www.Escortbabe.com.au</div>


                    </div>
                </div>

            </div>
            <!-- off-canvas backdrop -->

        </div>
    @verbatim
        <script>
            $(function () {
                mui.init();

                mui(".mui-scroll-wrapper").scroll({
                    deceleration : 0.0005,
                    indicators: false,
                });
                mui('body').on('tap', '.user-ads', function () {
                    Helper.redirect('/ad/detail', {
                        ad_id : $(this).data('id'),
                        user_id : $(this).data('user-id')
                    })
                })

                mui('body').on('tap', '#goBack', function () {
                    Helper.redirect('/index')
                })
                mui.previewImage();


                mui('body').on('tap','#send_to_friend',function(){
                    mui.prompt('friend\'s email','email','Email To Friend',['cancel','send'],function(data){
                        if(data.index) {
                            var email = data.value;
                            Ajax.email_to_friend({email: email}, function (res) {
                                if (res.code != 1) {
                                    mui.alert(res.msg, 'Alert', 'ok');
                                }
                            })
                        }
                    },'div')
                })
            })
            Ajax.get_friendly_links({}, function (res) {
                if (res.code === 1){
                    Helper.render($('#friendly-links'), $('#friendly-link'), res.data, 1);
                }
            })
        </script>
        <script type="text/html" id="friendly-link">
            {{# layui.each(d, function(index, item){}}
            {{# if (index != 0) {}}
            <br/>
            {{# } }}
            <a style="color:red" href="javascript:;" data-url="{{item.url}}" class="sub-cities">{{item.name}}</a>
            {{#  }); }}
        </script>
    @endverbatim
@endsection