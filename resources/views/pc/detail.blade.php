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
        {{--<div>
            <button type="button" class="btn btn-default">email to friend</button>
        </div>--}}
    </div>
    @verbatim

    @endverbatim
@endsection