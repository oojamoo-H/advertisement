@extends('admin.layout.app')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">User</a>
        <a><cite>Advertisement List</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i>
        </a>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right;margin-right:15px" href="javascript:location.href = '/admin/user';" title="返回">
            <i class="layui-icon" style="line-height:30px">&#xe65c;</i>
        </a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <div class="layui-form layui-col-md12 x-so">
                <input type="text"  name="keyword"  placeholder="Please entry keyword" autocomplete="off" class="layui-input">
                <button class="layui-btn"  id="search" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </div>

        <table class="layui-table" id="userTable" lay-filter="test" lay-size="lg">

        </table>

    </div>
    <script>
        var user_id = {{$user}}
        layui.use(['laydate','table', 'layer'], function() {
            var laydate = layui.laydate;
            var table = layui.table;
            var layer = layui.layer

            var tableIns = table.render({
                headers: {
                    'X-SESSION-TOKEN': $(window.parent.document).find('meta[name="session-token"]').attr('content')
                },
                where:{user_id:user_id},
                elem: '#userTable',
                loading: true,
                height: 500,
                url: BaseUri + API_LIST.GET_ADVERTISEMENT_LIST,
                page: true,
                cols: [[ //表头
                    {field: 'id', title: 'ID', width: 50},
                    {field: 'title', title: 'Title', width: 200},
                    {field: 'city_name', title: 'Publish City', width: 100},
                    {field: 'created_at', title: 'Publish Time', width: 150},
                    {field: 'media', title:'Image', templet:'#imagelist'},
                    {title: 'Action',  toolbar: '#action'},
                ]]
            });

            table.on('tool(test)', function(obj){
                var data = obj.data;
                switch(obj.event){
                    case 'viewVideo':
                        if (data.media){
                            var video = ''
                            $.each(data.media, function (i, v) {
                                if (v.media_type == 'video'){
                                    video = v.media_url;
                                    return false
                                }
                            })

                            if (! video){
                                alert('No video resource');
                                return false;
                            }

                            layer.open({
                                type: 2,
                                title: false,
                                area: ['630px', '360px'],
                                shade: 0.8,
                                closeBtn: 0,
                                shadeClose: true,
                                content:video
                            });
                        }

                        break;
                    case 'viewContent':
                        layer.open({
                            type: 1,
                            area: ['630px', '360px'],
                            title: false,
                            closeBtn: 0,
                            shadeClose: true,
                            content: '<p style="padding:20px;font-size:16px;">' + data.content + '</p>'
                        });
                        break;
                    case 'delete':
                        layer.load(2, {shade : 0.8});
                        layer.confirm('Are you sure to delete this ad？', function () {
                            Ajax.delete_advertisement({id : obj.data.id}, function (res) {
                                layer.closeAll('loading');
                                if (res.code === 1){
                                    location.reload()
                                } else {
                                    layer.msg('Deleted Failed', {icon: 2});
                                }
                            })
                        });
                        break;
                }
            });

            $('body').on('click', '#search', function () {
                tableReload()
            })

            function tableReload(){
                tableIns.reload({
                    where:{'keyword': $("input[name='keyword']").val(), user_id : user_id},
                    page:{curr: 1}
                })
            }

            $('body').on('click', '.ad-image', function () {
                var image = $(this);
                console.log(image.prop('src'));
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: '516px',
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: '<img width="100%" src="' + image.prop('src') +'" />'
                })
            })
        })
    </script>

    @verbatim
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs layui-btn-normal set-point"  lay-event="viewMedia">View Media</a>
        </script>

        <script type="text/html" id="imagelist">
            <div style="display: flex;flex-direction: row">
            {{# layui.each(d.media, function(index, item){}}
                {{# if (item.media_type ==='image'){}}
                <img class="ad-image" width="20%" height="20%" src="{{item.media_url}}"/>
                {{# } }}
            {{# })}}
            </div>
        </script>

        <script type="text/html" id="action">
            <a class="layui-btn layui-btn-xs layui-btn-normal set-point"  lay-event="viewVideo">View Video</a>
            <a class="layui-btn layui-btn-xs layui-btn-normal set-point"  lay-event="viewContent">View Content</a>
            <a class="layui-btn layui-btn-xs layui-btn-normal set-point"  lay-event="delete">Delete</a>
        </script>
    @endverbatim
@endsection