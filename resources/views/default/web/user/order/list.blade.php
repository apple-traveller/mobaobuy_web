@extends(themePath('.','web').'web.include.layouts.member')
@section('title', trans('home.my_order'))

@section('css')
	<style>
		.order_list_state{height: 37px;line-height: 35px;background-color: #F7F7F7;}
		.order_list_state li{height: 37px;line-height: 35px;width: 82px;text-align: center;float: left;color: #666;cursor: pointer;}
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
            var locale = '{{App::getLocale()}}';
            tbl = $('#data-table').dataTable({
                language: {
                    "sProcessing": "{{trans('home.sProcessing')}}",
                    "sZeroRecords": "{{trans('home.sZeroRecords')}}",
                    "sEmptyTable": "{{trans('home.sEmptyTable')}}",
                    "sLoadingRecords": "{{trans('home.sLoadingRecords')}}",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "{{trans('home.sFirst')}}",
                        "sPrevious": "{{trans('home.sPrevious')}}",
                        "sNext": "{{trans('home.sNext')}}",
                        "sLast": "{{trans('home.sLast')}}"
                    },
                },
                "iDisplayLength" : 5, //默认显示的记录数
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
                        	var html = '<div style="height: 15px;"></div>';

                            html += '<table class="table table-border table-bordered table-bg table-hover order-item-table">';
                            html += '<tr  class="tal"><td colspan="4"><p class="pl10 fs16"><span class="pl10 fl" style="width:50%">'+ full.status +'</span>';
                            if(full.contract){
                                html += '<span class="pr10 fr"><a href="'+full.contract+'" target="_blank">{{trans('home.view_contract')}}</a></span></p>';
                            }
                            html += '</p>';

                            html += '<p style="clear: both;"><span class="pl10 fl" style="width:30%">{{trans('home.order_number')}}：<a>' + full.order_sn +'</a></span><span class="fl">{{trans('home.shop_name')}}：'+ jqGetLangData(locale,full,'shop_name') +'</span><span class="fr">{{trans('home.order_time')}}：'+ full.add_time +'</span></p></td></tr>';
                            for(var index in full.goods){
                                html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 26px;">';
                                html += '<p>'+ full.goods[index].goods_name + '</p><p>';
                                if(full.order_status == 2 && full.deposit_status == 0 && full.extension_code == 'wholesale'){
                                    html += '<span style="float:left;width:50%;">{{trans('home.exceed')}}：￥' + full.goods[index].goods_price + '</span>';
                                }else{
                                    html += '<span style="float:left;width:50%;">{{trans('home.price')}}：￥' + full.goods[index].goods_price + '</span>';
                                }

                                html += '<span class="pl10">{{trans('home.num')}}：'+ full.goods[index].goods_number+' kg</span></p></div></td>';
                                if(index == 0){
                                    html += '<td width="20%" rowspan="'+ full.goods.length +'">';
                                    if(full.order_status == 2 && full.deposit_status == 0){
                                        html +='<p>{{trans('home.amount_to_be_paid')}}：￥'+ full.deposit +'</p>';
                                    }else{
                                        html +='<p>{{trans('home.total_payable')}}：￥'+ full.order_amount +'</p><p>{{trans('home.amount_paid')}}：￥'+ full.money_paid +'</p>';
                                    }

                                    html += '</td><td width="20%" rowspan="'+ full.goods.length +'">';
                                    {{--for(var i in full.deliveries){--}}
                                        {{--console.log(full.deliveries);--}}
                                        {{--html += '<p><img class="track-tooltip" data-id='+ full.deliveries[i].id +' data-name="'+ full.deliveries[i].shipping_name +'" data-code="'+ full.deliveries[i].shipping_billno +'" src="{{asset(themePath('/', 'web') .'img/Track_icon.png')}}"> 跟踪 </p>';--}}
                                    {{--}--}}
                                    html += '<p><span><a href="/orderDetails/'+full.order_sn+'">{{trans('home.order_details')}}</a></span></p></td>';
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
                    if(status.waitInvoice > 0){
                        $('#waitInvoice').html(status.waitInvoice);
                    }
                    if(status.waitDeposit > 0){
                        $('#waitDeposit').html(status.waitDeposit);
                    }
                    if(status.allOrder > 0){
                        $('#allOrder').html(status.allOrder);
                    }
                    if(status.invoiceIng > 0){
                        $('#invoiceIng').html(status.invoiceIng);
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
            $.msg.confirm('{{trans('home.is_confirm_audit_pass')}}？',
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
        function orderCancel(id,waitAffirm){
            $.msg.confirm('{{trans('home.is_confirm_cancel')}}？',
                function () {
                    $.ajax({
                        url: "/orderCancel",
                        dataType: "json",
                        data: {
                            'id':id,
                            'waitAffirm':waitAffirm
                        },
                        type: "POST",
                        success: function (data) {
                            if(data.code){
//                            $.msg.alert();
                                $.msg.tips('{{trans('home.cancel_success_tips')}}');
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
            $.msg.confirm('{{trans('home.is_delete')}}？',
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
            $.msg.confirm('{{trans('home.is_confirm_receipt')}}？',
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
			<li @if(empty($tab_code)) class="curr" @endif><a href="/order/list">{{trans('home.all_status')}}<em id="allOrder"></em></a></li>
            <li @if($tab_code == 'waitDeposit') class="curr" @endif><a href="/order/list?tab_code=waitDeposit">{{trans('home.deposit_payable')}}<em id="waitDeposit"></em></a></li>
            @if(session('_curr_deputy_user')['is_firm'] == 1)
                <li @if($tab_code == 'waitApproval') class="curr" @endif><a href="/order/list?tab_code=waitApproval">{{trans('home.wait_audit')}}<em id="waitApproval"></em></a></li>
            @endif

			<li @if($tab_code == 'waitAffirm') class="curr" @endif><a href="/order/list?tab_code=waitAffirm">{{trans('home.wait_affirm')}}<em id="waitAffirm"></em></a></li>
			<li @if($tab_code == 'waitPay') class="curr" @endif><a href="/order/list?tab_code=waitPay">{{trans('home.wait_pay')}}<em id="waitPay"></em></a></li>
			<li @if($tab_code == 'waitSend') class="curr" @endif><a href="/order/list?tab_code=waitSend">{{trans('home.wait_shipped')}}<em id="waitSend"></em></a></li>
			<li @if($tab_code == 'waitConfirm') class="curr" @endif><a href="/order/list?tab_code=waitConfirm">{{trans('home.wait_confirm')}}<em id="waitConfirm"></em></a></li>
            <li @if($tab_code == 'waitInvoice') class="curr" @endif><a href="/order/list?tab_code=waitInvoice">{{trans('home.wait_open_ticket')}}<em id="waitInvoice"></em></a></li>
            <li @if($tab_code == 'invoiceIng') class="curr" @endif><a href="/order/list?tab_code=invoiceIng">{{trans('home.invoicing')}}<em id="invoiceIng"></em></a></li>
			<li @if($tab_code == 'finish') class="curr" @endif><a href="/order/list?tab_code=finish">{{trans('home.completed')}}</a></li>
			<li @if($tab_code == 'cancel') class="curr" @endif><a href="/order/list?tab_code=cancel">{{trans('home.cancelled')}}</a></li>
		</ul>
	</div>

	<div class="data-table-box">
		<div class="table-condition">
			<div class="item">
				<input type="text" class="text" id="order_no" placeholder="{{trans('home.order_number')}}">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="{{trans('home.start_time')}}">
			</div>
			<div class="item">
				<input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="{{trans('home.end_time')}}">
			</div>
			<button id="on-search" class="search-btn">{{trans('home.query')}}</button>
		</div>

		<div class="table-body">
			<table class="table table-border table-bordered table-bg table-hover dataTable" style="border: 1px solid #DEDEDE;">
				<thead>
                    <tr>
                        <th width="40%">{{trans('home.product_info')}}</th>
                        <th width="20%">{{trans('home.order_amount')}}</th>
                        <th width="20%">{{trans('home.logistics_tracking')}}</th>
                        <th>{{trans('home.status')}}</th>
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
