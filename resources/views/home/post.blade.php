@extends('home.layout.app')

@section('content')
<link href="{{asset('/X-admin/lib/layui/css/layui.css')}}" rel="stylesheet"/>
<link href="{{asset('/js/home/picker/css/mui.poppicker.css')}}" rel="stylesheet"/>
<link href="{{asset('/js/home/picker/css/mui.picker.css')}}" rel="stylesheet"/>
<script type="text/javascript" src="{{asset('/js/home/picker/js/mui.picker.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/home/picker/js/mui.poppicker.js')}}"></script>
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable">

    <!--主界面部分-->
    <div class="mui-inner-wrap">
        <header class="mui-bar mui-bar-nav" style="background: black">
            <h1 class="mui-title">Post Ad</h1>
        </header>
        <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
            <div class="edit mui-scorll">
                <form class="input-group">
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
                        <div style="margin-top: 20px">
                            <label>Upload Image</label>
                            <div class="input-file-wrap">
                                <button type="button" id="imageBtn" class="mui-btn">Select Image</button>
                            </div>
                            <div style="margin-top: 10px">
                                <ul class="img-list">
                                    <li><a href="javascript:;" class="imageup"><img width="55.19px" height="60px"/></a></li>
                                    <li><a href="javascript:;" class="imageup"><img  width="55.19px" height="60px"/></a></li>
                                    <li><a href="javascript:;" class="imageup"><img  width="55.19px" height="60px"/></a></li>
                                    <li><a href="javascript:;" class="imageup"><img  width="55.19px" height="60px"/></a></li>
                                    <li><a href="javascript:;" class="imageup"><img  width="55.19px" height="60px"/></a></li>
                                </ul>
                            </div>
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