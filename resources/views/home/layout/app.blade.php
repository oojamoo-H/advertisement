<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="google-site-verification" content="oVcp0kcxsulWNYIBhqAVYeyXMkycUu3f8gKhYPvBy9U" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="session-token" content="{{ Session::get('home_user') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home Page</title>
    <link href="{{asset('/css/mui.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/style.css')}}" rel="stylesheet" />
    {{--<link href="{{asset('/X-admin/lib/layui/css/layui.css')}}" rel="stylesheet" />--}}
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('/js/home/mui.min.js')}}"></script>
    <script src="{{asset('/X-admin/lib/layui/layui.all.js')}}"></script>
    <script src="{{asset('/js/helper.js')}}"></script>
    <script src="{{asset('/js/home/config.js')}}"></script>
    <script src="{{asset('/js/home/api.js')}}"></script>
    <script src="{{asset('/js/home/ajax.js')}}"></script>
    <style type="text/css">
        .layui-layer-ico16, .layui-layer-loading .layui-layer-loading2{
            left: 45%;
        }
        .layui-layer-shade{
            opacity: 0.8;
        }
        .layui-layer-loading .layui-layer-loading1{
            left: 45%;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>