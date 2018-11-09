@extends(themePath('.')."seller.include.layouts.master")
@section('body')
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
                        <a href="/seller/order/list" @if(empty($tab_code)) class="current" @endif>全部订单@if(empty($tab_code)) <em>({{$total}})</em> @endif</a>
                        <a href="/seller/order/list?tab_code=waitAffirm" @if($tab_code=='waitAffirm') class="current" @endif>待确认 <em id="waitAffirm"></em> </a>
                        <a href="/seller/order/list?tab_code=waitPay" @if($tab_code=='waitPay') class="current" @endif>待付款 <em id="waitPay"></em> </a>
                        <a href="/seller/order/list?tab_code=waitSend" @if($tab_code=='waitSend') class="current" @endif>待发货<em id="waitSend"></em> </a>
                        <a href="/seller/order/list?tab_code=finish" @if($tab_code=='finish') class="current" @endif>已完成<em id="finish"></em> </a>
                        <a href="/seller/order/list?tab_code=cancel" @if($tab_code=='cancel') class="current" @endif>已作废 <em id="waitAffirm"></em> </a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)">
                            <i class="icon icon-refresh" style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span" >刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/seller/order/list" name="searchForm" >
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
                                    <th width="10%"><div class="tDiv">订单编号</div></th>
                                    <th width="10%"><div class="tDiv">会员账号</div></th>
                                    <th width="10%"><div class="tDiv">收货人</div></th>
                                    <th width="5%"><div class="tDiv">订单状态</div></th>
                                    <th width="5%"><div class="tDiv">付款状态</div></th>
                                    <th width="5%"><div class="tDiv">发货状态</div></th>
                                    <th width="5%"><div class="tDiv">运费</div></th>
                                    <th width="5%"><div class="tDiv">总金额</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['order_sn']}}</div></td>
                                        <td>
                                            <div class="tDiv">
                                                @foreach($users as $v)
                                                    @if($v['id']==$vo['user_id'])
                                                        {{$v['user_name']}}
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td><div class="tDiv"><div>{{$vo['consignee']}}</div><div>{{$vo['mobile_phone']}}</div><div>{{$vo['address']}}</div></div></td>
                                        <td>
                                            <div class="tDiv">
                                                @if($vo['order_status']==0)已作废
                                                @elseif($vo['order_status']==1)待企业审核
                                                @elseif($vo['order_status']==2)待商家确认
                                                @else已确认
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tDiv">
                                                @if($vo['pay_status']==0)待付款
                                                @elseif($vo['pay_status']==1)已付款
                                                @else部分付款
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <div class="tDiv">
                                                @if($vo['shipping_status']==0)待发货
                                                @elseif($vo['shipping_status']==1)已发货
                                                @elseif($vo['shipping_status']==2)部分发货
                                                @endif
                                            </div>
                                        </td>
                                        <td><div class="tDiv">{{$vo['shipping_fee']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_amount']}}</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/seller/order/detail?id={{$vo['id']}}&currentPage={{$currentPage}}"  title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                @if($tab_code=='waitAffirm')
                                                <a href="javascript:void(0);" onclick="conf({{ $vo['id'] }})"  title="确认" class="btn_see"><i class="sc_icon sc_icon_see"></i>确认</a>
                                                @elseif($tab_code=='waitPay')
                                                    <a href="javascript:void(0);"  title="确认收款" onclick="receiveM({{ $vo['id'] }})" class="btn_see"><i class="sc_icon sc_icon_see"></i>确认收款</a>
                                                @elseif($tab_code=='waitSend')
                                                    <a href="/seller/order/delivery?order_id={{$vo['id']}}&currentPage={{$currentPage}}"  title="发货" class="btn_see"><i class="sc_icon sc_icon_see"></i>发货</a>
                                                @endif
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
        // window.location.reload();
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currentPage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/seller/order/list?currentPage="+obj.curr+"&tab_code={{$tab_code}}";
                        }
                    }
                });
            });
        }
        $.ajax({
            url:'/seller/order/getStatusCount',
            data:'',
            type:'POST',
            success:function (result) {
                if (result.code == 1) {
                    var status = result.data;
                    if(status.waitAffirm > 0){
                        $('#waitAffirm').html(status.waitAffirm);
                    }
                    if(status.waitPay > 0){
                        $('#waitPay').html(status.waitPay);
                    }
                    if(status.waitSend > 0){
                        $('#waitSend').html(status.waitSend);
                    }
                }
            }
        })

        // 确认订单
        function conf(id)
        {
            layui.use('layer', function(){
                let index = parent.layer.getFrameIndex(window.name);
                parent.layer.iframeAuto(index);
                let layer = layui.layer;
                    layer.prompt({
                        title: '确认订单,并输入交货日期',
                    }, function(value, index, elem){


                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'action_note':action_note,
                            'order_status': 3,
                            'delivery_period':value
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:2000});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                            setTimeout( window.location.href="/seller/order/list?id="+id,3000)
                        }
                    });

                    layer.close(index);
                });
            });
        }
        // 确认收款
        function receiveM(id) {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认收到付款?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'action_note':action_note,
                            'pay_status': 1
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:600});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                });
            });
        }
    </script>
@stop
