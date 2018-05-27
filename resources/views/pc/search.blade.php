@extends('pc.layout.app')

@section('content')
    <style>
        a.list-group-item{
            color:#23527c;
        }
        a.list-group-item:hover{
            color:#23527c;
            text-decoration: underline;
        }
        .no-border{
            border:none;
        }
        .gellary_img{
            max-height: 300px;
        }
        .gellary_title{
            width:200px;
            display: block;
        }
        .gellary_date{
            color:#ccc;
        }
        .list-inline li{
            height:450px
        }
        .thumbnail{
            height: 310px;
        }
        .top_list{
            background-color: #fafad2;
            margin: 10px auto;
            padding:10px;
        }
    </style>
    <div class="container-fluid">

        <div class="row-fluid">
            <ul class="nav nav-tabs">
                <li class="active" data-index="1"><a href="#identifier1" data-toggle="tab">top</a></li>
                <li data-index="2"><a href="#identifier2" data-toggle="tab">gallery</a></li>
                <li data-index="3"><a href="#identifier3" data-toggle="tab">vedio</a></li>
            </ul>
            <div class="tab-content" id="advertisement-item">

            </div>
        </div>


    </div>
    @verbatim
        <script>
            var keyword = '<?php echo $keyword ?: ''?>';
            var tab = 1;
            $(function($){
                Ajax.search_advertisement({
                    keyword : keyword,
                }, function (res) {
                    if (res.code === 1){
                        Helper.render($('#advertisement-item'), $('#advertisement'), res.data, 0);
                    } else {
                        alert(res.msg);
                    }
                });

                $('body').on('click','.nav-tabs li',function(){
                    tab = $(this).data('index');
                })
            })
        </script>

        <script type="text/html" id="advertisement">
            <div class="tab-content" id="advertisement-item">
                <div class="tab-pane {{# if(tab==1){}}active{{# } }}" id="identifier1">
                    <div class="list-unstyled list-group">
                        {{# layui.each(d.advertisement_list, function(index, item){}}
                        <a href="/ad/detail?ad_id={{item.advertisement_id}}"  class="list-group-item no-border" data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">
                            {{item.title}}
                        </a>
                        {{# });}}
                    </div>
                </div>
                <div class="tab-pane {{# if(tab==2){}}active{{# } }}" id="identifier2">
                    <ul class="list-unstyled list-inline">
                        {{# layui.each(d.advertisement_list, function(index, item){}}
                        {{# if (item.image.length > 0){}}

                        {{# layui.each(item.image, function(i, mediaItem){}}
                        {{# if (mediaItem.is_cover == 1) {}}
                        <li data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}" class="col-xs-12 col-sm-4 col-md-3 .col-lg-2">
                            <a class="thumbnail" href="/ad/detail?ad_id={{item.advertisement_id}}">
                                <img class="gellary_img" data-preview-group="{{index}}"   src="{{mediaItem.media_url}}" >
                            </a>
                            <br>
                            <a href="/ad/detail?ad_id={{item.advertisement_id}}" class="gellary_title">{{item.title}}</a>
                            <br>
                            <span class="gellary_date">Posted:{{item.created_at}}</span>
                        </li>
                        {{# return true;} }}
                        {{# });}}

                        {{#} }}
                        {{# }); }}
                    </ul>
                </div>
                <div class="tab-pane {{# if(tab==3){}}active{{# } }}" id="identifier3">
                    <ul class="list-unstyled list-inline">
                        {{# layui.each(d.advertisement_list, function(index, item){}}
                        {{# if(item.video.id){}}
                        <li data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}" class="col-xs-12 col-sm-4 col-md-3 .col-lg-2">
                            {{# layui.each(item.image, function(i, mediaItem){}}
                            {{# if (mediaItem.is_cover == 1) {}}
                            <a class="thumbnail" href="/ad/detail?ad_id={{item.advertisement_id}}">
                                <img class="gellary_img" data-preview-group="{{index}}" src="{{mediaItem.media_url}}"/>
                            </a>
                            <br>
                            <a herf="/ad/detail?ad_id={{item.advertisement_id}}" class="gellary_title">>{{item.title}}</a>
                            <br>
                            <span class="gellary_date">Posted:{{item.created_at}}</span>
                            {{# return true;} }}
                            {{# });}}
                        </li>
                        {{#} }}
                        {{# }); }}
                    </ul>
                </div>

            </div>
        </script>

    @endverbatim
@endsection