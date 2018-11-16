@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '出库管理')

@section('js')
<style type="text/css">
    .border_text{width: 184px;height: 34px;padding: 6px;box-sizing: border-box;border: 1px solid #DEDEDE;}
    .ml10{margin-left:10px;}
    .mr10{margin-right:10px;}
    .fr{float:right;}
    .white,a.white,a.white:hover{color:#fff; text-decoration:none;}
    .tac{text-align:center !important;}
    .add_stock{width: 104px; height: 35px;line-height: 35px;background-color: #fe853b;border-radius: 3px;cursor: pointer;}
    .ml20{margin-left:20px;}
</style>
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('stockOut')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.goods_name = $('#goods_name').val();
                        d.begin_time = $('#begin_time').val();
                        d.end_time = $('#end_time').val();
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
                    {"data": "flow_time", "bSortable": false},
                    {"data": "order_sn", "bSortable": false},
                    {"data": "goods_name", "bSortable": false},
                    {"data": "number", "bSortable": false},
                    {"data": "price", "bSortable": false}
                ]
            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
        });
    </script>

@endsection

@section('content')
    <div class="data-table-box">
        <div class="table-condition">
            <div class="item"><input type="text" class="text" id="goods_name" placeholder="商品名称"></div>
            <div class="fl ml20 item">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="入库时间从">
                <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="入库时间至">
            </div>
            <button id="on-search" class="search-btn">查询</button>
            <div class="fr add_stock tac white"><a href="{{url('canStockOut')}}">+新增出库</a></div>
        </div>
        
        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                    <tr class="text-c">
                        <th width="20%">出库日期</th>
                        <th width="20%">出库单号</th>
                        <th width="">商品名称</th>
                        <th width="15%">出库数量（kg)</th>
                        <th width="15%">出库价格</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection

