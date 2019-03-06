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
                            if(data == 1) return '{{trans('home.platform_warehouse')}}';
                            if(data == 2) return '{{trans('home.other_warehouse')}}';
                            if(data == 3) return '{{trans('home.sales_outlet')}}';
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
            <div class="item fl" style="font-size: 16px;height: 40px;line-height: 40px;"><span class="pr20 pl15">{{trans('home.goods_name')}}：{{$firmStockInfo['goods_name']}}</span>{{trans('home.stock')}}：<span class="fs18 orange fwb">{{$firmStockInfo['number']}}</span>
            </div>
            <div class="fr back_btn "><a href="{{url('stock/list')}}" style="color:#fff">{{trans('home.return')}}</a></div>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="20%">{{trans('home.date')}}</th>
                    <th width="15%">{{trans('home.odd_numbers')}}</th>
                    <th width="13%">{{trans('home.type')}}</th>
                    <th width="">{{trans('home.customer_supplier')}}</th>
                    <th width="12%">{{trans('home.num')}}</th>
                    <th width="12%">{{trans('home.price')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

