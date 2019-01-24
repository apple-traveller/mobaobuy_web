@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '入库管理')

@section('js')
    <style type="text/css">

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
     
    </style>
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
                "ajax": {
                    url: "{{url('stockIn')}}",
                    type: "post",
                    dataType: "json",
                    data: function (d) {
                        d.goods_name = $('#goods_name').val(),
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
                    {"data": "flow_time", "bSortable": false},
                    {"data": "order_sn", "bSortable": false},
                    {"data": "goods_name", "bSortable": false},
                    {"data": "number", "bSortable": false},
                    {"data": "price", "bSortable": false},
                    {"data": "flow_desc", "bSortable": false}
                ]
            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
                
                // var goods_name = $('#goods_name').val();
                // var begin_time = $('#begin_time').val();
                // var end_time = $('#end_time').val();
                // if(!goods_name && (!begin_time && !end_time)){
                //     alert('请完整输入查询条件');
                //     return;
                // }
                // $.ajax({
                //     url: "/stockIn",
                //     dataType: "json",
                //     data: {
                //         'goods_name':goods_name,
                //         'begin_time':begin_time,
                //         'end_time':end_time
                //     },
                //     type: "POST",
                //     success: function (data) {
                //         console.log(data);
                //         if(data['data']['data'].length > 0){
                //             var strHtml = '';
                //             for(var i = 0;i<data['data']['data'].length;i++){
                //                    strHtml += '<tr role="row" class="odd"><td>'+data['data']['data'][i]['flow_time']+'</td><td>'+data['data']['data'][i]['order_sn']+'</td><td>'+data['data']['data'][i]['goods_name']+'</td><td>'+data['data']['data'][i]['number']+'</td><td>0.00</td></tr>';
                //             }
                //             $('tbody').html(strHtml);
                
                //         }else{
                //            $('tbody').html('无此记录');
                //         }
                //     }
                // })
            });

            $('.add_stock').click(function(){
                $('.block_bg,.putIn').toggle()
            });
            $('.close,.cancel').click(function(){
                $('.block_bg,.putIn').hide()
            });

            $('#goodName').keyup(function(){
                $('#goodName').attr('goodsId', 0);
                var goodsName = $('#goodName').val();
                Ajax.call('/searchGoodsName', {goodsName: goodsName}, function(data){
                    if(data['data'].length>0){
                        $('#appendGoodsName ul').remove();
                        var str = '';
                        for(var i = 0;i<data['data'].length;i++){
                            str += '<li id="'+data['data'][i]['id']+'">'+data['data'][i]['goods_full_name']+'</li>';
                        }
                        var strHtml = '<ul id="pointUl"  class="pro_select" >'+str+'</ul>';
                        $('#appendGoodsName').append(strHtml);
                    }else{
                        $('#appendGoodsName ul').remove();
                        var strHtml = '<ul id="pointUl" id="0" class="pro_select" ><li>无此商品数据信息</li></ul>';
                        $('#appendGoodsName').append(strHtml);
                    }
                },"POST", "JSON");
            });

            $('#partner_name').keyup(function(){

                // $('#goodName').attr('goodsId', 0);
                 var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:2}, function(data){
                    console.log(data);
                    if(data['data'].length>0){
                        $('#appendPartnerName ul').remove();
                        var str = '';
                        for(var i = 0;i<data['data'].length;i++){
                            str += '<li id="'+data['data'][i]['id']+'">'+data['data'][i]['partner_name']+'</li>';
                        }
                        var strHtml = '<ul id="partnerUl"  class="partner_select" >'+str+'</ul>';
                        $('#appendPartnerName').append(strHtml);
                    }else{
                        $('#appendPartnerName ul').remove();
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>无此供应商数据信息</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });

            $('#partner_name').click(function(){
                var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:2}, function(data){
                     console.log(typeof(data));
                     var arr = []
                    for (var i in data['data']) {
                        arr.push(data['data'][i]); //属性
                        //arr.push(object[i]); //值
                    }
                    console.log(arr);
                    if(arr.length>0){
                        $('#appendPartnerName ul').remove();
                        var str = '';
                        for(var i = 0;i<arr.length;i++){
                            str += '<li id="'+arr[i]['id']+'">'+arr[i]['partner_name']+'</li>';
                        }
                        var strHtml = '<ul id="partnerUl"  class="partner_select" >'+str+'</ul>';
                        $('#appendPartnerName').append(strHtml);
                       
                    }else{
                         $('#appendPartnerName ul').remove();
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>无此商品数据信息</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });
            
        });


        //商品名称选择下拉列表的值
        $(document).on('click', '.pro_select li', function(e) {
            var goodsName = $(this).text();
            var goodsId = $(this).attr('id');
            if(goodsId > 0){
                $('#goodName').val(goodsName);
                $('#goodName').attr('goodsId',goodsId);
            }
            $('#appendGoodsName ul').remove();
        });

         //供应商名称选择下拉列表的值
        $(document).on('click', '.partner_select li', function(e) {
            var partnerName = $(this).text();
            var partnerId = $(this).attr('id');
            if(partnerId > 0){
                $('#partner_name').val(partnerName);
                $('#partner_name').attr('partnerId',partnerId);
            }
            $('#appendPartnerName ul').remove();
        });

        function addStockSave(){
            var partner_name = $('input[name=partner_name]').val();
            var order_sn = $('input[name=order_sn]').val();
            // var goods_name = $('#goodName').val();
            var goods_id = $('#goodName').attr('goodsId');
            var number = $('input[name=number]').val();
            var price = $('input[name=price]').val();
            var flow_desc = $('textarea[name=flow_desc]').val();
            if(goods_id == '' || goods_id <= 0){
                $.msg.error('商品必须从检索的下拉列表中点击选择');
                return false;
            }
            if(number == '' || number <= 0){
                $.msg.error('入库数量有误');
                return false;
            }
            
            $.ajax({
                url: "/addStockIn",
                dataType: "json",
                data: {
                    'partner_name':partner_name,
                    'order_sn':order_sn,
                    // 'goods_name':goods_name,
                    'number':number,
                    'price':price,
                    'flow_desc':flow_desc,
                    'goods_id':goods_id
                },
                type: "POST",
                success: function (data) {
                    if(data.code){
                        $.msg.alert('添加成功！');
                        window.location.reload();
                    }else{
                        $.msg.error(data.msg);
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
            <div class="item"><input type="text" name="goods_name" class="text" id="goods_name" placeholder="商品名称"></div>
            <div class="fl ml20 item">
                <input type="text" class="text Wdate" name="begin_time" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="入库时间从">
                <input type="text" class="text Wdate" name="end_time" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="入库时间至">
            </div>
            <button id="on-search" class="search-btn">查询</button>
            <div class="fr add_stock tac white">+新增入库</div>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="15%">入库日期</th>
                    <th width="15%">订单编号</th>
                    <th width="20%">商品名称</th>
                    <th width="15%">入库数量</th>
                    <th width="15%">入库单价(元)</th>
                    <th width="20%">备注</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--遮罩-->
    <div class="block_bg" style="display:none;"></div>
    <div class="pay_method whitebg putIn"  style="display:none;">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">新增入库记录</span><a class="fr pr20 close"><img src="img/close.png" width="16" height="16"></a></div>
        <ul class="pay_content" style="margin-top: 35px;">
            <li><div class="ovh mt10" id="appendPartnerName"><span>供应商:</span><input type="text" class="pay_text" name="partner_name" id="partner_name" /></div></li>
            <li><div class="ovh mt10"><span>订单编号:</span><input type="text" class="pay_text" name="order_sn" /></div></li>
            <li><div class=" mt10 pr" id="appendGoodsName" style="position: relative;"><span>商品名称:</span><input type="text" class="pay_text" name="goods_name" id="goodName" /><i class="red ml5">*</i>
                </div>
            </li>
            <li><div class="ovh mt10"><span>入库数量:</span><input type="number" class="pay_text" name="number" /><i class="red ml5">*</i></div></li>
            <li><div class="ovh mt10"><span>入库单价:</span><input type="number" name="price" class="pay_text"/></div></li>
            <li><div class="ovh mt10"><span class="fl">备注:</span><textarea class="pay_textarea" name="flow_desc"></textarea></li>
            <li><div class="til_btn fl tac mt10 code_greenbg" onclick="addStockSave();" style="margin-bottom: 30px">保 存</div><div class="til_btn tac mt10 blackgraybg fl cancel" style="margin-left: 45px;margin-bottom: 30px">取消</div></li>
        </ul>
    </div>
@endsection

