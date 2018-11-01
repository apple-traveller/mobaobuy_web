@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">发票 - 发票申请列表</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
            </ul>
        </div>
        <div class="flexilist">

            <div class="common-head">

                <div class="order_state_tab">
                    <a href="/admin/demand/list?action_state=-1" @if($action_state==-1) class="current" @endif>全部@if($action_state==-1) <em>({{$total}})</em> @endif </a>
                    <a href="/admin/demand/list?action_state=0"  @if($action_state==0) class="current" @endif>待处理@if($action_state==0) <em>({{$total}})</em> @endif </a>
                    <a href="/admin/demand/list?action_state=1"  @if($action_state==1) class="current" @endif>已处理@if($action_state==1) <em>({{$total}})</em> @endif </a>
                </div>

                <div  class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                </div>
                <div class="search">
                    <form action="/admin/demand/list" name="searchForm" method="post" >
                        <div class="input">
                            <input type="text" id="test" name="add_time" placeholder="根据时间选择" value="{{$add_time}}" class="text nofocus goods_name" placeholder="商品名称" autocomplete="off">
                            <input type="submit" class="btn"  ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv" data-id="">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="10%"><div class="tDiv">编号</div></th>
                                <th width="10%"><div class="tDiv">昵称</div></th>
                                <th width="10%"><div class="tDiv">联系方式</div></th>
                                <th width="10%"><div class="tDiv">状态</div></th>
                                <th width="10%"><div class="tDiv">添加时间</div></th>
                                <th width="18%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @if(!empty($demand))
                            @foreach($demand as $vo)
                            <tr class="">
                                <td><div class="tDiv">{{$vo['id']}}</div></td>
                                <td><div class="tDiv">{{$vo['nick_name']}}</div></td>
                                <td><div class="tDiv">{{$vo['contact_info']}}</div></td>
                                <td>
                                    <div class="tDiv">
                                        @if($vo['action_state']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已处理</div>
                                        @else<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-primary'>待处理</div>
                                        @endif
                                    </div>
                                </td>
                                <td><div class="tDiv">{{$vo['created_at']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="{{url('/admin/demand/detail')}}?id={{$vo['id']}}&currpage={{$currpage}}&action_state={{$action_state}}" class="btn_see">
                                            <i class="sc_icon sc_icon_see"></i>
                                            @if($vo['action_state']==1)
                                                查看
                                            @else
                                                去处理
                                            @endif
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @else
                                <tr class=""> <td style="color:red;">未查询到数据</td></tr>
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
                    elem: 'page' //注意，这里是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/invoice/list?currpage="+obj.curr;
                        }
                    }
                });
            });
        }

        $(function(){
            layui.use(['laydate'], function() {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#test'
                    ,range: true //或 range: '~' 来自定义分割字符
                });
            });
        });

    </script>
@stop
