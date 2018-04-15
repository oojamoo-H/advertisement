@extends('admin.layout.app')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">User</a>
        <a><cite>All Users</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <div class="layui-form layui-col-md12 x-so">
                <input type="text"  name="username"  placeholder="Please entry username" autocomplete="off" class="layui-input">
                <button class="layui-btn"  id="search" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </div>

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
                url: BaseUri + API_LIST.GET_ADMIN_USER_LIST,
                page: true,
                cols: [[ //表头
                    {field: 'id', title: 'ID',width : 50},
                    {field: 'username', title: 'Name', width:150},
                    {field: 'password', title: 'Password'},
                    {field: 'nickname', title: 'Nickname', width:150},
                    {field: 'point', title: 'Point', width:100},
                    {field: 'code', title: 'Auth Code', width:100},
                    {field: 'is_active', title:'Active Status', templet: '#isActive', width:120},
                    {field: 'created_at', title: 'Register Time', width:150},
                    {title:'Action', toolbar: '#barDemo'}
                ]]
            });

            table.on('tool(test)', function(obj){
                switch(obj.event){
                    case 'setPoint':
                        layer.open({
                            type: 1,
                            title: 'Alert',
                            closeBtn: false,
                            area: ['300px', '250px'],
                            shade: 0.8,
                            id: 'LAY_layuipro',
                            btn: ['Confirm', 'Cancel'],
                            btnAlign: 'c',
                            moveType: 1 ,
                            content: "<div style='width:100%;padding:20px 0'>" +
                            "<div style='width:90%; margin:0 auto;text-align: center; font-size:18px;'>"+ obj.data.username + "'s Point now is <font color='red' size='20px'>" + (obj.data.point ? obj.data.point : 0) + "</font></div>" +
                            "<div style='width:90%; margin:15px auto;text-align: center; font-size:16px'><input name='point'/></div>" +
                            "</div>",
                            btn1:function (index) {
                                var point = $('input[name="point"]').val();
                                if (point === ''){
                                    alert( 'Please Set Point')
                                    return false;
                                }

                                Ajax.set_point({id: obj.data.id,point:point}, function (res) {
                                    if(res.code === 1){
                                        layer.close(index);
                                        tableReload();
                                    }
                                })
                            },
                        });
                        
                        break;
                    case 'generateCode':
                        generateCode(obj.data, function (res) {
                            if (res.code === 1){
                                layer.confirm(obj.data.username + "'s new auth code is " + "<font color='red'>" + res.data + "</font>", {
                                    title:'Tips!',
                                    btn: ['Ok'],
                                    btn1:function (index) {
                                        layer.close(index)
                                        tableReload()
                                    }
                                });
                            } else {
                                layer.open({
                                    content:res.msg
                                })
                            }
                        });
                        break
                    case 'viewDetail':
                        location.href = '/admin/userDetail?user_id=' + obj.data.id
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
            <a class="layui-btn layui-btn-xs layui-btn-warm set-point"  lay-event="setPoint">Set Point</a>
            <a class="layui-btn layui-btn-xs set-point"  lay-event="generateCode">Generate Code</a>
            <a class="layui-btn layui-btn-xs layui-btn-normal set-point"  lay-event="viewDetail">View</a>
        </script>

        <script type="text/html" id="isActive">
            {{#  if(d.is_active == 1){ }}
            <a class="layui-btn layui-btn-xs set-point" >Yes</a>
            {{#  } else { }}
            <a class="layui-btn layui-btn-xs layui-btn-danger set-point">No</a>
            {{#  } }}
        </script>

    @endverbatim

@endsection