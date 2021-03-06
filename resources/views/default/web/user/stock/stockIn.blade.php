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
                    {"data": "goods_name", "bSortable": false,
                        "render": function (data, type, row, meta) {
                            var locale = '{{App::getLocale()}}';
                            return jqGetLangData(locale,row,'goods_name');
                        }
                    },
                    {"data": "number_full", "bSortable": false},
                    {"data": "price_full", "bSortable": false},
//                    {"data": "flow_desc", "bSortable": false}
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
            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

            $('.add_stock').click(function(){
                $('#stork_in_id').val('');
                $('#partner_name').val('');
                $('#order_sn').val('');
                $('#goodName').val('');
                $('#number').val('');
                $('#pay_text').val('');
                $('#flow_desc').val('');
                $('#goodName').attr('goodsId','');
                $('.block_bg,.putIn').toggle();
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
                        var strHtml = '<ul id="pointUl" id="0" class="pro_select" ><li>{{trans('home.no_goods_info')}}</li></ul>';
                        $('#appendGoodsName').append(strHtml);
                    }
                },"POST", "JSON");
            });

            $('#partner_name').keyup(function(){

                // $('#goodName').attr('goodsId', 0);
                 var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:2}, function(data){

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
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>{{trans('home.no_supplier_info')}}</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });

            $('#partner_name').click(function(){
                var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:2}, function(data){

                     var arr = []
                    for (var i in data['data']) {
                        arr.push(data['data'][i]); //属性
                        //arr.push(object[i]); //值
                    }
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
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>{{trans('home.no_goods_info')}}</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });
            
        });

        function delBtn(obj,row){
            if(row.order_sn != ''){
                layer.msg('{{trans('home.cannot_delete')}}');return;
            }
            $.msg.confirm('{{trans('home.is_delete')}}？',
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
                                $.msg.alert('{{trans('home.delete_success')}}！',{time:2000});
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
            if(row.order_sn != ''){
                layer.msg('{{trans('home.cannot_edit')}}');return;
            }
            $('#stork_in_id').val(row.id);
            $('#partner_name').val(row.partner_name);
            $('#order_sn').val(row.order_sn);
            $('#goodName').val(row.goods_name);
            $('#number').val(row.number);
            $('#number_old').val(row.number);
            $('#pay_text').val(row.price);
            $('#flow_desc').val(row.flow_desc);
            $('#goodName').attr('goodsId',row.goods_id)
            $('.block_bg,.putIn').toggle();
        }
        function remarkBtn(obj,res){
            if(res == ''){
                res = '{{trans('home.no_remark_info')}}'
            }
            layer.tips(res, obj, {
                tips: [1, '#3595CC'],
                time: 4000
            });
        }
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
            var id = $('input[name=id]').val();
            var partner_name = $('input[name=partner_name]').val();
            var order_sn = $('input[name=order_sn]').val();
            // var goods_name = $('#goodName').val();
            var goods_id = $('#goodName').attr('goodsId');
            var number = $('input[name=number]').val();
            var number_old = $('input[name=number_old]').val();
            var price = $('input[name=price]').val();
            var flow_desc = $('textarea[name=flow_desc]').val();
            if(goods_id == '' || goods_id <= 0){
                $.msg.error('{{trans('home.choose_goods_tips')}}');
                return false;
            }
            if(number == '' || number <= 0){
                $.msg.error('{{trans('home.storage_num_error')}}');
                return false;
            }
            
            $.ajax({
                url: "/addStockIn",
                dataType: "json",
                data: {
                    'id':id,
                    'partner_name':partner_name,
                    'order_sn':order_sn,
                    'number':number,
                    'number_old':number_old,
                    'price':price,
                    'flow_desc':flow_desc,
                    'goods_id':goods_id
                },
                type: "POST",
                success: function (data) {
                    if(data.code){
                        $.msg.alert('{{trans('home.sub_success')}}！',{time:2000});
                        setTimeout(function () { window.location.reload(); }, 2000);
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
            <div class="item"><input type="text" name="goods_name" class="text" id="goods_name" placeholder="{{trans('home.goods_name')}}"></div>
            <div class="fl ml20 item">
                <input type="text" class="text Wdate" name="begin_time" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="{{trans('home.start_time')}}">
                <input type="text" class="text Wdate" name="end_time" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="{{trans('home.end_time')}}">
            </div>
            <button id="on-search" class="search-btn">{{trans('home.query')}}</button>
            <div class="fr add_stock tac white">+ {{trans('home.add_new_warehouse')}}</div>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="15%">{{trans('home.storage_date')}}</th>
                    <th width="15%">{{trans('home.order_number')}}</th>
                    <th width="20%">{{trans('home.goods_name')}}</th>
                    <th width="15%">{{trans('home.num')}}</th>
                    <th width="15%">{{trans('home.price')}}</th>
                    <th width="20%">{{trans('home.operation')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--遮罩-->
    <div class="block_bg" style="display:none;"></div>
    <div class="pay_method whitebg putIn"  style="display:none;">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">{{trans('home.add_new_storage_record')}}</span><a class="fr pr20 close"><img src="img/close.png" width="16" height="16"></a></div>
        <ul class="pay_content" style="margin-top: 35px;">
            <li><div class="ovh mt10" id="appendPartnerName"><span>{{trans('home.home_supplier')}}:</span><input type="text" class="pay_text" name="partner_name" id="partner_name" /></div></li>
            <li><div class="ovh mt10"><span>{{trans('home.order_number')}}:</span><input type="text" class="pay_text" name="order_sn" id="order_sn"/></div></li>
            <li><div class=" mt10 pr" id="appendGoodsName" style="position: relative;"><span>{{trans('home.goods_name')}}:</span><input type="text" class="pay_text" name="goods_name" id="goodName" goodsId="" /><i class="red ml5">*</i>
                </div>
            </li>
            <li><div class="ovh mt10"><span>{{trans('home.num')}}:</span><input type="number" class="pay_text" name="number" id="number"/><i class="red ml5">*</i></div></li>
            <li><div class="ovh mt10"><span>{{trans('home.price')}}:</span><input type="number" name="price" class="pay_text" id="pay_text"/></div></li>
            <li><div class="ovh mt10"><span class="fl">{{trans('home.remark')}}:</span><textarea class="pay_textarea" name="flow_desc" id="flow_desc"></textarea></div></li>
            <input type="hidden" name="id" id="stork_in_id" value="" />
            <input type="hidden" name="number_old" id="number_old" value="" />
            <li><div class="til_btn fl tac mt10 code_greenbg" onclick="addStockSave();" style="margin-bottom: 30px">{{trans('home.save')}}</div><div class="til_btn tac mt10 blackgraybg fl cancel" style="margin-left: 45px;margin-bottom: 30px">{{trans('home.cancel')}}</div></li>
        </ul>
    </div>
@endsection

