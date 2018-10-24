<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')

</head>
<body style="background-color: #ffffff">

<link rel="stylesheet" type="text/css" href="{{asset('ui/area/1.0.0/area.css')}}" />

<style>
    .tac{text-align:center !important;}
    .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
    /*会员中心-我的发票-页面*/
    .invoice_method{margin-left: 24px;margin-right: 20px;}
    /*会员中心-收货地址*/
    .address_border{width: 905px; margin: 0 auto;}
    .Receive_address{overflow: hidden;margin-left: -15px;}
    .Receive_address li{margin-top:15px;;float:left;width: 290px;height: 130px;position: relative;border: 1px solid #DEDEDE;margin-left: 15px;box-sizing: border-box;}
    .Receive_address li:hover{border: 1px solid #75b335;}
    .Receive_address li:last-child:hover{border: 1px solid #DEDEDE;}
    .Receive_address li.curr{border: 1px solid #75b335;background: url(/default/img/addr_curr.png)no-repeat;}
    .address_name{margin-left: 24px;margin-right: 20px;}

    .ovh{overflow: hidden;}
    .mr15{margin-right:15px;}
    .mt40{margin-top:40px;}
    .pay_title{height: 50px;line-height: 50px;}
    .news_addr{width: 65px;margin: 30px auto;}
    .addr_list li{height: 40px;line-height: 40px;}
    .addr_list li .pay_text{width: 343px;}
    .addr_list li .add_left{width: 75px;text-align: right;color: #666;}
    .pay_text {
        width: 330px;
        height: 40px;
        line-height: 40px;
        margin-left: 20px;
        border: 1px solid #e6e6e6;
        padding: 8px;
        box-sizing: border-box;
    }
    .code_greenbg{background-color: #75b335;}
    .cccbg{background: #CCCCCC;}
    .form-inline{margin-left: 20px;}
    .form-inline .form-group:focus{box-shadow: none;}
    .form-inline .form-group .form-control{width: 108px;height: 40px;line-height: 40px;border-radius: 0px;border: 1px solid #dedede;
        box-shadow: none;padding: 6px 12px;font-size: 14px;    background-color: #fff;background-image: none;}

    @media (min-width: 768px).form-inline .form-group {display: inline-block;margin-bottom: 0;vertical-align: middle;}
        .sr-only {position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0); border: 0;}
        .form-group label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;}

        .address_button{width: 300px;margin: 20px auto;}
        .add_btn{cursor:pointer;float:left;border:none;color:#fff;width: 154px;height: 44px;line-height: 44px;display: block;border-radius: 3px;    margin-left: 163px;}
        .default_address label { /*flex布局让子元素水平垂直居中*/display: flex;align-items: center;width: 200px;margin-left: 154px;}

        .default_address input[type=checkbox],input[type=radio] {
            margin:initial;-webkit-appearance: none;appearance: none;outline: none;
            width: 16px; height: 16px;cursor: pointer;vertical-align: center;background: #fff;border: 1px solid #ccc;position: relative;}

        .default_address input[type=checkbox]:checked::after {
            content: "\2713";display: block;position: absolute;top: -1px;
            left: -1px;right: 0;bottom: 0;width: 12px;height: 16px;line-height: 17px;padding-left: 4px;
            color: #fff;background-color: #75b334;font-size: 13px;}
        .frame_close{width: 15px;height: 15px;line-height:0;
            display: block;outline: medium none;
            transition: All 0.6s ease-in-out;
            -webkit-transition: All 0.6s ease-in-out;
            -moz-transition: All 0.6s ease-in-out;
            -o-transition: All 0.6s ease-in-out;}
        @media (min-width: 768px).form-inline .form-group {display: inline-block;margin-bottom: 0;vertical-align: middle;}
            .sr-only {position: absolute;width: 1px;height: 1px;padding: 0;margin: -1px;overflow: hidden;clip: rect(0, 0, 0, 0); border: 0;}
            .form-group label {display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;}

            .ui-area .tit {
                padding: 0 10px;
                border: 1px solid #d2d2d2;
                height: 40px;
                line-height: 40px;
                cursor: pointer;
            }

            .ui-area .area-warp {
                position: absolute;
                border: 1px solid #d2d2d2;
                width: 300px;
                padding: 10px 23px 15px 18px;
                top: 42px;
                left: 0;
                z-index: 10;
                display: none;
                background: #fff;
            }


</style>
<!--遮罩-->

<div class="invoice_method whitebg mt20" id="invoice_frame">
    <form id="invoice_from">
        <ul class="addr_list ml30 mt20 " style="display: inline-block">
            <li>
                <div class="ovh mt10 ml30 fl">
                    <span class="add_left fl">公司抬头:</span>
                    <input type="text" name="company_name" value="@if(!empty($data['company_name'])) {{ $data['company_name'] }} @endif" @if(!empty( $data['company_name'])) readonly @endif class="pay_text" style="width: 219px;"/>
                </div>
                <div class="ovh mt10  fl" style="margin-left: 53px;">
                    <span class="add_left fl">税号:</span>
                    <input type="text" value="@if(!empty($data['tax_id'])) {{ $data['tax_id']}} @endif"  @if(!empty($data['tax_id'])) readonly @endif name="tax_id" class="pay_text" style="width: 219px;"/>
                </div>
            </li>
            <li>
                <div class="ovh mt10 ml30 fl">
                    <span class="add_left fl">开户银行:</span>
                    <input type="text" class="pay_text" value="@if(!empty($data['bank_of_deposit'])) {{ $data['bank_of_deposit']}} @endif"  name="bank_of_deposit" style="width: 219px;"/>
                </div>
                <div class="ovh mt10  fl" style="margin-left: 53px;">
                    <span class="add_left fl">银行账号:</span>
                    <input type="text" value="@if(!empty($data['bank_account'])) {{ $data['bank_account']}} @endif"  class="pay_text" name="bank_account" style="width: 219px;"/>
                </div>
            </li>
            <li>
                <div class="ovh mt10 ml30 fl">
                    <span class="add_left fl">开票电话:</span>
                    <input type="text" value="@if(!empty($data['company_telephone'])) {{ $data['company_telephone']}} @endif"  class="pay_text" name="company_telephone" style="width: 219px;"/>
                </div>
                <div class="ovh mt10 fl" style="margin-left: 53px;">
                    <span class="add_left fl">开票地址:</span>
                    <input type="text" class="pay_text fl" value="@if(!empty($data['company_address'])) {{ $data['company_address'] }} @endif" style="width: 219px;" name="company_address"/>
                    <span class="fl red ml10">*</span></div>
            </li>
            <li>
                <div class="ovh mt10 ml30 fl"><span class="add_left fl">收票人:</span><input type="text" class="pay_text" value="@if(!empty($data['consignee_name'])) {{ $data['consignee_name']}} @endif"  name="consignee_name" style="width: 219px;"/></div>
                <div class="ovh mt10  fl" style="margin-left: 53px;"><span class="add_left fl">收票人电话:</span><input type="text" value="@if(!empty($data['consignee_mobile_phone'])) {{ $data['consignee_mobile_phone']}} @endif" class="pay_text" name="consignee_mobile_phone" style="width: 219px;"/></div>
            </li>
            <li>
                <div class=" mt10 ml30 fl">
                    <span class="add_left fl">收票地址:</span>
                    <input type="text" readonly="readonly" name="address_ids" value="@if(!empty($data['address_ids'])) {{ $data['address_ids'] }} @endif " id="area2" style="display: none">
                    <input type="text" readonly="readonly" name="id" value="@if(!empty($data['id'])) {{ $data['id'] }} @endif" style="display: none">
                    <div class="ui-area fl" data-value-name="area1" data-value-id="area2" data-init-name="@if(!empty($data['address_str'])) {{ $data['address_str'] }} @endif" style="width: 343px;margin-left: 20px" id="test">
                    </div>
                </div>
            </li>
            <li>
                <div class="ovh mt10 ml30 fl mt20">
                    <span class="add_left fl">详细地址:</span>
                    <input type="text" class="pay_text fl" value="@if(!empty($data['consignee_address'])) {{ $data['consignee_address'] }} @endif " style="width: 587px;" name="consignee_address"/>
                    <span class="fl red ml10">*</span>
                </div>
            </li>



        </ul>

        <div class="ovh mb30 mt20" style="margin-left: 154px;">

        </div>
    </form>
    <button class="add_btn code_greenbg add_address whitebg">保 存</button><button class="add_btn cccbg ml35 cancel">取 消</button>
</div>


<script>
    $(function(){
        //	增加
        $('.add_address').click(function(){
            let input = $("#invoice_from").serialize();
            Ajax.call('/createInvoices', input, function(res){
                if (res.code == 1){
                    $.msg.alert(res.msg);
                    setTimeout( parent.location.reload(),2000);
                } else {
                    $.msg.alert(res.msg);
                    setTimeout( parent.location.reload(),2000);
                }
            },"POST","JSON");


        });
        $('.frame_close,.cancel').click(function(){
            parent.location.reload(); //刷新父亲对象（用于框架）
        })
    })

</script>

</body>
</html>




