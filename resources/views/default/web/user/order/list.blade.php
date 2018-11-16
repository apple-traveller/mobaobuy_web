@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '我的订单')

@section('css')
	<style>
		.order_list_state{height: 37px;line-height: 35px;background-color: #F7F7F7;}
		.order_list_state li{height: 37px;line-height: 35px;width: 85px;text-align: center;float: left;color: #666;cursor: pointer;}
		.order_list_state li a em{margin-left: 3px;color: red;}
		.order_list_state .curr{border-bottom: 2px solid #75b335;color: #75b335;box-sizing: border-box;}
		.data-table-box table.order-table tbody td{padding: 0px;}
		.data-table-box .table-body table.order-table tbody tr:nth-child(even){background-color: #FFFFFF;}
		.order-item-table td{border: 1px solid #DEDEDE;}
		.data-table-box .order-item-table tr:first-child{background-color: #f4f4f4;height: 40px;}
		.data-table-box table.order-item-table tbody td{padding: 8px 10px;}
        .data-table-box .table-body .opt-btn {
    width: 87px;
    height: 24px;
    line-height: 24px;
    padding: 2px 10px;
    background-color: #75b335;
    border-radius: 3px;
    cursor: pointer;
    border: 0px;
    color: #fff;display: inline-block;float: none;margin-top: 10px;
}
	</style>
@endsection

@section('js')
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
	<script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('order/list')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.tab_code = '{{$tab_code}}',
                        d.order_no = $('#order_no').val(),
                        d.begin_time = $('#begin_time').val(),
                        d.end_time = $('#end_time').val()
                    },
                    dataSrc:
                        function (json) {
                            json.draw = json.data.draw;
                            if (json.data.recordsTotal == null) {
                                json.recordsTotal = 0;
                            }else{
                                json.recordsTotal = json.data.recordsTotal;
                            }
                            json.recordsFiltered = json.data.recordsFiltered;

                            return json.data.data;
                        },
                },
                "columns": [
                    {"data": "id", "bSortable": false,
                        "render": function (data, type, full, meta) {
                             console.log(full);
                        	var html = '<div style="height: 15px;"></div>';

                            html += '<table class="table table-border table-bordered table-bg table-hover order-item-table">';
                            html += '<tr  class="tal"><td colspan="4"><p class="pl10 fs16">'+ full.status +'</p>';
                            html += '<p><span class="pl10 fl" style="width:30%">订单单号：<a>' + full.order_sn +'</a></span><span class="fl">店铺：'+ full.shop_name +'</span><span class="fr">下单时间：'+ full.add_time +'</span></p></td></tr>';
                            for(var index in full.goods){
                                html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 26px;"><p>'+ full.goods[index].goods_name + '</p><p><span style="float:left;width:50%;">单价：￥' + full.goods[index].goods_price + '</span><span class="pl10">数量：'+ full.goods[index].goods_number+' </span></p></div></td>';
                                if(index == 0){
                                    html += '<td width="20%" rowspan="'+ full.goods.length +'"><p>应付款：￥'+ full.order_amount +'</p><p>已付款：￥'+ full.money_paid +'</p></td>';
                                    html += '<td width="20%" rowspan="'+ full.goods.length +'">';
                                    for(var i in full.deliveries){
                                        console.log(full.deliveries);
                                        html += '<p><img class="track-tooltip" data-id='+ full.deliveries[i].id +' data-name="'+ full.deliveries[i].shipping_name +'" data-code="'+ full.deliveries[i].shipping_billno +'" src="{{asset(themePath('/', 'web') .'img/Track_icon.png')}}"> 跟踪 </p>';
                                    }
                                    html += '<p><span><a href="/orderDetails/'+full.order_sn+'">订单详情</a></span></p></td>';
                                    html += '<td rowspan="'+ full.goods.length +'">';
                                   
                                    // if(full.order_status == 0){
                                    //      html += '<p></p><p class="mt5"><a class="opt-btn" onclick="orderDel('+full.id+')">删除</a></p></td>';
                                    // }else{
                                    //      html += '<p><a href="{{url('payment')}}?order_id='+ full.id +'" class="opt-btn">去支付</a></p><p class="mt5"><a class="opt-btn" onclick="orderCancel('+full.id+')">取消</a></p></td>';
                                    // }
                                    var strhtml = '';
                                    for(var i in full.auth){
                                        strhtml += '<p><a class="opt-btn" '+ full.auth_html[i] +'>'+ full.auth_desc[i]+'</a></p>';
                                    }
                                    html += strhtml + '</td>';
                                  
                                }
                                html += '</tr>';
                            }
                            html += '</table>';
                            return html;
                        }
                    }
                ]
            });

            Ajax.call("{{url('order/status')}}", [] , function(result) {
                if (result.code == 1) {
                    var status = result.data;
                    if(status.waitApproval > 0){
                        $('#waitApproval').html(status.waitApproval);
                    }
                    if(status.waitAffirm > 0){
                        $('#waitAffirm').html(status.waitAffirm);
                    }
                    if(status.waitPay > 0){
                        $('#waitPay').html(status.waitPay);
                    }
                    if(status.waitSend > 0){
                        $('#waitSend').html(status.waitSend);
                    }
                    if(status.waitConfirm > 0){
                        $('#waitConfirm').html(status.waitConfirm);
                    }
                }
            }, "POST", "JSON");

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();

            });
        });

        //审批通过
        function orderApproval(id){
            $.msg.confirm('是否确认审批通过？',
                function () {
                    $.ajax({
                        url: "/egis",
                        dataType: "json",
                        data: {
                            'id':id
                        },
                        type: "POST",
                        success: function (data) {
                            if(data.code){
                                window.location.reload();
                            }else{
                                $.msg.error(data.msg);
                            }
                        }
                    })
                },
                function(){

                }
            )
        }
        
        //订单取消
        function orderCancel(id){
            $.msg.confirm('是否确认取消？',
                function () {
                    $.ajax({
                        url: "/orderCancel",
                        dataType: "json",
                        data: {
                            'id':id
                        },
                        type: "POST",
                        success: function (data) {
                            if(data.code){
//                            $.msg.alert();
                                $.msg.tips('取消成功');
                                window.location.reload();
                            }else{
                                $.msg.error(data.msg);
                            }
                        }
                    })
                },
                function(){

                }
            )
        }

        //订单删除
        function orderDel(id){
            $.msg.confirm('是否确认删除？',
                function () {
                    $.ajax({
                        url: "/orderDel",
                        dataType: "json",
                        data: {
                            'id':id
                        },
                        type: "POST",
                        success: function (data) {
                            if(data.code){
                                window.location.reload();
                            }else{
                                $.msg.error(data.msg);
                            }
                        }
                    })
                },
                function(){

                }
            )
        }

        //确认收货
        function confirmTake(id){
            $.msg.confirm('是否确认收货？',
                function () {
                    $.ajax({
                        url: "/orderConfirmTake",
                        dataType: "json",
                        data: {
                            'id':id
                        },
                        type: "POST",
                        success: function (data) {
                            if(data.code){
                                window.location.reload();
                            }else{
                                $.msg.alert(data.msg);
                            }
                        }
                    })
                },
                function(){

                }
            )
        }
	</script>

@endsection

@section('content')
	<div class="mt20">
		<ul class="order_list_state">
			<li @if(empty($tab_code)) class="curr" @endif><a href="/order/list">所有</a></li>
            @if(session('_curr_deputy_user')['is_self'] == 1 && session('_curr_deputy_user')['is_firm'] == 0)
            @else
            <li @if($tab_code == 'waitApproval') class="curr" @endif><a href="/order/list?tab_code=waitApproval">待审核<em id="waitApproval"></em></a></li>
            @endif
			<li @if($tab_code == 'waitAffirm') class="curr" @endif><a href="/order/list?tab_code=waitAffirm">待确认<em id="waitAffirm"></em></a></li>
			<li @if($tab_code == 'waitPay') class="curr" @endif><a href="/order/list?tab_code=waitPay">待付款<em id="waitPay"></em></a></li>
			<li @if($tab_code == 'waitSend') class="curr" @endif><a href="/order/list?tab_code=waitSend">待发货<em id="waitSend"></em></a></li>
			<li @if($tab_code == 'waitConfirm') class="curr" @endif><a href="/order/list?tab_code=waitConfirm">待收货<em id="waitConfirm"></em></a></li>
			<li @if($tab_code == 'waitInvoice') class="curr" @endif><a href="/order/list?tab_code=waitInvoice">待开票</a></li>
			<li @if($tab_code == 'finish') class="curr" @endif><a href="/order/list?tab_code=finish">已完成</a></li>
			<li @if($tab_code == 'cancel') class="curr" @endif><a href="/order/list?tab_code=cancel">已取消</a></li>
		</ul>
	</div>

	<div class="data-table-box">
		<div class="table-condition">
			<div class="item">
				<input type="text" class="text" id="order_no" placeholder="订单单号">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="下单时间从">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="下单时间至">
			</div>
			<button id="on-search" class="search-btn">查询</button>
		</div>

		<div class="table-body">
			<table class="table table-border table-bordered table-bg table-hover dataTable" style="border: 1px solid #DEDEDE;">
				<thead>
                    <tr>
                        <th width="40%">商品信息</th>
                        <th width="20%">订单金额</th>
                        <th width="20%">物流跟踪</th>
                        <th>状态</th>
                    </tr>
				</thead>
			</table>

			<table id="data-table" class="table table-border table-bordered table-bg table-hover dataTable order-table" >
				<thead>
                    <tr><th style="padding: 0px;"></th></tr>
                </thead>
			</table>
		</div>
	</div>
@endsection
