@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
<div class="warpper">
    <div class="title"><a href="/admin/user/list?is_firm={{$is_firm}}&currpage={{$currpage}}" class="s-back">返回</a>会员 - 积分日志列表</div>
    <div class="content">

        <div class="flexilist">
            <div class="common-head">

                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$totalcount}}条记录</div>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>

                                <th width="5%"><div class="tDiv">编号</div></th>
                                <th width="10%"><div class="tDiv">余额</div></th>
                                <th width="10%"><div class="tDiv">变更可用余额</div></th>
                                <th width="8%"><div class="tDiv">变更冻结金额</div></th>
                                <th width="8%"><div class="tDiv">变更积分</div></th>
                                <th width="8%"><div class="tDiv">变更时间</div></th>
                                <th width="8%"><div class="tDiv">描述</div></th>
                                <th width="6%"><div class="tDiv">改变类型</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @foreach($info as $vo)
                            <tr class="">

                                <td><div class="tDiv">{{$vo['id']}}</div></td>
                                <td><div class="tDiv">{{$vo['user_money']}}</div></td>
                                <td><div class="tDiv">{{$vo['deposit_fee']}}</div></td>
                                <td><div class="tDiv">{{$vo['frozen_money']}}</div></td>
                                <td><div class="tDiv">{{$vo['points']}}</div></td>
                                <td><div class="tDiv">{{$vo['change_desc']}}</div></td>
                                <td><div class="tDiv">{{$vo['change_type']}}</div></td>

                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="tDiv">

                                        <div class="list-page">
                                            <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->


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
        paginate(1);
        function paginate(curr){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$totalcount}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"    //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            var user_name = $(".user_name").val();
                            window.location.href="/user/list?curr="+obj.curr+"&is_firm={{$is_firm}}";
                        }
                    }
                });
            });
        }

        $('.j_click').click(function(){
                var is_freeze ;
                var user_id = $(this).siblings('input').attr('data-id');
                var input = $(this).siblings('input');
                if (input.val() === '1') {
                    is_freeze = 0;
                } else {
                    is_freeze = 1;
                }

                layui.use(['layer'], function() {
                    layer = layui.layer;
                    $.post("{{url('/user/modify')}}",{"id":user_id,"is_freeze":is_freeze,"_token":$("#_token").val()},function(res){
                        if(res.code==1){
                            layer.msg(res.msg, {icon: 1});
                            input.val(res.data);
                        }else{
                            layer.msg(res.msg, {icon: 5});
                        }
                    },"json");

                });
        });




        //导出会员
        function download_userlist()
        {
            location.href = "/user/export";
        }

    </script>
@stop
