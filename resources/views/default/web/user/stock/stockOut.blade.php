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

    .pro_select{width: 330px; position: absolute; top: 39px; left: 140px; background-color: #fff;  border: 1px solid #dedede;  box-sizing: border-box;}
    .pro_select li{height: 30px;line-height: 30px;padding-left: 5px; box-sizing: border-box;cursor: default;}
    .pro_select li:hover{background-color: #f1f1f1;}

    .partner_select{width: 330px; position: absolute; top: 124px; left: 171px; background-color: #fff;  border: 1px solid #dedede;  box-sizing: border-box;z-index:1;}
    .partner_select li{height: 30px;line-height: 30px;padding-left: 5px; box-sizing: border-box;cursor: default;}
    .partner_select li:hover{background-color: #f1f1f1;}
    #data-table tbody tr td{word-break: break-all;}
    .operation-btn{
        width: 38px;
        height: 24px;
        line-height: 24px;
        padding: 2px 10px;
        border-radius: 3px;
        cursor: pointer;
        color: #fff;
        border: 1px solid #999;
        background-color: rgb(244, 244, 244);
        margin: 0 5px;
    }
    .operation-btn:hover{
        /*background-color: #75b335;*/
        border: 1px solid #75b335;
    }
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
                    {"data": "number_full", "bSortable": false},
                    {"data": "price_full", "bSortable": false},
                    {"data": "flow_desc", "bSortable": false,
                        "render": function (data, type, row, meta) {
                            var data = "'"+data+"'";
                            return "<button class='operation-btn' onclick='delBtn(this,"+JSON.stringify(row)+")'><img height='15' style='margin-bottom: 10px' src='/default/img/del.png' /> </button>" +
                                "<button class='operation-btn' onclick='editBtn(this,"+JSON.stringify(row)+")'><img height='15' style='margin-bottom: 10px' src='/default/img/edit.png' /> </button>" +
                                '<button class="operation-btn" onclick="remarkBtn(this,'+data+')"><img height="15" style="margin-bottom: 10px" src="/default/img/view.png" /> </button>';
                        }
                    }
                ]
            });
            $('.close,.cancel').click(function(){
                $('.block_bg,.putIn').hide()
            });
            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
        });
        function delBtn(obj,row){
            if(row.order_sn != ''){
                layer.msg('订单生成的入库单，无法删除');return;
            }
            $.msg.confirm('是否确认删除？',
                function () {
                    $.ajax({
                        url: "/delFirmStockFlow",
                        dataType: "json",
                        data: {
                            'id':row.id
                        },
                        type: "GET",
                        success: function (data) {
                            if(data.code){
                                $.msg.alert('删除成功！',{time:2000});
                                setTimeout(function () { window.location.reload(); }, 2000);
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
        function editBtn(obj,row){
            console.log(row);
            $('#stock_out_id').val(row.id);
            $('#partner_name').val(row.partner_name);
            $('#order_sn').val(row.order_sn);
            $('#good_name').val(row.goods_name);
            $('#currStockNum').val(row.number);
            $('#number_old').val(row.number);
            $('#price').val(row.price);
            $('#flow_desc').val(row.flow_desc);
            $('#num').attr('stockId',row.stock_id);
            $('#num').val(row.stock_num);
            $('.block_bg,.putIn').toggle();
        }
        function remarkBtn(obj,res){
            if(res == ''){
                res = '无备注信息'
            }
            layer.tips(res, obj, {
                tips: [1, '#3595CC'],
                time: 4000
            });
        }
        function addStockOutSave(){
            var order_sn = $('#order_sn').val();
            var currStockNum = $('#currStockNum').val();
            var partner_name = $('#partner_name').val();
            var price = $('#price').val();
            var flow_desc = $('#flow_desc').val();
            var stock_out_id = $('#stock_out_id').val();
            var number_old = $('#number_old').val();
            var id = $('#num').attr('stockId');
            if(currStockNum == '' || currStockNum <= 0){
                $.msg.alert('出库数量有误,请重新填写');
                return;
            }
            Ajax.call('/curStockSave',{
                currStockNum:currStockNum,
                flow_desc:flow_desc,
                id:id,
                price:price,
                partner_name:partner_name,
                order_sn:order_sn,
                stock_out_id:stock_out_id,
                number_old:number_old
            }, function(data){
                if(data.code){
                    $.msg.tips('编辑出库记录成功');
                    setTimeout(function () { window.location.reload(); }, 2000);
                }else{
                    $.msg.error(data.msg);
                }
            },'POST','JSON');
        }
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
            <div class="fr add_stock tac white"><a href="{{url('canStockOut')}}" style="color:#fff">+新增出库</a></div>
        </div>
        
        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                    <tr class="text-c">
                        <th width="15%">出库日期</th>
                        <th width="15%">出库单号</th>
                        <th width="20">商品名称</th>
                        <th width="15%">出库数量</th>
                        <th width="15%">出库单价(元)</th>
                        <th width="20%">备注</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
    <!--遮罩-->
    <div class="block_bg" style="display:none;"></div>
    <div class="pay_method whitebg putIn"  style="display:none;">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">编辑出库记录</span><a class="fr pr20 close"><img src="img/close.png" width="16" height="16"></a></div>
        <ul class="pay_content ovh" style="margin-top: 35px;">
            <li><div class="ovh mt10"><span>商品名称:</span><input type="text" readonly="readonly" class="pay_text" name="goods_name" id="good_name"/></div></li>
            <li><div class="ovh mt10"><span>库存数量:</span><input type="text" readonly="readonly" class="pay_text" name="num" id="num" stockId="" /></div></li>
            <li><div class="ovh mt10"><span>单号:</span><input type="text" class="pay_text" id="order_sn" name="order_sn" /></div></li>
            <li><div class="ovh mt10" id="appendPartnerName"><span>收料客户:</span><input type="text" class="pay_text" id="partner_name" name="partner_name" /></div></li>
            <li><div class="ovh mt10"><span>出库数量:</span><input type="number" class="pay_text" id="currStockNum" name="currStockNum" /><i class="red ml5">*</i></div></li>
            <li><div class="ovh mt10"><span>出库单价:</span><input type="number" name="price" id="price" class="pay_text"/></div></li>
            <li><div class="ovh mt10"><span class="fl">备注:</span><textarea class="pay_textarea" id="flow_desc" name="flow_desc"></textarea></div></li>
            <input type="hidden" name="stock_out_id" id="stock_out_id" value="" />
            <input type="hidden" name="number_old" id="number_old" value="" />
            <li><div class="til_btn fl tac mt10 code_greenbg currStockOut" id="" onclick="addStockOutSave();">保 存</div><div class="til_btn tac mt10 blackgraybg fl cancel" style="margin-left: 45px;">取消</div></li>
        </ul>
    </div>
@endsection

