@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '我的订单')

@section('css')
	<style>
		.reward_table{width: 100%;margin: 0 auto;margin-top: 20px;}
		.order_list_state{height: 37px;line-height: 35px;background-color: #F7F7F7;}
		.order_list_state li{height: 37px;line-height: 35px;width: 85px;text-align: center;float: left;color: #666;cursor: pointer;}
		.order_list_state li a em{margin-left: 3px;color: red;}
		.order_list_state .curr{border-bottom: 2px solid #75b335;color: #75b335;box-sizing: border-box;}

		.data-table-box table.order-table tbody td{padding: 0px;}
		.data-table-box .table-body table.order-table tbody tr:nth-child(even){background-color: #FFFFFF;}
		.order-item-table td{border: 1px solid #DEDEDE;}
		.data-table-box .order-item-table tr:first-child{background-color: #f4f4f4;height: 40px;}
		.data-table-box table.order-item-table tbody td{padding: 8px 10px;}
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
                        d.order_no = $('#order_no').val();
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
                        	var html = '<div style="height: 15px;"></div>';

                            html += '<table class="table table-border table-bordered table-bg table-hover order-item-table">';
                            html += '<tr  class="tal"><td colspan="4"><p class="pl10 fs16">'+ full.status +'</p>';
                            html += '<p><span class="pl10 fl" style="width:30%">订单单号：<a>' + full.order_sn +'</a></span><span class="fl">店铺：'+ full.shop_name +'</span><span class="fr">下单时间：'+ full.add_time +'</span></p></td></tr>';
                            for(var index in full.goods){
                                html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 26px;"><p>'+ full.goods[index].goods_name + '</p><p><span style="float:left;width:50%;">单价：￥' + full.goods[index].goods_price + '</span><span class="pl10">数量：'+ full.goods[index].goods_number+' </span></p></div></td>';
                                if(index == 0){
                                    html += '<td width="20%" rowspan="'+ full.goods.length +'"><p>应付款:￥'+ full.order_amount +'</p><p>已付款：￥'+ full.money_paid +'</p></td>';
                                    html += '<td width="20%" rowspan="'+ full.goods.length +'">';
                                    for(var i in full.deliveries){
                                        html += '<p><img src="{{asset(themePath('/', 'web') .'img/Track_icon.png')}}"> 跟踪 </p>';
                                    }
                                    html += '<p><span><a href="">订单详情</a></span></p></td>';
                                    html += '<td rowspan="'+ full.goods.length +'"><p><button class="opt-btn">去支付</button></p><p class="mt5"><button class="opt-btn">取消</button></p></td>';
                                }
                                html += '</tr>';
                            }
                            html += '</table>';
                            return html;
                        }
                    }
                ]
            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();

            });
        });


        function egis(obj){
            var id = $(obj).parent().siblings('input[type=hidden]').val();
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
                        console.log(data.code);
                        alert('出错,请重试')
                    }
                }
            })
        }

        function cancel(obj){
            var id = $(obj).parent().siblings('input[type=hidden]').val();
            $.ajax({
                url: "/cancel",
                dataType: "json",
                data: {
                    'id':id
                },
                type: "POST",
                success: function (data) {
                    if(data.code){
                        window.location.reload();
                    }else{
                        console.log(data.code);
                        alert('出错,请重试')
                    }
                }
            })
        }
	</script>

@endsection

@section('content')
	<div class="mt20">
		<ul class="order_list_state">
			<li @if(empty($tab_code)) class="curr" @endif><a href="/order/list">所有</a></li>
			<li @if(empty($tab_code)) class="waitApproval" @endif><a href="/order/list?tab_code=waitApproval">待审核<em>2</em></a></li>
			<li @if(empty($tab_code)) class="waitAffirm" @endif><a href="/order/list?tab_code=waitAffirm">待确认<em>2</em></a></li>
			<li @if(empty($tab_code)) class="waitPay" @endif><a href="/order/list?tab_code=waitPay">待付款<em>2</em></a></li>
			<li @if(empty($tab_code)) class="waitSend" @endif><a href="/order/list?tab_code=waitSend">待发货<em>2</em></a></li>
			<li @if(empty($tab_code)) class="waitConfirm" @endif><a href="/order/list?tab_code=waitConfirm">待收货<em>2</em></a></li>
			<li @if(empty($tab_code)) class="finish" @endif><a href="/order/list?tab_code=finish">已完成</a></li>
			<li @if(empty($tab_code)) class="cancel" @endif><a href="/order/list?tab_code=cancel">已取消</a></li>
		</ul>
	</div>

	<div class="data-table-box">
		<div class="table-condition">
			<div class="item">
				<input type="text" class="text" id="order_no" placeholder="订单单号">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="下单时间从">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="下单时间至">
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
				<thead><tr><th style="padding: 0px;"></th></tr></thead>
			</table>
		</div>
	</div>
@endsection
