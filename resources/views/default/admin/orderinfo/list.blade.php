@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">订单 - 订单列表</div>
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
                    <div class="order_state_tab">
                        <a href="/admin/orderinfo/list?order_status=-1" @if($order_status==-1) class="current" @endif>全部订单<em>({{$status['total']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=1" @if($order_status==1) class="current" @endif>待企业审核<em>({{$status['waitApproval']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=2" @if($order_status==2) class="current" @endif>待商家确认<em>({{$status['waitAffirm']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=11" @if($order_status==11) class="current" @endif>待会员付款<em>({{$status['waitPay']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=10" @if($order_status==10) class="current" @endif>待商家发货<em>({{$status['waitSend']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=12" @if($order_status==12) class="current" @endif>待收货<em>({{$status['waitConfirm']}})</em></a>
                        <a href="/admin/orderinfo/list?order_status=5" @if($order_status==5) class="current" @endif>待开票<em>({{$status['waitInvoice']}})</em></a>
                        {{--<a href="/admin/orderinfo/list?order_status=-3" @if($order_status==-3) class="current" @endif>已收货@if($order_status==-3) <em>({{$total}})</em> @endif</a>--}}
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/admin/orderinfo/list" name="searchForm" >
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
                                    <th width="10%"><div class="tDiv">下单时间</div></th>
                                    <th width="10%"><div class="tDiv">订单编号</div></th>
                                    <th width="10%"><div class="tDiv">会员账号</div></th>
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="10%"><div class="tDiv">收货信息</div></th>
                                    <th width="10%"><div class="tDiv">订单状态</div></th>
                                    <th width="5%"><div class="tDiv">来源</div></th>
                                    <th width="5%"><div class="tDiv">总金额</div></th>
                                    <th width="10%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($orders))
                                @foreach($orders as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                        <td><div class="tDiv">{{$vo['order_sn']}}</div></td>
                                        <td>
                                            <div class="tDiv">
                                                <div>{{$vo['trade_user']['user_name']}}</div>
                                                <div>{{$vo['trade_user']['nick_name']}}</div>
                                            </div>
                                        </td>
                                        <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                        <td><div class="tDiv"><div>{{$vo['consignee']}}</div><div>{{$vo['mobile_phone']}}</div><div>{{$vo['address']}}</div></div></td>
                                        <td><div class="tDiv">{{$vo['_status']}}</div></td>
                                        <td>
                                            <div class="tDiv">
                                                <div>
                                                    @if($vo['froms']=="pc")
                                                        PC
                                                    @elseif($vo['froms']=="weichat")
                                                        小程序
                                                    @endif
                                                </div>
                                                <div>
                                                    @if($vo['extension_code']=="wholesale")
                                                        集采火拼
                                                    @elseif($vo['extension_code']=="consign")
                                                        清仓特卖
                                                    @elseif($vo['extension_code']=="promote")
                                                        限时抢购
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="tDiv">￥{{$vo['order_amount']}}</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/orderinfo/detail?id={{$vo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}"  title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                @if($order_status==5)
                                                    <a href="/admin/orderinfo/applyInvoice?id={{$vo['id']}}&currpage={{$currpage}}&order_status={{$order_status}}"  title="申请开票" class="btn_see"><i class="sc_icon sc_icon_see"></i>申请开票</a>
                                                @endif
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
