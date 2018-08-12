<!DOCTYPE html>
<html lang="zh">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="google-site-verification" content="oVcp0kcxsulWNYIBhqAVYeyXMkycUu3f8gKhYPvBy9U"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="session-token" content="{{ Session::get('home_user') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home Page</title>
    <link rel="stylesheet" href="{{asset('/bootstrap/css/bootstrap.min.css')}}">


    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/X-admin/lib/layui/layui.all.js')}}"></script>
    <script src="{{asset('/js/home/config.js')}}"></script>
    <script src="{{asset('/js/home/api.js')}}"></script>
    <script src="{{asset('/js/helper.js')}}"></script>
    <script src="{{asset('/js/home/base.js')}}"></script>
    <script src="{{asset('/js/home/ajax.js')}}"></script>

    <link rel="stylesheet" href="{{asset('/css/style_pc.css')}}">
    <style>

    </style>
</head>

<body>

<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav" id="aside-menu">
            <li class="sidebar-brand">
                <a href="/  ">
                    Home
                </a>
            </li>
            <li>
                <a href="javascript:;" id="linkPage"  data-point=""><i class="fa fa-fw fa-home"></i>Post Ad</a>
            </li>
            <li>
                <a href="javascript:;"  id="buyPage"><i class="fa fa-fw fa-home"></i>Buy Credit</a>
            </li>
            <li>
                @if (empty($user))
                    <a href="/login"  id="myAccount"><i class="fa fa-fw fa-home"></i>My Account</a>
                @else
                    <a href="javascript:;"  ><i class="fa fa-fw fa-home"></i>Your Point:&nbsp;&nbsp;{{$user['point']}}</a>
                @endif
            </li>
            @if (! empty($user))
            <li>
                <a href="/ad/myAdList"  id="myAccount2"><i class="fa fa-fw fa-home"></i>My Account</a>
            </li>
                <li>
                    <a href="javascript:;"  id="logout"><i class="fa fa-fw fa-cog"></i>Log Out</a>
                </li>
            @endif

            {{--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Dropdown
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Dropdown heading</li>
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>--}}

        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->



    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-default " style="position: fixed;top:0;width: 100%;z-index:100;">
            <div class="container-fluid">
                <button type="button" class="hamburger is-closed animated fadeInLeft " data-toggle="offcanvas">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <form class="navbar-form navbar-right" action="/ad/search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword">
                    </div>
                    <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
                </form>
            </div>
        </nav>
        <ol class="breadcrumb" style="position: fixed;top:50px;width: 100%;background-color: #0C0C0C;z-index: 100;">
            <li><a href="/" style="color: #fff;">Home</a></li>
            <li><span style="color: #fff;" class="selected-city">Brisbane</span></li>
            <li><span style="color: #fff;" >escorts</span></li>
        </ol>
        <div class="container-fluid">
            @yield('content')
        </div>
        <div class="container-fluid text-center" style="padding-top: 20px">
            <p>This site is restricted to persons 18 years or over<br/>
                All Rights Reserved ©2018 <a href="/" style="color:#000">www.escortpie.com</a></p>
            <div class="row">
                <div class="list-unstyled list-inline" id="friendly-links">

                </div>
            </div>

        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->


@verbatim
<script type="text/javascript">
    var trigger;
    $(document).ready(function () {
        trigger = $('.hamburger');
        var overlay = $('.overlay'),
            isClosed = false;

        trigger.click(function () {
            hamburger_cross();
        });

        function hamburger_cross() {

            if (isClosed == true) {
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');
                isClosed = false;
            } else {
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');
                isClosed = true;
            }
        }

        $('[data-toggle="offcanvas"]').click(function () {
            $('#wrapper').toggleClass('toggled');
        });

        overlay.click(function(){
            trigger.click();
        });
    });

</script>

<script type="text/html" id="friendly-link">
    {{# layui.each(d, function(index, item){}}
    <a style="color:red;margin-left: 10px;" href="{{item.url}}" >{{item.name}}</a>
    {{#  }); }}
</script>
@endverbatim
</body>

</html>