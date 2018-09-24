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
        .carousel-inner{
            height:400px;
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
    <div class="row">
        <divl class="list-unstyled list-inline" id="parent-cities">
            <a href="javascript:;" class="parent-cities">All</a>
        </divl>

    </div>
    <div class="row">
        <divl class="list-unstyled list-inline" id="sub-cities">

        </divl>
    </div>


    <div id="myCarousel" class="carousel slide">



    </div>
    <br>
    <h1 id="area_text" style="line-height: 1.5;color:red;padding-top:10px;">

    </h1>
    <div class="row-fluid">
        <ul class="nav nav-tabs">
            <li class="active" data-index="1"><a href="#identifier1" data-toggle="tab">top</a></li>
            <li data-index="2"><a href="#identifier2" data-toggle="tab">gallery</a></li>
            <li data-index="3"><a href="#identifier3" data-toggle="tab">video</a></li>
            <li data-index="4"><a href="#identifier4" data-toggle="tab">date</a></li>
        </ul>
        <div class="tab-content" id="advertisement-item">

        </div>
    </div>


</div>
    @verbatim
        <script src="/js/home/index_pc.js"></script>
        <script>
            window.onresize = function(){
                var win = $(window).width(),
                    main = $('#u_list');
                if(win < 750){
                    main.hide();
                }else{
                    main.show();
                }
            }
        </script>
        <script type="text/html" id="aside-city">
            <li class="sidebar-brand">
                <a  href="javascript:;"> NearBy</a>
            </li>
            {{# layui.each(d.cities, function(index, item){}}
            <li>
                <a href="javascript:;" data-id="{{ item.id }}" class="aside-parent-cities"><i class="fa fa-fw fa-cog" data-id="{{ item.id }}"></i> {{item.city_name }}</a>
            </li>
            {{#  }); }}
        </script>

        <script type="text/html" id="parent-city">
            {{# layui.each(d.cities, function(index, item){}}
            <span class="spliter">|</span>
            <a class="parent-cities" data-id="{{item.id}}" href="javascript:;">{{item.city_name}}</a>
            {{#  }); }}
        </script>

        <script type="text/html" id="sub-city">
            {{# layui.each(d.sub_cities, function(index, item){}}
            {{# if (index != 0) {}}
            <span class="spliter">|</span>
            {{# } }}
            <a class="sub-cities" data-id="{{item.id}}" href="javascript:;">{{item.city_name}}</a>
            {{#  }); }}
        </script>


        <script type="text/html" id="advertisement">

            <div class="tab-content" id="advertisement-item">
                <div class="tab-pane {{# if(tab==1){}}active{{# } }}" id="identifier1">
                    <div class="col-xs-12 col-sm-9 col-md-10" style="padding-left:0;margin-top: 10px">
                        <div class="list-unstyled list-group">
                            {{# layui.each(d.advertisement_list, function(index, item){}}
                            <a href="/ad/detail?ad_id={{item.advertisement_id}}"  class="list-group-item no-border" data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">
                                {{item.title}}
                            </a>
                            {{# });}}
                        </div>
                    </div>
                    <div id='u_list' class="col-xs-12 col-sm-3 col-md-2"   >
                        {{# layui.each(d.top_advertisement, function(index, item){}}
                        <div class="top_list">
                            <a href="/ad/detail?ad_id={{item.advertisement_id}}">{{item.title}}</a><br>
                            <span>{{cutString(item.content,100)}}</span><br>
                            {{# if (item.image.length > 0){}}
                            <div class="list-unstyled list-inline">
                                {{# layui.each(item.image, function(i, mediaItem){}}
                                {{# if(i >= 3){}}
                                {{# return true;}}
                                {{# } }}
                                <a  href="/ad/detail?ad_id={{item.advertisement_id}}">
                                    <img style="width:40px;" data-preview-group="{{index}}" src="{{mediaItem.media_url}}"/>
                                </a>

                                {{# }); }}
                            </div>
                            {{# } }}
                        </div>
                        {{# }); }}
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

                        {{# if(item.video.length > 0){}}
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
                <div class="tab-pane {{# if(tab==4){}}active{{# } }}" id="identifier4">
                    <div class="list-unstyled list-group">
                        {{# layui.each(d.advertisement_list.reverse(), function(index, item){}}
                        <a href="/ad/detail?ad_id={{item.advertisement_id}}"  class="list-group-item no-border" data-id="{{item.advertisement_id}}" data-user-id="{{item.user_id}}">
                            {{item.title}}
                        </a>
                        {{# });}}
                    </div>
                </div>
            </div>
        </script>


        <script type="text/html" id="vip-advertisement">
            <ol class="carousel-indicators">
                {{# layui.each(d, function(index, item){}}
                <li data-target="#myCarousel" data-slide-to="{{index}}" {{# if (index == 0) {}}class="active"{{# } }}></li>
                {{# }) }}
            </ol>
            <div class="carousel-inner" >
                {{# layui.each(d, function(index, item){}}
                <div class="item {{# if (index == 0) {}}active{{# } }}">
                    <a href="/ad/detail?ad_id={{item.advertisement_id}}">
                    <img style="margin: 0 auto;width:100%;" src="{{item.media_url}}">
                    </a>
                </div>
                {{# }) }}
            </div>
            <a class="carousel-control left" href="#myCarousel" data-slide="prev"> <span _ngcontent-c3="" aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next"><span _ngcontent-c3="" aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span></a>
        </script>

    @endverbatim
@endsection