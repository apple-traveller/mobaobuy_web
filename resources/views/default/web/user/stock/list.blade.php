@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '实时库存')

@section('js')
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
@endsection

@section('js')
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    $(function () {
    tbl = $('.table-sort').dataTable({
    "aaSorting": [[1, "desc"]],//默认第几个排序
    /* 			"bStateSave": true,//状态保存 */
    "aLengthMenu": [10, 20, 50], //更改显示记录数选项  	    "iDisplayLength" : 2, //默认显示的记录数
    "bLengthChange": true,                  //是否允许用户自定义每页显示条数。
    "bPaginate": true,                      //是否分页。
    "bFilter": false,
    "bProcessing": true,                    //当datatable获取数据时候是否显示正在处理提示信息。
    "sPaginationType": 'full_numbers',      //分页样式
    "serverSide": true,
    "ajax": {
    url: "goods/list/json",
    type: "get",
    dataType: "json",
    data: function (d) {
    d.keyword = $('#search').val();
    },
    dataSrc:
    function (data) {
    if (data.recordsTotal == null) {
    data.recordsTotal = 0;
    }
    //查询结束取消按钮不可用
    return data.rows;//自定义数据源，默认为data
    },
    },
    "retrieve": false,
    "columns": [
    {
    "data": "id",
    "bSortable": false,
    "render": function (data, type, full, meta) {
    return '<input type="checkbox" value="' + data + '" name="">';
    }
    },
    {"data": "goods_id", "bSortable": false},
    {"data": "goods_sn", "bSortable": false},
    {"data": "goods_name", "bSortable": false},
    {"data": "brand_name", "bSortable": false},
    {"data": "xinghao", "bSortable": false}
    ]
    });

    $("#on-search").click(function () {
    var oSettings = tbl.fnSettings();
    tbl.fnClearTable(0);
    tbl.fnDraw();

    });
    });
@endsection

@section('content')
    <!--标题-->
    <div class="data-table-box">
        <div class="table-condition">
            <div class="item"><input type="text" class="text" placeholder="商品名称"></div>
            <button class="search-btn">查询</button>
        </div>

        <div class="table-body">
            <table>
                <thead>
                    <tr>
                        <th width="50%">名称</th>
                        <th width="25%">库存剩余数量(kg)</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>维生素E粉</td><td>80</td><td><button class="opt-btn">查看</button></td>
                    </tr>
                    <tr>
                        <td>维生素E粉</td><td>80</td><td><button class="opt-btn">查看</button></td>
                    </tr>
                    <tr>
                        <td>维生素E粉</td><td>80</td><td><button class="opt-btn">查看</button></td>
                    </tr>
                    <tr>
                        <td>维生素E粉</td><td>80</td><td><button class="opt-btn">查看</button></td>
                    </tr>
                    <tr>
                        <td colspan="3">没有符合条件的记录</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-pager">
            <ul class="pagination">
                <li><a href="#">首页</a></li>
                <li><a href="#">上一页</a></li>
                <li><a href="#">1</a></li>
                <li><a class="active" href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">下一页</a></li>
                <li><a href="#">尾页</a></li>
            </ul>
        </div>
    </div>
@endsection

