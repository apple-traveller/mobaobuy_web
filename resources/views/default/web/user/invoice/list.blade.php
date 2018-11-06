<!doctype html>
<html lang="en">
<head>
    <title>开票申请 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <link rel="stylesheet" type="text/css" href="{{asset('ui/area/1.0.0/area.css')}}" />

    <style type="text/css">
        .fr{float:right;}
        .fs14{font-size:14px;}
        .order_progress{width: 351px;margin-top: 45px;margin-bottom: 45px;}
        .progress_text{color: #999;margin-top: 5px;}
        .progress_text_curr{color: #75b335;}
        .my_cart{float: left;margin-left: 5px;}
        .w1200{width: 1200px;margin: 0 auto;}
        .whitebg{background: #FFFFFF;}
        .shop_title{width:1138px;margin:0 auto;clear: both; display: block; overflow: hidden; line-height: 70px; border-bottom: 1px solid #DEDEDE;}
        .shop_title li{float: left; text-align: center;}
        input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
        .check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
        .mr5{margin-right:5px;}
        .mt25{margin-top:25px;}
        .fl{float:left;}
        .shop_good{width: 300px;margin-left: 38px;}
        .shop_list{width:1138px;margin:0 auto;overflow: hidden;}
        .shop_list li {line-height: 115px;border-bottom: 1px solid #DEDEDE;overflow: hidden;}
        .shop_list li:last-child{border-bottom:none;}
        .mr5{margin-right:5px;}
        .mt10{margin-top:10px;}
        .shop_good_title{width: 323px;padding-left: 10px;}
        .orange,a.orange,a.orange:hover{color:#ff6600;}
        .tac{text-align:center !important;}
        .sumbit_cart{width:1200px;margin:0 auto;margin-top:20px;line-height: 50px;color: #999;}
        .sumbit_cart_btn{width: 200px;float: right;line-height: 50px;background-color: #75b335;color: #fff;font-size: 16px;text-align: center;cursor:pointer;}
        .ovh{overflow: hidden;}
        .ml30{margin-left:30px;}
        .cp{cursor:pointer;}
        .ml40{margin-left: 60px;}
        .w130{width: 130px}
        .w200{width: 200px}
        .logo {
            width: 170px;
            height: 55px;
            margin-top: 20px;
            float: left;
            background: url(../img/mobao_logo.png)no-repeat;
            background-size: 100% 100%;
        }

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

        .pro_select li{height: 30px;line-height: 30px;padding-left: 5px; box-sizing: border-box;cursor: default;}
        .pro_select li:hover{background-color: #f1f1f1;}

        .partner_select li{height: 30px;line-height: 30px;padding-left: 5px; box-sizing: border-box;cursor: default;}
        .partner_select li:hover{background-color: #f1f1f1;}
    </style>
    <script type="text/javascript" src="{{asset(themePath('/','web').'plugs/My97DatePicker/4.8/WdatePicker.js')}}"></script>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
<div class="clearfix whitebg mb30">
    <div class="w1200">
        <a class="logo" style="margin-top: 45px;" href="/"></a>
        <div class="fr fs14 order_progress" >
            <div class="progress_text">
                <div class="my_cart progress_text_curr">开票申请</div>
            </div>
        </div>
    </div>
</div>
<div class="data-table-box">
    <div class="table-condition" style="margin-left: 631px">
        <div class="item">
            <input type="text" class="text" id="shop_name" placeholder="店铺名称">
        </div>
        <div class="item">
            <input type="text" class="text" id="order_no" placeholder="订单单号">
        </div>
        <div class="item">
            <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'%y-%M-%d\'}'})" id="begin_time" placeholder="下单时间从">
        </div>
        <div class="item">
            <input type="text" class="text Wdate" autocomplete="off" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'begin_time\')}',maxDate:'%y-%M-%d'})" id="end_time" placeholder="下单时间至">
        </div>
        <button id="on-search" class="search-btn">查询</button>
    </div>
</div>

<div class="w1200 whitebg" style="margin-top: 20px;max-height:500px;overflow-y: auto">

    <ul class="shop_title">
        <li class="check_all curr">
            <label class="check_box">
                <span class="mr5 mt25 check_all fl"></span>
            </label>
        </li>
        <li class="shop_good">订单编号</li>
        <li class="w200">店铺名称</li>
        <li class="w130">商品总金额</li>
        <li class="w130">详情</li>
        <li class="w130">订单状态</li>
        <li class="w130">操作</li>
    </ul>
    @if(count($orderList))
        @foreach($orderList as $k=>$v)
            <ul class="shop_list">
                <li class="check_all">
					<span class="check_tick fl" style="margin: 33px 0px;">
						<label class="check_box"><input class="check_box mr5 mt10 check_all fl" data-id="{{ $v['shop_id'] }}" name="" type="checkbox" @if($v['order_status']==4) disabled @endif value="{{$v['id']}}"/> </label>
					</span>
                    <a class="shop_good_title fl tac" style="line-height: 20px;margin-top: 45px;">{{$v['order_sn']}}</a>
                    <span class="w200 fl tac" style="line-height: 20px;margin-top: 45px;">{{$v['shop_name']}}</span>
                    <span class="w130 orange fl tac goods_amount">{{$v['goods_amount']}}</span>
                    <a href="/orderDetails/{{ $v['order_sn'] }}" class="w130 orange fl">订单详情</a>
                    <span class="w130 fl tac">@if($v['order_status']==5) 待开票 @elseif($v['order_status']==4) 已完成  @endif </span>
                    <span class="w130 orange fl tac">
                        <a href="javascript:void(0);" style="cursor: pointer" data-id="{{$v['id']}}" data-status="{{$v['order_status']}}" onclick="_apply(this)">申请开票</a>
                    </span>
                </li>
            </ul>
        @endforeach
    @else
        <div class="w1200 whitebg" style="height: 100px;vertical-align:center;padding-top: 60px">
        <div style="align-content:center;width: auto " align="center">暂时没有符合条件的订单<a type="button" href="/order/list" style="height: 20px;background-color: #75b335;color:#fff;"  align="center">订单列表</a></div>


        </div>
    @endif
</div>
<div class="sumbit_cart whitebg ovh mb30">
    <span class="fl ml40">共<font class="orange" id="accountTotal">@if($orderList) {{count($orderList)}} @else 0 @endif</font>个订单，已选择<font class="orange" id="checkedSel">0</font>个,共<font class="orange" id="total_amount">0</font>元</span>
    <div class="sumbit_cart_btn" onclick="toBalance()">申请开票</div>
</div>
<div class="clearfix" style="height: 28px;"></div>
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
<script src="{{asset('ui/area/1.0.0/area.js')}}"></script>
<script type="text/javascript">
    //购物车选中的数据
    var check_arr = new Array();
    var total_amount = 0;
    var accountTotal = $('#accountTotal').text();

    // //全选
    // function check_all(){
    //     $('#check_all').change(function(){
    //         check_arr = [];
    //         total_amount = 0;
    //         if($(this).is(':checked')){
    //             $('.shop_list .check_all span label input:checkbox').prop('checked',true);
    //             $('.shop_list .check_all span label input:checkbox').each(function(){
    //                 check_arr.push($(this).val());
    //             })
    //             $('#checkedSel').html(check_arr.length);
    //
    //         }else{
    //             check_arr = [];
    //             $('.shop_list .check_all span label input:checkbox').prop('checked',false);
    //             $('#checkedSel').html(0);
    //         }
    //         $('.shop_list .check_all span label input:checked').parent().parent().siblings('.goods_amount').each(function () {
    //             total_amount = total_amount + parseInt($(this).text());
    //             console.log(total_amount);
    //         });
    //         $('#total_amount').html(total_amount);
    //     })
    // }

    // 单选框

    $('.shop_list .check_all span label input').change(function(){
        let shop = '';
        total_amount = 0;
        check_arr = [];
        $('.shop_list .check_all span label input:checked').each(function(index,item){
            if(index == 0){
                shop = $(this).attr('data-id');
                check_arr.push($(this).val());
            }else{
                if ($(this).attr('data-id') != shop){
                    $(this).attr('checked',false);
                    layer.msg('一次只能申请同店铺的订单');
                    return;
                } else {
                    check_arr.push($(this).val());
                }
            }

        })
        $('#checkedSel').html(check_arr.length);
        if(check_arr.length == accountTotal){
            $('#check_all').prop('checked',true);
            check_all();
        }else{
            $('#check_all').prop('checked',false);
        }
        $('.shop_list .check_all span label input:checked').parent().parent().siblings('.goods_amount').each(function () {
            total_amount = total_amount + parseInt($(this).text());
        });
        $('#total_amount').html(total_amount);

    });

    $('#on-search').click(function () {
        let shop_name = $('#shop_name').val();
        let order_no = $('#order_no').val();
        let begin_time = $('#begin_time').val();
        let end_time = $('#end_time').val();
        window.location.href = '/invoice?shop_name='+shop_name+'&order_no='+order_no+'&begin_time='+begin_time+'&end_time='+end_time;
    });


    // 单个申请
    function _apply(obj){
        let order_id = $(obj).attr('data-id');
        let order_ids = [];
        let order_status = $(obj).attr('data-status');
        let total_amount = parseInt($(obj).parent().siblings('.goods_amount').text());
        if (order_status==4){
            layer.msg('订单已完成，无法提交申请');
        }
            order_ids.push(order_id);

        let form = $("<form></form>");
        form.attr('action','/invoice/confirm');
        form.attr('method','post');
        let input1 = $("<input type='hidden' name='order_id' />");
        input1.attr('value',order_ids);
        let input2 = $("<input type='hidden' name='total_amount' />");
        input2.attr('value',total_amount);
        form.append(input1);
        form.append(input2);
        form.appendTo("body");
        form.css('display','none');
        form.submit()
    }

    //checkbox框
    function checkListen(){
        var arr = new Array();
        $('.shop_list .check_all span label input:checkbox').each(function(){
            arr.push($(this).val());
        })

        if(arr.length>0){
            $.ajax({
                url: "/checkListen",
                dataType: "json",
                data: {
                    'cartId':arr
                },
                type: "POST",
                success: function (data) {

                }
            })
        }else{
            layer.msg('请选择商品');return;
        }
    }

    // 提交申请
    function toBalance(){
        check_arr = [];
        total_amount = 0;
        $('.shop_list .check_all span label input:checked').each(function(index,item){
            check_arr.push($(this).val());
        });
        $('.shop_list .check_all span label input:checked').parent().parent().siblings('.goods_amount').each(function () {
            total_amount = total_amount + parseInt($(this).text());
        });
        if(check_arr.length>0){
            let form = $("<form></form>");
            form.attr('action','/invoice/confirm');
            form.attr('method','post');
            let input1 = $("<input type='hidden' name='order_id' />");
            input1.attr('value',check_arr);
            let input2 = $("<input type='hidden' name='total_amount' />");
            input2.attr('value',total_amount);
            form.append(input1);
            form.append(input2);
            form.appendTo("body");
            form.css('display','none');
            form.submit()
        }else{
            alert('请选择订单');return;
        }
    }

</script>
</body>
</html>
