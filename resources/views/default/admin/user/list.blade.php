@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
<div class="warpper">
    <div class="title">会员 - 会员列表</div>
    <div class="content">

        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出会员列表"><span><i class="icon icon-download-alt"></i>导出会员列表</span></div></div></a>
                </div>

                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$userCount}}条记录</div>
                </div>

                <div class="search">
                    <form action="/user/list" name="searchForm" >
                        <div class="input">
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <input id="_token" type="hidden" name="is_firm" value="{{$is_firm}}"/>
                            <input type="text" value="{{$user_name}}" name="user_name" class="text nofocus user_name" placeholder="会员名称" autocomplete="off">
                            <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>

                                <th width="5%"><div class="tDiv">编号</div></th>
                                <th width="10%"><div class="tDiv">用户名</div></th>
                                <th width="10%"><div class="tDiv">昵称</div></th>
                                <th width="8%"><div class="tDiv">是否实名</div></th>
                                <th width="8%"><div class="tDiv">积分</div></th>
                                <th width="8%"><div class="tDiv">注册时间</div></th>
                                <th width="8%"><div class="tDiv">访问次数</div></th>

                                <th width="6%"><div class="tDiv">状态(灰色为冻结)</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @foreach($users as $user)
                            <tr class="">

                                <td><div class="tDiv">{{$user['id']}}</div></td>
                                <td><div class="tDiv">{{$user['user_name']}}</div></td>
                                <td><div class="tDiv">{{$user['nick_name']}}</div></td>
                                <td><div class="tDiv">
                                        @if($user['userreal']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已实名</div>
                                        @elseif($user['userreal']==0)<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待审核</div>
                                        @else<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-danger'>待实名</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="tDiv">
                                        <a href="/user/points?id={{$user['id']}}&is_firm={{$user['is_firm']}}" class="layui-btn layui-btn-normal">{{$user['points']}}</a>
                                    </div>
                                </td>
                                <td><div class="tDiv">{{$user['reg_time']}}</div></td>
                                <td><div class="tDiv">{{$user['visit_count']}}</div></td>

                                <td>

                                    <label class="el-switch el-switch-lg">
                                        <input type="checkbox" @if($user['is_freeze']==0)checked @endif  name="switch" value="{{$user['is_freeze']}}"  data-id="{{$user['id']}}"   hidden>
                                        <span class="j_click el-switch-style"></span>
                                    </label>

                                </td>

                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="{{url('/user/detail')}}?id={{$user['id']}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="{{url('/user/log')}}?id={{$user['id']}}&is_firm={{$user['is_firm']}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="{{url('/user/verifyForm')}}?id={{$user['id']}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>审核</a>
                                        <a href="{{url('/user/userRealForm')}}?id={{$user['id']}}&is_firm={{$user['is_firm']}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>实名审核</a>
                                    </div>
                                </td>
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
                    , count: "{{$userCount}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            var user_name = $(".user_name").val();
                            window.location.href="/user/list?curr="+obj.curr+"&user_name="+user_name;
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
