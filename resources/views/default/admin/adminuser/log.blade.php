@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/adminuser/list?currpage={{$pcurrpage}}" class="s-back">返回</a>管理员 - 管理员日志列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>管理员日志信息。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">编号</div></th>
                                    <th width="10%"><div class="tDiv">真实姓名</div></th>
                                    <th width="10%"><div class="tDiv">日志时间</div></th>
                                    <th width="10%"><div class="tDiv">IP地址</div></th>
                                    <th width="10%"><div class="tDiv">日志信息</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['real_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['log_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['ip_address']}}</div></td>
                                    <td><div class="tDiv">{{$vo['log_info']}}</div></td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div class="tDiv">

                                            <div class="list-page">

                                                <ul id="page"></ul>

                                                <style>
                                                    .pagination li{
                                                        float: left;
                                                        width: 30px;
                                                        line-height: 30px;}
                                                </style>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/adminuser/log?currpage="+obj.curr+"&id={{$id}}";
                        }
                    }
                });
            });
        }


    </script>
@stop
