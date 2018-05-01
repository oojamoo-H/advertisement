@extends('home.layout.app')

@section('content')
<style type="text/css">

    .mui-slider .mui-slider-group .mui-slider-item img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
    }
    .mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
        width: 100%;
    }

    .mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
        display: table-cell;
        vertical-align: middle;
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
</style>

<!--主界面部分-->
<div class="mui-inner-wrap">
    <header class="mui-bar mui-bar-nav" style="background: black">
        <a id="goBack" href="javascript:;" class="mui-icon mui-action-menu mui-icon mui-icon-back mui-pull-left" style="color: white"></a>
    </header>
    <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
        <div class="content mui-content-padded mui-scroll">


                @foreach ($result as $v)
                <div class="mui-row">
                    <div class="mui-col-xs-8 mui-col-sm-9">
                        <li class="mui-table-view-cell">
                            {{$v['title']}}
                        </li>
                    </div>
                    <div class="mui-col-xs-4 mui-col-sm-3">
                        <a data-id="{{$v['id']}}" href="javascript:;" class="edit">Edit</a>
                        <span class="spliter">|</span>
                        <a data-id="{{$v['id']}}" href="javascript:;" class="repost">Repost</a>
                    </div>
                </div>
                @endforeach


        </div>
    </div>
</div>
    @verbatim
    <script>
        $(function () {
            mui.init();

            mui(".mui-scroll-wrapper").scroll({
                deceleration : 0.0005,
                indicators: false
            });
            mui('body').on('tap', '.edit', function () {
                Helper.redirect('/ad/post',{
                    ad_id : $(this).data('id')
                })
            });
            mui('body').on('tap', '.repost', function () {
                Helper.redirect('/ad/post',{
                    ad_id : $(this).data('id'),
                    repost : 1
                })
            });
            mui('body').on('tap', '#goBack', function () {
                Helper.redirect('/index')
            });
        })
    </script>
    @endverbatim
@endsection