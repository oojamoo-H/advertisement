<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager System</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/X-admin/lib/layui/css/layui.css')}}" />
    <style>
        /* login */
        .login-body {
            background: url("{{asset('/X-admin/images/bg-admin.png')}}") repeat fixed;
        }
        .login-box {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 320px;
            height: 241px;
            max-height: 300px;
        }
        .login-body .login-box h3{
            color: #444;
            font-size: 22px;
            text-align: center;
        }
        .login-box .layui-input[type='number'] {
            display: inline-block;
            width: 50%;
            vertical-align: top;
        }
        .login-box img {
            display: inline-block;
            width: 46%;
            height: 38px;
            border: none;
            vertical-align: top;
            cursor: pointer;
            margin-left: 4%;
        }
        .login-box button.btn-reset{
            width: 95px;
        }
        .login-box button.btn-submit{
            width: 190px;
        }
        .login-box .version{
            font-size: 12px;
        }
        .inp {
            border: 1px solid gray;
            padding: 0 10px;
            width: 200px;
            height: 30px;
            font-size: 18px;
        }
        .btn {
            border: 1px solid gray;
            width: 100px;
            height: 30px;
            font-size: 18px;
            cursor: pointer;
        }
        #embed-captcha {
            width: 300px;
            margin: 0 auto;
        }
        .show {
            display: block;
        }
        .hide {
            display: none;
        }
        #notice {
            color: red;
        }
        .geetest_logo, .geetest_success_logo{
            display: none;
        }
    </style>
</head>
<body class="login-body">

<div class="login-box">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <h3>Manager System<span class="version"></span></h3>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Account：</label>
            <div class="layui-input-inline">
                <input type="text" name="username" required class="layui-input" lay-verify="username" placeholder="Please entry account"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Password：</label>
            <div class="layui-input-inline">
                <input type="password" name="password" required class="layui-input" lay-verify="password" placeholder="Please entry password"/>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline">
                <div id="embed-captcha"></div>
                <p id="wait" class="show">Loading Auth Code......</p>
                <p id="notice" class="hide">Please validate first</p>
            </div>
        </div>
        <div class="layui-form-item">
            <button type="reset" class="layui-btn btn-reset layui-btn-danger" >Reset</button>
            <button type="button" class="layui-btn btn-submit" lay-submit="" lay-filter="sub">Sign Up</button>
        </div>
    </form>
</div>
<script src="{{asset('/X-admin/lib/layui/layui.js')}}" charset="utf-8"></script>
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('/js/admin/gt.js')}}"></script>
<script src="{{asset('/js/admin/config.js')}}"></script>
<script src="{{asset('/js/admin/api.js')}}"></script>
<script type="text/javascript">
    layui.use(['form', 'layer'], function () {
        var $ = layui.jquery,form = layui.form,layer = layui.layer;

        // 登录表单验证
        form.verify({
            username: function (value) {
                if (value == "") {
                    return "Please entry account";
                }
            },
            password: function (value) {
                if (value == "") {
                    return "Please entry password";
                }
            }
        });

        form.on('submit(sub)', function (data) {
            $.ajax({
                url: BaseUri + API_LIST.ADMIN_LOGIN,
                data : data.field,
                type : 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success :function(res) {
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800}, function () {
                            location.href = '/admin';
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800});
                        $('#verify').click();
                    }
                }
            });
            return false;
        })
    })

</script>
<script type="text/javascript">
    var handlerEmbed = function (captchaObj) {
        $("#embed-submit").click(function (e) {
            var validate = captchaObj.getValidate();
            console.log(123123)

            if (!validate) {
                $("#notice")[0].className = "show";
                setTimeout(function () {
                    $("#notice")[0].className = "hide";
                }, 2000);
                e.preventDefault();
            }
        });
        captchaObj.appendTo("#embed-captcha");
        captchaObj.onReady(function () {
            $("#wait")[0].className = "hide";
        });
    };
    $.ajax({
        url: BaseUri + API_LIST.GT_AUTH,
        data:{t: new Date().getTime()},
        type: "get",
        dataType: "json",
        success: function (res) {
            initGeetest({
                gt: res.data.gt,
                challenge: res.data.challenge,
                new_captcha: res.data.new_captcha,
                product: "float",
                offline: !res.data.success
            }, handlerEmbed);

        }
    });
</script>
</body>
</html>