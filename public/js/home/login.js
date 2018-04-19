$(function(){
    mui('body').on('tap', '#regBtn', function () {
        $(".login").addClass("mui-hidden");
        $(".reg").removeClass("mui-hidden");
        $('h1').text('Register')
    });

    mui('body').on('tap', '#logBtn', function () {
        $(".login").removeClass("mui-hidden");
        $(".reg").addClass("mui-hidden");
        $('h1').text('Login')
    });

    mui('body').on('tap', '#login', function () {
        mui('#login').button('loading')
        var username = $.trim($('#login-username').val());
        var password = $.trim($('#login-password').val());

        Ajax.login({username : username, password : password}, function (res) {
            mui('#login').button('reset')
            if (res.code === 1){
                Helper.redirect('/index')
            } else if (res.code === -2) {
                mui('#popover').popover('toggle');
            } else {
                mui.alert(res.msg, 'Alert', 'ok');
            }
        })
    });

    mui('body').on('tap', '#register', function () {
        mui('#register').button('loading');
        var username = $.trim($('#reg-username').val());
        var password = $.trim($('#reg-password').val());
        var nickname = $.trim($('#reg-nickname').val());
        var mobile = $.trim($('#reg-mobile').val())
        var confirm_password = $.trim($('#password_confirm').val());
        var code = $.trim($('#code').val());
        Ajax.register({
            username: username,
            password: password,
            nickname: nickname,
            mobile:mobile,
            confirm_password: confirm_password,
            code: code
        }, function (res) {
            mui('#register').button('reset');
            if (res.code === 1){
                Helper.redirect('/login');
            } else {
                mui.alert(res.msg, 'Alert', 'ok');
            }
        })
    });

    mui('body').on('tap', '#registerTemp', function () {
        var username = $.trim($('#reg-username').val());
        Ajax.register_for_temp({username : username}, function (res) {
            if (res.code === 1){
                mui('#popover').popover('toggle');
            } else {
                mui.alert(res.msg, 'Alert', 'ok');
            }
        })

    });
});