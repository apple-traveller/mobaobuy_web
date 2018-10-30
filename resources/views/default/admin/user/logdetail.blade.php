@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?review_status={{$review_status}}&currpage={{$pcurrpage}}" class="s-back">返回</a>会员 - 操作记录</div>
        <div class="content">

            <div class="flexilist">
                <!--商品分类列表-->
                <div class="common-head">
                    <div class="refresh ml0">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$logCount}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" >
                        <div class="list-div" id="listDiv">

                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>

                                    <th width="5%"><div class="tDiv">编号</div></th>
                                    <th width="30%"><div class="tDiv">操作时间</div></th>
                                    <th width="30%"><div class="tDiv">操作类型</div></th>
                                    <th width="12%"><div class="tDiv">IP地址</div></th>

                                </tr>
                                </thead>
                                <tbody>
                                @if($logCount==0)
                                <tr class=""><td class="no-records" colspan="12">没有找到任何记录</td></tr>
                                @else
                                    @foreach($logs as $log)
                                    <tr class="">

                                        <td><div class="tDiv">{{$log['id']}}</div></td>
                                        <td><div class="tDiv">{{$log['log_time']}}</div></td>
                                        <td><div class="tDiv">{{$log['log_info']}}</div></td>
                                        <td><div class="tDiv">{{$log['ip_address']}}</div></td>

                                    </tr>
                                    @endforeach
                                @endif
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
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$logCount}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/user/log?currpage="+obj.curr+"&id={{$id}}"+"&review_status={{$review_status}}"+"&pcurrpage={{$pcurrpage}}";
                        }
                    }
                });
            });
        }
    </script>
@stop
