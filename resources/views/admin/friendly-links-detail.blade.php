@include('UEditor::head')
@extends('admin.layout.app')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">System</a>
        <a><cite>Friendly Link Setting</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i>
        </a>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right;margin-right:15px" href="javascript:location.href = '/admin/friendlyLinksSetting';" title="返回">
            <i class="layui-icon" style="line-height:30px">&#xe65c;</i>
        </a>
    </div>

    <div class="x-body">
        <fieldset class="layui-elem-field">
            <legend>Friendly Link Setting</legend>
            <div class="layui-field-box">
                <form class="layui-form" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">name</label>
                            <div class="layui-input-block">
                                <input type="text" name="name"  placeholder="" autocomplete="off" class="layui-input" value="{{$detail['name']??''}}" lay-verify="required">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Is Link</label>
                            <div class="layui-input-inline">
                                <input lay-filter="redio" type="radio" name="is_url" value="1" title="yes" @if(($detail['is_url']??1) === 1)checked @endif>
                                <input lay-filter="redio" type="radio" name="is_url" value="0" title="no" @if(($detail['is_url']??1) === 0) checked @endif>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">URL</label>
                            <div class="layui-input-block">
                                <input id="url" type="text" name="url"  placeholder="" autocomplete="off" class="layui-input" value="{{$detail['url']??''}}">
                                <div class="layui-form-mid layui-word-aux">Effective when is_url is yes</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Content</label>
                            <div class="layui-input-block">
                                <textarea id="content" name="content" placeholder="请输入内容" class="layui-textarea">{{$detail['content']??''}}</textarea>
                                <div class="layui-form-mid layui-word-aux">Effective when is_url is no</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Sort</label>
                            <div class="layui-input-inline">
                                <input type="text" name="sort"  placeholder="" autocomplete="off" class="layui-input" value="{{$detail['sort']??0}}" lay-verify="number">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Status</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" name="status" lay-skin="switch" lay-text="ON|OFF" value="1" @if($detail['status']??1 == 1)checked @endif>
                                <div class="layui-form-mid layui-word-aux">Does it appear on the front page</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="formDemo" data-id="{{$detail['id']??0}}">submit</button>
                                <button type="reset" class="layui-btn layui-btn-primary">reset</button>
                            </div>
                        </div>
                </form>
            </div>
        </fieldset>
    </div>
    <script>
        $(function () {
            layui.use('form', function () {
                var form = layui.form;
                //监听提交
                form.on('submit(formDemo)', function (data) {
                    var id = $(this).data('id');

                    data.field.id = id;
                   Ajax.save_friendly_link(data.field, function (res) {
                        if (res.code === 1){
                            layer.msg('Saved Successfully',
                                {icon: 1,time: 2000 },
                                function(){
                                location.href = '/admin/friendlyLinksSetting';
                                })
                        } else {
                            layer.msg(res.msg)
                        }
                    })
                    return false;
                });
            });
            var ue = UE.getEditor('content', {
                initialFrameWidth : '100%',
                initialFrameHeight : 350,
            });
        });



    </script>
@endsection