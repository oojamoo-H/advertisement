@extends('admin.layout.app')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">System</a>
        <a><cite>Setting</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>

    <div class="x-body">
    <fieldset class="layui-elem-field">
        <legend>System Setting</legend>
        <div class="layui-field-box">
            <form class="layui-form" action="">
                @foreach($system as $s)
                <div class="layui-form-item">
                    <label class="layui-form-label">{{$s['show_name']}}</label>
                    <div class="layui-input-inline">
                        <input type="text" name="{{$s['key']}}"  placeholder="" autocomplete="off" class="layui-input" value="{{$s['value']}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">{{$s['description']}}</div>
                    <button data-id="{{$s['id']}}" data-key="{{$s['key']}}" type="button" class="layui-btn layui-btn-sm system-button" lay-submit>Save</button>
                </div>
                @endforeach
                @foreach($user as $u)
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{$u['username']}}</label>
                        <div class="layui-input-inline">
                            <input id="password{{$u['id']}}" type="text" name="password" placeholder="" autocomplete="off" class="layui-input" value="">
                        </div>
                        <div class="layui-form-mid layui-word-aux">Reset Password</div>
                        <button data-id="{{$u['id']}}" type="button" class="layui-btn layui-btn-sm admin-button" lay-submit>Save</button>
                    </div>
                @endforeach
            </form>
        </div>
    </fieldset>
    </div>
    <script>
        $(function () {
            layui.use(['layer'], function () {
                var layer = layui.layer;
                $('body').on('click', '.system-button', function () {
                    var key = $(this).data('key');
                    var value = $('input[name="' + key + '"]').val()
                    var id = $(this).data('id');
                    var data = {key : key , id : id, value : value}
                    Ajax.system_save(data, function (res) {
                        if (res.code === 1){
                            alert('Saved Successfully')
                        } else {
                            alert(res.msg)
                        }
                    })
                })

                $('body').on('click', '.admin-button', function () {
                    var id = $(this).data('id');

                    var password = $('#password' + id).val();
                    Ajax.save_admin_password({id : id, password : password}, function (res) {
                        if (res.code === 1){
                            alert('Saved Successfully')
                        } else {
                            alert(res.msg)
                        }
                    })
                })
            })
        })
    </script>
@endsection