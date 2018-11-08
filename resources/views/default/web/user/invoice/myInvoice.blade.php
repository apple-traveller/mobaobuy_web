@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '我的开票')

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

@section('content')
    <div class="mt20">
        <ul class="order_list_state">
            <li @if(empty($tab_code)) class="curr" @endif><a href="/invoice/myInvoice">所有</a></li>
            <li @if($tab_code == 'waitInvoice') class="curr" @endif><a href="/invoice/myInvoice?tab_code=waitInvoice">待开票<em id="waitInvoice"></em></a></li>
            <li @if($tab_code == 'Completed') class="curr" @endif><a href="/invoice/myInvoice?tab_code=Completed">已开票<em id="Completed"></em></a></li>
        </ul>
    </div>

    <div class="data-table-box">
        <div class="table-condition">
            <div class="item">
                <input type="text" class="text" id="invoice_numbers" placeholder="开票流水号">
            </div>
            <div class="item">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="申请时间从">
            </div>
            <div class="item">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="申请时间至">
            </div>
            <button id="on-search" class="search-btn">查询</button>
            <a href="/invoice"><button class="search-btn">新增开票</button></a>
        </div>

        <div class="table-body">
            <table class="table table-border table-bordered table-bg table-hover dataTable" style="border: 1px solid #DEDEDE;">
                <thead>
                <tr>
                    <th width="40%">开票信息</th>
                    <th width="20%">开票金额</th>
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
@section('js')
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('invoice/myInvoice')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.tab_code = '{{$tab_code}}',
                            d.invoice_numbers = $('#invoice_numbers').val(),
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
                            html += '<tr  class="tal"><td colspan="4">';
                            html += '<p><span class="pl10 fl" style="width:30%">开票流水号：<a>' + full.invoice_numbers +'</a></span><span class="fl">店铺：'+ full.shop_name +'</span><span class="fr">下单时间：'+ full.created_at +'</span></p></td></tr>';

                            html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 26px;"><p><span style="float:left;width:50%;">订单数量：' + full.order_quantity + '</span></p></div></td>';

                            html += '<td width="20%"><p>发票总金额:￥'+ full.invoice_amount +'</p></td>';
                            html += '<td width="20%"><p><span><a href="/invoiceDetail/'+full.id+'">订单详情</a></span></p></td>';
                            html += '<td>';

                            if(full.status == 0){
                                 html += '<p>已取消</p></td>';
                            }else if(full.status == 1){
                                 html += '<p>待开票</p></td>';
                            } else if (full.status == 2){
                                html += '<p>已开票</p></td>';
                            }
                            var strhtml = '';
                            for(var i in full.auth){
                                strhtml += '<p><a class="opt-btn" '+ full.auth_html[i] +'>'+ full.auth_desc[i]+'</a></p>';
                            }
                            html += strhtml + '</td>';
                            html += '</tr>';
                            html += '</table>';
                            return html;
                        }
                    }
                ]
            });

            Ajax.call("{{url('/invoice/getStatusCount')}}", [] , function(result) {
                if (result.code == 1) {
                    var status = result.data;
                    if(status.waitInvoice > 0){
                        $('#waitInvoice').html(status.waitInvoice);
                    }
                    if(status.Completed > 0){
                        $('#Completed').html(status.Completed);
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
            var flag = confirm('是否确认审批通过');
            if(flag === true){
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

        }

        //订单取消
        function orderCancel(id){
            var flag = confirm('是否确认取消');
            if(flag === true){
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
                            alert('出错,请重试')
                        }
                    }
                })
            }
        }

        //订单删除
        function orderDel(id){
            var flag = confirm('是否确认删除?');
            if(flag === true){
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
                            alert('出错,请重试')
                        }
                    }
                })
            }
        }

        //确认收货
        function confirmTake(id){
            var flag = confirm('是否确认删除?');
            if(flag === true){
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
                            alert('出错,请重试')
                        }
                    }
                })
            }
        }

        //
    </script>

@endsection
