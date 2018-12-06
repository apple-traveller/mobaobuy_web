@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">合同列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>商城所有的订单列表。</li>
                    <li>点击订单号即可进入详情页面对订单进行操作。</li>
                </ul>
            </div>
            <div class="flexilist mt30" id="listDiv">
                <div class="common-head order-coomon-head">
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        {{--<form action="/admin/contract/list" name="searchForm" >--}}
                            {{--<div class="input">--}}
                                {{--<input type="text" name="order_sn" value="{{$order_sn}}" class="text nofocus w180" placeholder="订单编号" autocomplete="off">--}}
                                {{--<input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    </div>


                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">添加时间</div></th>
                                    <th width="10%"><div class="tDiv">来源</div></th>
                                    <th width="10%"><div class="tDiv">来源名称</div></th>
                                    <th width="10%"><div class="tDiv">订单号</div></th>
                                    <th width="10%"><div class="tDiv">IP地址</div></th>
                                    <th width="30%"><div class="tDiv">上传设备信息</div></th>
                                    <th width="10%"><div class="tDiv">合同</div></th>
                                    <th width="10%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr class="">
                                        <td><div class="tDiv">{{$value['add_time']}}</div></td>
                                        <td><div class="tDiv">{{getFromInfo($value['from'])}}</div></td>
                                        <td><div class="tDiv">{{$value['order_sn']}}</div></td>
                                        <td><div class="tDiv">{{$value['order_sn']}}</div></td>
                                        <td><div class="tDiv">{{$value['ip']}}</div></td>
                                        <td><div class="tDiv">{{$value['equipment']}}</div></td>
                                        <td><div class="tDiv">{{$value['contract']}}</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/orderinfo/detail?id={{$vo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}"  title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
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
                            window.location.href="/admin/orderinfo/list?currpage="+obj.curr+"&order_status={{$order_status}}"+"&order_sn={{$order_sn}}";
                        }
                    }
                });
            });
        }
    </script>
@stop
