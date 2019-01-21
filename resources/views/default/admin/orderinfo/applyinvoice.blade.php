@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/admin/orderinfo/list?currpage={{$currpage}}&order_status={{$order_status}}" class="s-back">返回</a>订单 - 申请开票</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>申请开票</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/orderinfo/saveApplyInvoice" method="post" enctype="multipart/form-data" name="theForm" id="store_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <input type="hidden" name="order_id" value="{{$order_id}}"/>
                            <input type="hidden" name="u_id" value="{{$u_id}}"/>
                            <input type="hidden" name="currpage" value="{{$currpage}}"/>
                            <input type="hidden" name="order_status" value="{{$order_status}}"/>
                            @if($user_invoice_info['is_firm'])
                                <div class="item">
                                    <div class="label">公司名称：</div>
                                    <div class="label_value">
                                        {{ $user_invoice_info['company_name'] }}
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">税号：</div>
                                    <div class="label_value">
                                        {{ $user_invoice_info['tax_id'] }}
                                    </div>
                                </div>
                                @if($user_invoice_info['is_special'])
                                    <div class="item">
                                        <div class="label">开户行：</div>
                                        <div class="label_value">
                                            {{ $user_invoice_info['bank_of_deposit'] }}
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">银行账号：</div>
                                        <div class="label_value">
                                            {{ $user_invoice_info['bank_account'] }}
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">开票电话：</div>
                                        <div class="label_value">
                                            {{ $user_invoice_info['company_telephone'] }}
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="label">开票地址：</div>
                                        <div class="label_value">
                                            {{ $user_invoice_info['company_address'] }}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="item">
                                    <div class="label">发票抬头：</div>
                                    <div class="label_value">
                                        个人
                                    </div>
                                </div>
                            @endif
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择收票地址：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="address_id" id="address_id">
                                        @foreach($address_list as $k=>$v)
                                            <option value="{{$v['id']}}">{{$v['country']}}-{{$v['province']}}-{{$v['city']}}-{{$v['district']}} {{$v['address']}}</option>
                                        @endforeach
                                    </select>
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input type="submit" value="确定" class="button" id="submitBtn">
                                    <input type="reset" value="重置" class="button button_reset">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="step">
                        <div class="tit"><h2>开票商品信息：</h2></div>
                        <table class="m-table mt20">
                            <thead>
                            <tr>
                                <th width="10%">序号</th>
                                <th width="35%">商品名称</th>
                                <th width="20%">单价（元）</th>
                                <th width="20%">数量</th>
                                <th width="15%">小计</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order_goods_list as $k=>$v)
                                <tr class="">
                                    <td align="center">
                                        <p>
                                            {{$k+1}}
                                        </p>
                                    </td>
                                    <td align="center">
                                        <p>
                                            {{$v['goods_name']}}
                                        </p>
                                    </td>
                                    <td align="center">
                                        <p>
                                            ￥{{$v['goods_price']}}/{{$v['unit_name']}}
                                        </p>
                                    </td>
                                    <td align="center">
                                        <p>
                                            {{$v['goods_number']}}{{$v['unit_name']}}
                                        </p>
                                    </td>
                                    <td align="center">
                                        <p>
                                            ￥{{$v['goods_price']*$v['goods_number']}}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#store_form").valid()){
                    $("#store_form").submit();
                }
            });

            $('#store_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    store_name :{
                        required : true,
                    },

                },
                messages:{
                    store_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });
        // 商家 请求所有的商家数据
//        function getShopList(_id){
//            $.ajax({
//                url: "/admin/shop/ajax_list",
//                dataType: "json",
//                data:{},
//                type:"POST",
//                success:function(res){
//                    if(res.code==1){
//                        let data = res.data;
//                        for(let i=0;i<data.length;i++){
//                            if(_id == data[i].id){
//                                $("#shop_id").append('<option value="'+data[i].id+'" selected>'+data[i].company_name+'</option>');
//                            }else{
//                                $("#shop_id").append('<option value="'+data[i].id+'">'+data[i].company_name+'</option>');
//                            }
//
//                        }
//                    }
//                }
//            })
//        }
    </script>


@stop
