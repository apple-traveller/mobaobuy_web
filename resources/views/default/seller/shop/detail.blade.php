@extends(themePath('.')."seller.include.layouts.master")
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/general.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/style.css')}}" />
@section('body')
    <div class="warpper">
        <div class="title">店铺资料</div>
        <div class="content">
            <div class="ecsc-form-goods" ectype="set_info">
                <form id="my_store_form" novalidate="novalidate" style="align-items: center">
                    <div class="wrapper-list" data-type="base" style="display: block;">
                        <input type="hidden" name="form_submit" value="ok">
                        <dl>
                            <dt>公司名称：</dt>
                            <dd><p style="line-height: 33px">{{$shop['company_name']}}</p></dd>
                        </dl>
                        {{--<dl>--}}
                            {{--<dt>入驻店铺名称：</dt>--}}
                            {{--<dd><input type="text" name="shop_name" value="{{$shop['shop_name']}}" disabled="disabled" size="40" class="text text_disabled"></dd>--}}
                        {{--</dl>--}}
                        <dl>
                            <dt>负责人姓名：</dt>
                            <dd><input type="text" name="contactName" readonly value="{{$shop['contactName']}}" class="text"></dd>
                        </dl>
                        <dl>
                            <dt>负责人手机：</dt>
                            <dd><input type="text" size="40" readonly value="{{$shop['contactPhone']}}" name="contactPhone" class="text"></dd>
                        </dl>
                        <dl>
                            <dt>纳税人识别号：</dt>
                            <dd><p style="line-height: 33px">{{$shop['taxpayer_id']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>营业执照注册号：</dt>
                            <dd><p style="line-height: 33px">{{$shop['business_license_id']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>授权委托书电子版：</dt>
                            <dd><div  path="{{getFileUrl($shop['attorney_letter_fileImg'])}}" class="layui-btn layui-btn-radius layui-btn-normal viewPic">点击查看</div></dd>
                        </dl>
                        <dl>
                            <dt>营业执照副本电子版：</dt>
                            <dd><div path="{{getFileUrl($shop['license_fileImg'])}}" class="layui-btn layui-btn-radius layui-btn-normal viewPic">点击查看</div></dd>
                        </dl>
                        <dl>
                            <dt>注册时间：</dt>
                            <dd><p style="line-height: 33px">{{$shop['reg_time']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>&nbsp;上次登录时间：</dt>
                            <dd><p style="line-height: 33px">{{$shop['last_time']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>上次登录IP：</dt>
                            <dd><p style="line-height: 33px">{{$shop['last_ip']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>&nbsp;拜访次数：</dt>
                            <dd><p style="line-height: 33px">{{$shop['visit_count']}}</p></dd>
                        </dl>
                        <dl>
                            <dt>是否通过审核：</dt>
                            <dd>
                                @if($shop['is_validated']==1)
                                    <div data_value="{{$shop['is_validated']}}" class="layui-btn layui-btn-radius  is_validate">已通过</div>
                                @else
                                    <div data_value="{{$shop['is_validated']}}" class="layui-btn layui-btn-radius layui-btn-warm layui-btn-danger is_validate">待审核</div>
                                @endif
                            </dd>
                        </dl>
                        <dl>
                            <dt>&nbsp;是否自营：</dt>
                            <dd>
                                <div class="label_value font14">{{status($shop['is_self_run'])}}</div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>是否冻结：</dt>
                            <dd>
                                <div class="label_value font14">{{status($shop['is_freeze'])}}</div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>结算银行开户名：</dt>
                            <dd><input type="text" name="settlement_bank_account_name" value="{{$shop['settlement_bank_account_name']}}" class="text"></dd>
                        </dl>
                        <dl>
                            <dt>结算公司银行账号：</dt>
                            <dd><input type="text" name="settlement_bank_account_number" value="{{$shop['settlement_bank_account_number']}}" class="text"></dd>
                        </dl>
                    <div class="wrapper-list" data-type="button">
                        <dl class="button_info">
                            <dt>&nbsp;</dt>
                            <dd>
                                <input type="submit" class="sc-btn sc-blueBg-btn btn35" value="提交" id="submitBtn">
                            </dd>
                        </dl>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        layui.use(['upload','layer'], function() {
            var layer = layui.layer;

            $(".viewPic").click(function(){
                var src = $(this).attr('path');
                index = layer.open({
                    type: 1,
                    title: '大图',
                    // area: ['700px', '600px'],
                    content: '<img src="'+src+'">'
                });
            });

        });
        $("#submitBtn").click(function () {
            let settlement_bank_account_name = $("input[name='settlement_bank_account_name']").val();
            let settlement_bank_account_number = $("input[name='settlement_bank_account_number']").val();
            let data = {};
            if (settlement_bank_account_name){
                data.settlement_bank_account_name = settlement_bank_account_name;
            }
            if (settlement_bank_account_number) {
                data.settlement_bank_account_number = settlement_bank_account_number;
            }
            if (data.length==0){
                return false;
            }
            console.log(data);
            $.ajax({
                url:'/seller/updateCash',
                data:data,
                type:'POST',
                success: function (res) {
                    if (res.code==1){
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                    window.location.reload();
                }
            });
        });
    </script>
@stop
