@extends('home.layout.app')

@section('content')
    <div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable">
        <!--主界面部分-->
        <div class="mui-inner-wrap">
            <header class="mui-bar mui-bar-nav">

            </header>
            <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
                <div class="content">

                    <h3 class="pb-sm">{{$detail['title']}}</h3>
                    @foreach ($detail['media'] as $media)
                        @if ($media['media_type'] === 'video/mp4')
                            <video width="100%" height="20%" controls="controls">
                                <source src="{{$media['media_url']}}" type="video/mp4"></source>
                                当前浏览器不支持 video直接播放
                            </video>
                            @break
                        @endif
                     @endforeach
                    <!--list-->
                    <ul class="img-list">
                        @foreach ($detail['media'] as $media)
                            @if ($media['media_type'] === 'image/jpeg')
                                <li><img style="width:100%" src="{{$media['media_url']}}"/></li>
                            @endif
                        @endforeach
                    </ul>
                    <!--list-->
                    <ul class="news-list">
                        @foreach($user_ad['advertisement'] as $advertisement)
                        <li data-id="{{$advertisement['id']}}" data-user-id="{{$user_ad['id']}}" class="user-ads">{{$advertisement['content']}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- off-canvas backdrop -->
            <div class="mui-off-canvas-backdrop"></div>
        </div>
    </div>
    @verbatim
        <script>
            mui('body').on('tap', '.user-ads', function () {
                Helper.redirect('/ad/detail', {
                    ad_id : $(this).data('id'),
                    user_id : $(this).data('user-id')
                })
            })
        </script>
    @endverbatim
@endsection