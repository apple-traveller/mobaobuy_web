@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实时库存')

@section('js')

    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('stock/list')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.goods_name = $('#goods_name').val();
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
                    {"data": "goods_name", "bSortable": false},
                    {"data": "number", "bSortable": false},
                    {"data": "id", "bSortable": false,
                        "render": function (data, type, full, meta) {
                            return '<button class="opt-btn">查看</button>';
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
    </script>

@endsection

@section('content')
    <!--标题-->
    <div class="data-table-box">
        <div class="table-condition">
            <div class="item"><input type="text" class="text" id="goods_name" placeholder="商品名称"></div>
            <button id="on-search" class="search-btn">查询</button>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="50%">名称</th>
                    <th width="25%">库存剩余数量(kg)</th>
                    <th>操作</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection

