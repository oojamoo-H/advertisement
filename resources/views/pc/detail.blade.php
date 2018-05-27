@extends('pc.layout.app')

@section('content')
    <style>

    </style>
    <div class="container-fluid">
        <div class="page-header">
            <h1>{{$detail['title']}}</h1>
            <small>Posted {{$detail['created_at']}}</small>
        </div>
        <div class="row">
            <div class="col-sm-8 col-md-7 ">
                <p style="margin-top: 10px;">
                <div>Publisher:&nbsp;&nbsp;{{$user_ad['nickname']}}</div>
                </p>

                <p style="margin-top: 25px;margin-bottom: 15px;">
                    Content:
                </p>
                <p style="margin-top: 15px;margin-bottom: 15px;color:black;padding:0 20px">
                    {!! $detail['content'] !!}
                </p>
                <p style="margin-top: 25px;margin-bottom: 15px">
                    Related Media:
                </p>
                @foreach ($detail['media'] as $media)
                    @if ($media->media_type === 'video')
                        <video width="100%" height="20%" controls="controls">
                            <source src="{{$media->media_url}}" type="video/mp4"></source>
                            当前浏览器不支持 video直接播放
                        </video>
                        @break
                    @endif

                @endforeach
            </div>
            <div id='u_list' class="col-sm-4 col-md-5">
                <!--list-->
                @foreach ($detail['media'] as $media)
                    @if ($media->media_type === 'image')
                        <div class="col-md-6 col-xs-12 " style="padding-bottom: 10px"><img data-preview-src="" data-preview-group="1"  style="width:100%" src="{{$media->media_url}}"/></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div>
            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">email to friend</button>
        </div>

        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">email to friend</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="email" id="email">
                            <span class="input-group-btn">
                                <button class="btn btn-default send" type="button" >send</button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button type="button" class="btn btn-danger send">send</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
    @verbatim
    <script>
    $(function(){
        $('body').on('click', '.send', function () {
            var email = $('#email').val();
            Ajax.email_to_friend({email:email},function(res){
                if(res.code != 1){
                    alert(res.msg)
                }
            })
            $('#myModal').modal('hide');
        })
    })
    </script>
    @endverbatim
@endsection