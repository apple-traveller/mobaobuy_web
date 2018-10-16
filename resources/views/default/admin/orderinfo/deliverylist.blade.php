@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">发货单 - 发货单列表</div>
        <div class="content">


            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>商城和平台所有已发货的订单列表管理。</li>
                    <li>可通过订单号进行查询，侧边栏进行高级搜索。</li>
                    <li>可进入查看取消发货。</li>

                </ul>
            </div>
            <div class="flexilist mt30" id="listDiv">
                <div class="common-head order-coomon-head">

                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/admin/orderinfo/delivery/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="order_sn" value="{{$order_sn}}" class="text nofocus w180" placeholder="订单编号" autocomplete="off">
                                <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                            </div>
                        </form>
                    </div>


                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">发货单流水号</div></th>
                                    <th width="10%"><div class="tDiv">订单号</div></th>
                                    <th width="10%"><div class="tDiv">商家名称</div></th>
                                    <th width="10%"><div class="tDiv">下单时间</div></th>

                                    <th width="5%"><div class="tDiv">收货人</div></th>
                                    <th width="5%"><div class="tDiv">运单号</div></th>
                                    <th width="5%"><div class="tDiv">状态</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deliverys as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['delivery_sn']}}</div></td>
                                        <td><div class="tDiv">{{$vo['order_sn']}}</div></td>
                                        <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['order_add_time']}}</div></td>

                                        <td>
                                            <div class="tDiv">
                                                <div>{{$vo['consignee']}}</div>
                                                <div>{{$vo['mobile_phone']}}</div>
                                            </div>
                                        </td>
                                        <td><div class="tDiv">{{$vo['shipping_billno']}}</div></td>

                                        <td>
                                            <div class="tDiv">
                                                @if($vo['status']==0)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待发货</div>
                                                @else
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius'>已发货</div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/orderinfo/delivery/detail?id={{$vo['id']}}&currpage={{$currpage}}" title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                <a title="删除" class="btn_see"><i class="icon icon-trash"></i>删除</a>
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
                            window.location.href="/admin/orderinfo/delivery/list?currpage="+obj.curr+"&order_sn={{$order_sn}}";
                        }
                    }
                });
            });
        }





    </script>
@stop
