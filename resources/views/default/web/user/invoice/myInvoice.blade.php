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
            <li @if(empty($tab_code)) class="curr" @endif><a href="/invoice/myInvoice">{{trans('home.all_status')}}</a></li>
            <li @if($tab_code == 'waitInvoice') class="curr" @endif><a href="/invoice/myInvoice?tab_code=waitInvoice">{{trans('home.wait_open_ticket')}}<em id="waitInvoice"></em></a></li>
            <li @if($tab_code == 'Completed') class="curr" @endif><a href="/invoice/myInvoice?tab_code=Completed">{{trans('home.invoiced')}}<em id="Completed"></em></a></li>
        </ul>
    </div>

    <div class="data-table-box">
        <div class="table-condition">
            <div class="item">
                <input type="text" class="text" id="invoice_numbers" placeholder="{{trans('home.invoice_number')}}">
            </div>
            <div class="item">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="{{trans('home.start_time')}}">
            </div>
            <div class="item">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="{{trans('home.end_time')}}">
            </div>
            <button id="on-search" class="search-btn">{{trans('home.query')}}</button>
            <a href="/invoice"><button class="search-btn">{{trans('home.add_new_invoice')}}</button></a>
        </div>

        <div class="table-body">
            <table class="table table-border table-bordered table-bg table-hover dataTable" style="border: 1px solid #DEDEDE;">
                <thead>
                <tr>
                    <th width="40%">{{trans('home.invoice_information')}}</th>
                    <th width="20%">{{trans('home.invoice_amount')}}</th>
                    <th width="20%">{{trans('home.logistics_tracking')}}</th>
                    <th>{{trans('home.status')}}</th>
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
            var locale = '{{App::getLocale()}}';
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
                            html += '<p><span class="pl10 fl" style="width:30%">{{trans('home.invoice_number')}}：<a>' + full.invoice_numbers +'</a></span><span class="fl">{{trans('home.shop_name')}}：'+ jqGetLangData(locale,full,'shop_name') +'</span><span class="fr">{{trans('home.order_time')}}：'+ full.created_at +'</span></p></td></tr>';
                            if (full.shipping_billno){
                                html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 21px;"><p><span style="width:50%;">{{trans('home.num')}}：' + full.order_quantity + '</span><span style="width:50%;">；{{trans('home.logistics_number')}}：' + full.shipping_billno + '</span></p></div></td>';
                            } else {
                                html += '<tr><td class="tal" width="40%"><div style="margin: 15px 10px;line-height: 21px;"><p><span style="width:50%;">{{trans('home.num')}}：' + full.order_quantity + '</span><span style="width:50%;">；{{trans('home.logistics_number')}}：{{trans('home.no_logistics_number')}}</span></p></div></td>';
                            }

                            html += '<td width="20%"><p>{{trans('home.total_invoice_amount')}}:￥'+ full.invoice_amount +'</p></td>';
                            html += '<td width="20%"><p><span><a href="/invoiceDetail/'+full.id+'">{{trans('home.invoice_details')}}</a></span></p></td>';
                            html += '<td>';

                            if(full.status == 0){
                                 html += '<p>{{trans('home.cancelled')}}</p></td>';
                            }else if(full.status == 1){
                                 html += '<p>{{trans('home.wait_open_ticket')}}</p></td>';
                            } else if (full.status == 2){
                                html += '<p>{{trans('home.invoiced')}}</p></td>';
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
        //
    </script>

@endsection
