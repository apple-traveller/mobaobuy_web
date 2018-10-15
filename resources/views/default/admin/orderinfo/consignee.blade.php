@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">订单 - 编辑订单</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>添加订单流程为：选择商城已有会员-选择商品加入订单-确认订单金额-填写收货信息-添加配送方式-选择支付方式-添加发票-查看费用信息-完成。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form name="theForm" action="/admin/orderinfo/save" method="post" id="consignee" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="step_title pb5">
                                <i class="ui-step"></i>
                                <h3 class="fl">请填写收货信息</h3>
                            </div>


                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>收货人：</div>
                                    <div class="label_value">
                                        <input type="text" name="consignee" value="{{$consigneeInfo['consignee']}}" id="consignee" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>所在地区：</div>
                                    <div class="label_value">
                                        <div class="level_linkage">
                                            <div id="dlCountry" class="ui-dropdown smartdropdown alien" style="z-index: 99;">
                                                <select style="font-size:14px;height:32px;border:1px solid #dbdbdb;line-height:30px;float:left;width:150px;" name="country" id="country">
                                                    <option value="">请选择国家</option>
                                                    @foreach($countrys as $v)
                                                        <option @if($consigneeInfo['country']==$v['region_id']) selected @endif  value="{{$v['region_id']}}">{{$v['region_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form_prompt"></div>
                                            </div>
                                            <div id="dlProvinces" class="ui-dropdown smartdropdown alien" style="z-index: 99;">
                                                <select style="font-size:14px;height:32px;border:1px solid #dbdbdb;line-height:30px;float:left;width:150px;" name="province" id="province">
                                                    <option value="">请选择省份</option>
                                                    @foreach($provinces as $v)
                                                        <option @if($consigneeInfo['province']==$v['region_id']) selected @endif  value="{{$v['region_id']}}">{{$v['region_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form_prompt"></div>
                                            </div>
                                            <div id="dlCity" class="ui-dropdown smartdropdown alien" style="z-index: 98;">
                                                <select style="font-size:14px;height:32px;border:1px solid #dbdbdb;line-height:30px;float:left;width:150px;" name="city" id="city">
                                                    <option value="">请选择城市</option>
                                                    @foreach($citys as $v)
                                                        <option @if($consigneeInfo['city']==$v['region_id']) selected @endif  value="{{$v['region_id']}}">{{$v['region_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form_prompt"></div>
                                            </div>
                                            <div id="dlDistrict" class="ui-dropdown smartdropdown alien" style="z-index: 97;">
                                                <select style="font-size:14px;height:32px;border:1px solid #dbdbdb;line-height:30px;float:left;width:150px;" name="district" id="district">
                                                    <option value="">请选择区域</option>
                                                    @foreach($districts as $v)
                                                        <option @if($consigneeInfo['district']==$v['region_id']) selected @endif  value="{{$v['region_id']}}">{{$v['region_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form_prompt"></div>
                                            </div>
                                        </div>
                                        <div class="notic">请按从左到右的顺序添加</div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{$id}}">
                                 <input type="hidden" name="currpage" value="{{$currpage}}">
                                 
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>收货地址：</div>
                                    <div class="label_value">
                                        <input type="text" name="address" id="address" value="{{$consigneeInfo['address']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">邮政编码：</div>
                                    <div class="label_value"><input type="text" name="zipcode" id="zipcode" value="{{$consigneeInfo['zipcode']}}" class="text" autocomplete="off"></div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>手机号码：</div>
                                    <div class="label_value">
                                        <input type="text" name="mobile_phone" id="mobile" value="{{$consigneeInfo['mobile_phone']}}" class="text" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>


                            </div>

                        <div style="margin-top:-42px;margin-right:166px;" class="goods_btn">
                            <input type="button" value="取消" class="btn btn35 btn_blue" onclick="location.href='/admin/orderinfo/detail?id={{$id}}&currpage={{$currpage}}'">
                            <input  type="submit" class="btn btn35 blue_btn" value=" 确定 " id="submitBtn">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#dlCountry select").change(function(){
            var id = $(this).val();
            $.post('/admin/region/linkage',{'id':id},function(res){
                if(res.code==200){
                    $("#dlProvinces select").children("option").remove();//先删除子类元素
                    $("#dlCity select").children("option").remove();//先删除子类元素
                    $("#dlDistrict select").children("option").remove();//先删除子类元素
                    $("#dlProvinces select").append('<option value="">请选择省份</option>');
                    var arr = res.data;
                    for(var i=0;i<arr.length;i++){
                        $("#dlProvinces select").append('<option  value="'+arr[i]['region_id']+'">'+arr[i]['region_name']+'</option>');
                    }
                }else{
                    $("#dlProvinces select").append('<option  value="">未获取到数据</option>');
                }
            },"json");
        });

        $("#dlProvinces select").change(function(){
            var id = $(this).val();
            $.post('/admin/region/linkage',{'id':id},function(res){
                if(res.code==200){
                    $("#dlCity select").children("option").remove();//先删除子类元素
                    $("#dlDistrict select").children("option").remove();//先删除子类元素
                    $("#dlCity select").append('<option value="">请选择城市</option>');
                    var arr = res.data;
                    for(var i=0;i<arr.length;i++){
                        $("#dlCity select").append('<option  value="'+arr[i]['region_id']+'">'+arr[i]['region_name']+'</option>');
                    }
                }else{
                    $("#dlCity select").append('<option  value="">未获取到数据</option>');
                }
            },"json");
        });
        $("#dlCity select").change(function(){
            var id = $(this).val();
            $.post('/admin/region/linkage',{'id':id},function(res){
                if(res.code==200){
                    $("#dlDistrict select").children("option").remove();//先删除子类元素
                    $("#dlDistrict select").append('<option value="">请选择区域</option>');
                    var arr = res.data;
                    for(var i=0;i<arr.length;i++){
                        $("#dlDistrict select").append('<option  value="'+arr[i]['region_id']+'">'+arr[i]['region_name']+'</option>');
                    }
                }else{
                    $("#dlDistrict select").append('<option  value="">未获取到数据</option>');
                }
            },"json");
        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#consignee").valid()){
                    $("#consignee").submit();
                }
            });

            $('#consignee').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    mobile_phone :{
                        required : true,
                    },
                    address :{
                        required : true
                    },
                    consignee:{
                        required : true,
                    },
                    country :{
                        required : true,
                    },
                    province :{
                        required : true,
                    },
                    city :{
                        required : true,
                    },


                },
                messages:{
                    mobile_phone:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    address :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    consignee :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    country :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'国家为必填项',
                    },
                    province :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'省份为必填项',
                    },
                    city :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'城市必填项',
                    },

                }
            });
        });
    </script>
@stop
