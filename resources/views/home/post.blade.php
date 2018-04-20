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
    <script>
        if ({{$user['point']}} == 0){
            mui.alert("Please Buy Credit First", "Alert","Ok", function() {
                location.href = '/index';
            });
        }

    </script>
<link href="{{asset('/X-admin/lib/layui/css/layui.css')}}" rel="stylesheet"/>
<link href="{{asset('/js/home/picker/css/mui.poppicker.css')}}" rel="stylesheet"/>
<link href="{{asset('/js/home/picker/css/mui.picker.css')}}" rel="stylesheet"/>
<script src="{{asset('/js/home/mui.previewimage.js')}}"></script>
<script src="{{asset('/js/home/mui.zoom.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/home/picker/js/mui.picker.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/home/picker/js/mui.poppicker.js')}}"></script>
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable">

    <!--主界面部分-->
    <div class="mui-inner-wrap">
        <header class="mui-bar mui-bar-nav" style="background: black">
            <h1 class="mui-title">Post Ad</h1>
        </header>
        <div id="offCanvasContentScroll" class="mui-content ">
            <div class="edit mui-scroll-wrapper">
                <form class="input-group mui-scorll">
                    <div>
                        <label>Title</label>
                        <div class="mui-input-row">
                            <input name="title" type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry title">
                        </div>
                    </div>
                    <div>
                        <label>Content</label>
                        <div class="mui-input-row">
                            <textarea name="content" class="form-control" rows="5" placeholder=""></textarea>
                        </div>
                    </div>
                    <div>
                        <div class="input-file-group">
                            <div style="margin-top: 10px">
                                <div class="input-file-wrap">
                                    <button type="button" id="cityBtn" class="mui-btn">Select City</button>
                                </div>
                                <span id="parent_city" style="margin-left:5px"></span>
                                <span id="sub_city"  style="margin-left:5px"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-file-group">
                        <div style="margin-top: 20px">
                            <label>Upload Cover</label>
                            <ul class="img-list">
                                <li id="cover-container" style="height:180px"><button type="button" style="display: none" class="imageButton"></button><a style="width:100%;height:inherit;display:inline-block;" href="javascript:;" class="cover"></a></li>
                            </ul>

                        </div>
                    <div class="input-file-group">
                        <div style="margin-top: 20px">
                            <label>Upload Image</label>
                            <div style="margin-top: 10px">
                                <ul class="img-list">
                                    <li>
                                        <button type="button" style="display: none" class="imageButton"></button>
                                        <a style="width:100%;height:inherit;display:inline-block;" href="javascript:;" class="imageup"></a>
                                    </li>
                                    <li>
                                        <button type="button" style="display: none" class="imageButton"></button>
                                        <a style="width:100%;height:inherit;display:inline-block;" href="javascript:;" class="imageup"></a>
                                    </li>
                                    <li>
                                        <button type="button" style="display: none" class="imageButton"></button>
                                        <a style="width:100%;height:inherit;display:inline-block;" href="javascript:;" class="imageup"></a>
                                    </li>
                                    <li>
                                        <button type="button" style="display: none" class="imageButton"></button>
                                        <a style="width:100%;height:inherit;display:inline-block;" href="javascript:;" class="imageup"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div style="margin-top: 10px">
                            <label>Upload Video</label>
                            <div class="input-file-wrap">
                                <button type="button" id="videoBtn" class="mui-btn">Select Video</button>
                            </div>
                        </div>

                        <div style="margin-top: 15px">
                            <video width="100%">
                                <source src="" type="video/mp4"></source>
                            </video>
                            <input name="video" type="hidden"/>
                        </div>
                    </div>
                    <div class="mui-content-padded pt-md">
                        <button type="button" id='submit' class="mui-btn mui-btn-block mui-btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- off-canvas backdrop -->
        <div class="mui-off-canvas-backdrop"></div>
    </div>
</div>
<script type="text/javascript" src="{{asset('/js/home/post.js')}}"></script>
@endsection