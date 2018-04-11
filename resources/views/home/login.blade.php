<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        X-admin v1.0
    </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="{{asset('/X-admin/css/xadmin.css')}}" media="all">
</head>

<body style="background-color: #393D49">
<div>

</div>
<script src="{{asset('/X-admin/lib/layui/layui.js')}}" charset="utf-8">
</script>
<script>
    layui.use(['form'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;

            $('.x-login-right li').click(function(event) {
                color = $(this).attr('color');
                $('body').css('background-color', color);
            });

            //监听提交
            form.on('submit(save)',
                function(data) {
                    console.log(data);
                    layer.alert(JSON.stringify(data.field), {
                        title: '最终的提交信息'
                    },function  () {
                        location.href = "./index.html";
                    })
                    return false;
                });

        });

</script>
</body>

</html>