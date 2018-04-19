@extends('home.layout.app')
@section('content')
<header class="mui-bar mui-bar-nav" style="background: #000">
    <a onclick="history.go(-1)" id="goBack" href="javascript:;" class="mui-icon mui-action-menu mui-icon mui-icon-back mui-pull-left" style="color: white"></a>
    <h1 class="mui-title">Login</h1>
</header>

<div class="mui-content">
    <div class="login">
        <form id='login-form' class="input-group" action="index.html">
            <div>
                <label>E-mail</label>
                <div class="mui-input-row">
                    <input id='login-username' type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry e-mail">
                </div>
            </div>
            <div>
                <label>Password<span class="fr text-warning"></span></label>
                <div class="mui-input-row">
                    <input id='login-password' type="password" autocomplete="new-password" class="mui-input-clear mui-input form-control" placeholder="Please entry password">
                </div>
            </div>
            <button type="button" id='login' class="mui-btn mui-btn-block login-btn mui-btn-primary" data-loading-icon-position="right">Login</button>

            <div class="link-area mui-text-center">
                <a href="javascript:;" id='regBtn'>Register</a>
            </div>
        </form>
    </div>

    <div class="reg mui-hidden">
        <form class="input-group">
            <div>
                <label>E-mail<span class="fr text-warning"></span></label>
                <div class="mui-input-row">
                    <input id='reg-username' type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry e-mail">
                </div>
            </div>
            <div>
                <label>Password<span class="fr text-warning"></span></label>
                <div class="mui-input-row">
                    <input id='reg-password' type="password" autocomplete="new-password" class="mui-input-clear mui-input form-control" placeholder="Please entry password">
                </div>
                <label class="fr text-warning">Password's length between 6 and 12</label>
            </div>
            <div>
                <label>Confirm</label>
                <div class="mui-input-row">
                    <input id='password_confirm' type="password" autocomplete="new-password" class="mui-input-clear mui-input form-control" placeholder="Please confirm password">
                </div>
            </div>
            <div>
                <label>Nickname<span class="fr text-warning"></span></label>
                <div class="mui-input-row">
                    <input id='reg-nickname' type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry username">
                </div>
            </div>
            <div>
                <label>Mobile<span class="fr text-warning"></span></label>
                <div class="mui-input-row">
                    <input id='reg-mobile' type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry mobile">
                </div>
            </div>
            <div>
                <label>Authentication Code</label>
                <div class="mui-input-row">
                    <input id='code' type="text" class="mui-input-clear mui-input form-control" placeholder="Please entry code">
                </div>
                <a style="color:red" href="javascript:;" id="registerTemp">（Please click here to scan code）</a>
            </div>
            <div class="mui-content-padded">
                <button type="button" id='register' class="mui-btn mui-btn-block mui-btn-primary">Register</button>
            </div>

            <div class="link-area mui-text-center">
                <a href="javascript:;" id='logBtn'>Login</a>
            </div>
            <div>
                Note: Working hr from 9am to 5pm, if register after working hr, authentication code might be received next working day.
            </div>
        </form>
    </div>
</div>

<div id="popover" class="mui-popover code-content" style="position: fixed">
    <div class="mui-popup mui-popup-in">
        <div class="mui-popup-inner">
            <div class="mui-popup-title">
                <img src="img/code.jpeg" class="code"/>
            </div>
            <div class="mui-popup-text" style="color:red">We will send authentication code to your email address.</div>
            <div class="mui-popup-text" style="color:red">Please scan QR code to contact our service. We will also send authentication code through your wechat if you don’t have an email account</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('/js/home/login.js')}}"></script>
@endsection
