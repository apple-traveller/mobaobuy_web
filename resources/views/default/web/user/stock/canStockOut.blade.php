@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '可出库库存')

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
    /*黑色*/
    .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
    .pay_method{display:none;z-index: 2;width:584px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}
    .whitebg{background: #FFFFFF;}
    .pay_title{height: 50px;line-height: 50px;}
    .f4bg{background-color: #f4f4f4;}
    .pl30{padding-left:30px;}
    .gray,a.gray,a.gray:hover{color:#aaa;}
    .fs16{font-size:16px;}
    .fl{float:left;}
    .pr20{padding-right:20px;}
    .close{width: 20px;height: 20px;line-height:0;padding-top: 17px;
     display: block;outline: medium none;
     transition: All 0.6s ease-in-out;
     -webkit-transition: All 0.6s ease-in-out;
     -moz-transition: All 0.6s ease-in-out;
     -o-transition: All 0.6s ease-in-out;}
     .pay_content span{display:inline-block;width: 100px;text-align: right;margin-left: 20px;color: #666;}
     .pay_content{width: 521px;margin: 0 auto;margin-bottom: 25px;}
     .ovh{overflow: hidden;}
     .mt10{margin-top:10px;}
     .pay_text{width: 330px;height:40px;line-height: 40px;margin-left: 20px;border: 1px solid #e6e6e6;padding: 5px;box-sizing: border-box;}
     .red,a.red,a.red:hover{color:#f70503;}
     .ml5{margin-left:5px;}
     .pay_textarea{width: 331px;height: 100px;margin-left: 20px;border: 1px solid #e6e6e6;padding: 7px;box-sizing: border-box;}
     .til_btn{width: 120px;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border-radius:3px;margin-left: 139px;cursor: pointer;}
     .mt10{margin-top:10px;}
     .code_greenbg{background-color: #75b335;} 
     .til_btn{width: 120px;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border-radius:3px;margin-left: 139px;cursor: pointer;}
     .blackgraybg{background-color: #a0a0a0;}
     .xcConfirm .popBox .sgBtn.cancel{background-color: #546a79; color: #FFFFFF;}
</style>
   <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>
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
                    url: "{{url('canStockOut')}}",
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
                        "render": function (data, type, row, meta) {
                            return '<button class="opt-btn add_stock" id="'+row.id+'" onclick="add_stock_toggle(this)">出库</button>';
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

        function add_stock_toggle(obj){
            $('.block_bg,.putIn').toggle();
            var id = $(obj).attr('id');
            $.ajax({
                url: "/curCanStock",
                dataType: "json",
                data: {
                'id':id
                },
                type: "POST",
                success: function (data) {
                    $('#good_name').val(data.data.goods_name);
                    $('#number').val(data.data.number);
                    $('#good_name').attr('disabled','disabled');
                    $('#number').attr('disabled','disabled');
                    $('.currStockOut').attr('id',data.data.id);
                }
                
            })
        }

        $('.close,.cancel').click(function(){
            $('.block_bg,.putIn').hide()
        })

        //baocun
        function addStockOutSave(){
            var currStockNum = $('#currStockNum').val();
            var flow_desc = $('#flow_desc').val();
            var id = $('.currStockOut').attr('id');
             $.ajax({
                url: "/curStockSave",
                dataType: "json",
                data: {
                'currStockNum':currStockNum,
                'flow_desc':flow_desc,
                'id':id
                },
                type: "POST",
                success: function (data) {
                    if(data.code){
                        alert('添加出库记录成功');
                        window.location.reload();
                    }else{
                        alert('添加失败');
                    }
                }
                
            })
        }
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


     <!--遮罩-->
        <div class="block_bg" style="display:none;"></div>
        <div class="pay_method whitebg putIn"  style="display:none;">
            <div class="pay_title f4bg"><span class="fl pl30 gray fs16">新增出库记录</span><a class="fr pr20 close"><img src="img/close.png" width="16" height="16"></a></div>
            <ul class="pay_content ovh" style="margin-top: 35px;">
                <!-- <li><div class="ovh mt10"><span>供应商:</span><input type="text" class="pay_text" name="partner_name" /></div></li>
                <li><div class="ovh mt10"><span>订单编号:</span><input type="text" class="pay_text" name="order_sn" /></div></li> -->
                <li><div class="ovh mt10"><span>商品名称:</span><input type="text" class="pay_text" name="goods_name" id="good_name"/></div></li>
                <li><div class="ovh mt10"><span>可出库数量(kg):</span><input type="text" class="pay_text" name="number" id="number" /><i class="red ml5">*</i></div></li>
                <li><div class="ovh mt10"><span>本次出库数量(kg):</span><input type="text" class="pay_text" id="currStockNum" name="currStockNum" /><i class="red ml5">*</i></div></li>
               <!--  <li><div class="ovh mt10"><span>入库单价:</span><input type="text" class="pay_text"/><i class="red ml5">*</i></div></li> -->
                <li><div class="ovh mt10"><span class="fl">备注:</span><textarea class="pay_textarea" id="flow_desc" name="flow_desc"></textarea></li>
                <li><div class="til_btn fl tac mt10 code_greenbg currStockOut" id="" onclick="addStockOutSave();">保 存</div><div class="til_btn tac mt10 blackgraybg fl cancel" style="margin-left: 45px;">取消</div></li>
            </ul>
        </div>
@endsection

