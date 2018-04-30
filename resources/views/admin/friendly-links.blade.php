@extends('admin.layout.app')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">System</a>
        <a><cite>FriendlyLindsSeting</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <a class="layui-btn layui-btn-small"  href="javascript:location.href = '/admin/friendlyLinkDetail';" title="create">
            <i class="layui-icon">&#xe654;</i>
        </a>
        <table class="layui-table" id="userTable" lay-filter="test" lay-size="lg">

        </table>

    </div>
    <script>
        layui.use(['laydate','table', 'layer'], function(){
            var laydate = layui.laydate;
            var table = layui.table;
            var layer = layui.layer

            var tableIns = table.render({
                headers:{
                    'X-SESSION-TOKEN' : $(window.parent.document).find('meta[name="session-token"]').attr('content')
                },
                elem: '#userTable',
                loading:true,
                height: 500,
                url: BaseUri + API_LIST.GET_FRIENDLY_LINKS_LIST,
                page: true,
                cols: [[ //表头
                    {field: 'id', title: 'ID',width : 50},
                    {field: 'name', title: 'Name', width:200},
                    {field: 'is_url', title: 'Is Link',templet: '#isLink', width:100},
                    {field: 'url', title: 'Link', width:250},
                    {field: 'sort', title: 'Sort', width:60},
                    {field: 'status', title:'Status', templet: '#status', width:100},
                    {field: 'updated_at', title: 'Update Time', width:150},
                    {title:'Action', toolbar: '#barDemo'}
                ]]
            });

            table.on('tool(test)', function(obj){
                switch(obj.event){
                    case 'edit':
                        location.href = '/admin/friendlyLinkDetail?id=' + obj.data.id
                        break;

                }
            });

            $('body').on('click', '#search', function () {
                    tableReload()
            })

            function tableReload(){
                tableIns.reload({
                    where:{'username': $("input[name='username']").val()},
                    page:{curr: 1}
                })
            }
        });

        function generateCode(data, success){
            Ajax.generate_code({id:data.id}, success)
        }

        function setPoint(data, success){
            Ajax.set_point(data, success);
        }

    </script>
    @verbatim
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs layui-btn-warm set-point"  lay-event="edit">Edit</a>
        </script>

        <script type="text/html" id="isLink">
            {{#  if(d.is_url == 1){ }}
            <a class="layui-btn layui-btn-xs set-point" >Yes</a>
            {{#  } else { }}
            <a class="layui-btn layui-btn-xs layui-btn-danger set-point">No</a>
            {{#  } }}
        </script>

        <script type="text/html" id="status">
            {{#  if(d.status == 1){ }}
            <a class="layui-btn layui-btn-xs set-point" >on</a>
            {{#  } else { }}
            <a class="layui-btn layui-btn-xs layui-btn-danger set-point">off</a>
            {{#  } }}
        </script>
    @endverbatim

@endsection