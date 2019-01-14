@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '库存流水')

@section('js')
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('stock/flow')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.id = '{{$firmStockInfo["id"]}}'
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
                    {"data": "flow_type", "bSortable": false,
                        "render": function (data, type, full, meta) {
                            if(data == 1) return '平台采购入库';
                            if(data == 2) return '其它采购入库';
                            if(data == 3) return '销售出库';
                        }
                    },
                    {"data": "partner_name", "bSortable": false},
                    {"data": "number", "bSortable": false,
                        "render": function (data, type, full, meta) {
                            if(full.flow_type == 3){
                                data = '-'+data;
                            }
                            return '<span>'+ data +'</span>';
                        }},
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
    <!--标题-->
    <div class="data-table-box">
        <div class="table-condition" >
            <div class="item fl" style="font-size: 16px;height: 40px;line-height: 40px;"><span class="pr20 pl15">商品名称：{{$firmStockInfo['goods_name']}}</span>库存数：<span class="fs18 orange fwb">{{$firmStockInfo['number']}}</span>
            </div>
            <div class="fr back_btn "><a href="{{url('stock/list')}}">返回</a></div>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="20%">日期</th>
                    <th width="15%">单号</th>
                    <th width="13%">类型</th>
                    <th width="">客户/供应商</th>
                    <th width="12%">数量</th>
                    <th width="12%">单价(元)</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

