@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实时库存')

@section('js')
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "bLengthChange": false,                  //是否允许用户自定义每页显示条数。
                "bPaginate": true,                      //是否分页。
                "bFilter": false,
                "bProcessing": true,                    //当datatable获取数据时候是否显示正在处理提示信息。
                "bSort":false,
                "sPaginationType": 'full_numbers',      //分页样式
                "serverSide": true,
                "language": {
                    "processing": "请稍后。。。",
                    // 当前页显示多少条
                    "lengthMenu": "Display _MENU_ records",
                    // _START_（当前页的第一条的序号） ,_END_（当前页的最后一条的序号）,_TOTAL_（筛选后的总件数）,
                    // _MAX_(总件数),_PAGE_(当前页号),_PAGES_（总页数）
                    "info": "",
                    // 没有数据的显示（可选），如果没指定，会用zeroRecords的内容
                    "emptyTable": "暂无数据",
                    // 筛选后，没有数据的表示信息，注意emptyTable优先级更高
                    "zeroRecords": "No records to display",
                    // 千分位的符号，只对显示有效，默认就是","  一般不要改写
                    //"thousands": "'",
                    // 小数点位的符号，对输入解析有影响，默认就是"." 一般不要改写
                    //"decimal": "-",
                    // 翻页按钮文字控制
                    "paginate": {
                        "first": "首页",
                        "last": "尾页",
                        "next": "下一页",
                        "previous": "上一页"
                    },
                    // Client-Side用，Server-Side不用这个属性
                    "loadingRecords": "Please wait - loading..."
                },
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
                "retrieve": false,
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

