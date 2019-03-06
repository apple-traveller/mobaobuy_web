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

     .partner_select{width: 330px; position: absolute; top: 285px; left: 172px; background-color: #fff;  border: 1px solid #dedede;  box-sizing: border-box;z-index:1;}
    .partner_select li{height: 30px;line-height: 30px;padding-left: 5px; box-sizing: border-box;cursor: default;}
    .partner_select li:hover{background-color: #f1f1f1;}
</style>
    <script type="text/javascript">
        var tbl;
        $(function () {
            tbl = $('#data-table').dataTable({
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
                "columns": [
                    {"data": "goods_name", "bSortable": false},
                    {"data": "number", "bSortable": false},
                    {"data": "id", "bSortable": false,
                        "render": function (data, type, row, meta) {
                            return '<button class="opt-btn add_stock" id="'+row.id+'" onclick="add_stock_toggle(this)">{{trans('home.out_stock')}}</button>';
                        }
                    }
                ]
            });

            $("#on-search").click(function () {
                var oSettings = tbl.fnSettings();
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });


            $('#partner_name').keyup(function(){
                // $('#goodName').attr('goodsId', 0);
                 var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:3}, function(data){
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
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>{{trans('home.no_supplier_info')}}</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });

            $('#partner_name').click(function(){
                var partnerName = $('#partner_name').val();
                Ajax.call('/searchPartnerName', {partnerName: partnerName,is_type:3}, function(data){
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
                        var strHtml = '<ul id="partnerUl" id="0" class="partner_select" ><li>{{trans('home.no_goods_info')}}</li></ul>';
                        $('#appendPartnerName').append(strHtml);
                    }
                },"POST", "JSON");
            });
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

        function add_stock_toggle(obj){
            $('.block_bg,.putIn').toggle();
            var id = $(obj).attr('id');
            $.ajax({
                url: "/stock/info",
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
        });

        function addStockOutSave(){
            var order_sn = $('#order_sn').val();
            var currStockNum = $('#currStockNum').val();
            var partner_name = $('#partner_name').val();
            var price = $('#price').val();
            var flow_desc = $('#flow_desc').val();
            var id = $('.currStockOut').attr('id');
            if(currStockNum == '' || currStockNum <= 0){
                $.msg.alert('{{trans('home.out_stock_num_error_tips')}}');
                return;
            }
            Ajax.call('/curStockSave',{currStockNum:currStockNum,flow_desc:flow_desc,id:id,price:price,partner_name:partner_name,order_sn:order_sn}, function(data){
                if(data.code){
                    $.msg.tips('{{trans('home.add_out_stock_success')}}');
                    window.location.reload();
                }else{
                    $.msg.error(data.msg);
                }
            },'POST','JSON');
        }
    </script>
@endsection

@section('content')
    <!--标题-->
    <div class="data-table-box">
        <div class="table-condition">
            <div class="item"><input type="text" class="text" id="goods_name" placeholder="{{trans('home.goods_name')}}"></div>
            <button id="on-search" class="search-btn">{{trans('home.query')}}</button>
            <div class="fr add_stock tac white"><a href="{{url('stockOut')}}" style="color:#fff">{{trans('home.return')}}</a></div>
        </div>

        <div class="table-body">
            <table id="data-table" class="table table-border table-bordered table-bg table-hover">
                <thead>
                <tr class="text-c">
                    <th width="50%">{{trans('home.name')}}</th>
                    <th width="25%">{{trans('home.stock_surplus')}}</th>
                    <th>{{trans('home.operation')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


     <!--遮罩-->
        <div class="block_bg" style="display:none;"></div>
        <div class="pay_method whitebg putIn"  style="display:none;">
            <div class="pay_title f4bg"><span class="fl pl30 gray fs16">{{trans('home.new_outgoing_records')}}</span><a class="fr pr20 close"><img src="img/close.png" width="16" height="16"></a></div>
            <ul class="pay_content ovh" style="margin-top: 35px;">
                <li><div class="ovh mt10"><span>{{trans('home.goods_name')}}:</span><input type="text" class="pay_text" name="goods_name" id="good_name"/></div></li>
                <li><div class="ovh mt10"><span>{{trans('home.stock')}}:</span><input type="text" class="pay_text" name="number" id="number" /></div></li>
                <li><div class="ovh mt10"><span>{{trans('home.odd_numbers')}}:</span><input type="text" class="pay_text" id="order_sn" name="order_sn" /></div></li>
                <li><div class="ovh mt10" id="appendPartnerName"><span>{{trans('home.receiving_customer')}}:</span><input type="text" class="pay_text" id="partner_name" name="partner_name" /></div></li>
                <li><div class="ovh mt10"><span>{{trans('home.num')}}:</span><input type="number" class="pay_text" id="currStockNum" name="currStockNum" /><i class="red ml5">*</i></div></li>
                <li><div class="ovh mt10"><span>{{trans('home.price')}}:</span><input type="number" name="price" id="price" class="pay_text"/></div></li>
                <li><div class="ovh mt10"><span class="fl">{{trans('home.remark')}}:</span><textarea class="pay_textarea" id="flow_desc" name="flow_desc"></textarea></div></li>
                <li><div class="til_btn fl tac mt10 code_greenbg currStockOut" id="" onclick="addStockOutSave();">{{trans('home.save')}}</div><div class="til_btn tac mt10 blackgraybg fl cancel" style="margin-left: 45px;">{{trans('home.cancel')}}</div></li>
            </ul>
        </div>
@endsection

