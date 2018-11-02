@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        [class^="icon-"], [class*=" icon-"] {
            line-height: 23px;
        }
        .Self-product-list li span{width:14%;}
        .news_pages ul.pagination {text-align: center;}
        .Self-product-list li span{width: 12.5%;float: left;text-align: center;}
        .pro_detail{overflow: hidden;}
        .pur_volume{float:left;border: 1px solid #DEDEDE; box-sizing:border-box;}
        .pur_volume .pur{cursor:pointer;width: 26px;text-align: center;float: left;height: 28px;line-height: 28px;background-color: #fafafa;box-sizing:border-box;}
        .pur_num{float:left;width: 50px;height: 28px;line-height: 28px;text-align: center;border: none;}

    </style>
@endsection
@section('body')
    @include('partials.base_header')
    <script src="{{asset(themePath('/').'js/jquery.validation.min.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/dsc_admin2.0.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
    <link rel="stylesheet" type="text/css" href="/ui/area/1.0.0/area.css" />
    <script type="text/javascript" src="/ui/area/1.0.0/area.js"></script>
    <div class="warpper">
        <div class="title"><a href="/seller/activity/promoter?currentPage={{$currentPage}}" class="s-back">返回</a>促销活动</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/activity/savePromoter" method="post" name="theForm" id="promote_form" novalidate="novalidate">
                        <input type="text" value="@if(!empty($promote_info)){{$promote_info['id']}}@endif" name="id" style="display: none">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商品：</div>
                                <div class="label_value">

                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" class="cat_id" >
                                        <option value="0">请选择分类</option>
                                        @foreach($goodsCatTree as $vo)
                                            <option @if(!empty($good) && $good['cat_id']==$vo['id'])  selected @endif  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-left: 20px;" class="goods_id" name="goods_id" id="goods_id">
                                        <option value="">请选择商品</option>
                                        @foreach($goods as $vo)
                                            <option @if(!empty($promote_info)) @if($promote_info['goods_id']==$vo['id']) selected @endif @endif value="{{$vo['id']}}" data-num="{{$vo['packing_spec']}}">{{$vo['goods_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                    <div class="notic">分类用于辅助选择商品</div>
                                </div>

                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开始时间：</div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="start_date" id="start_date" @if(!empty($promote_info)) value="{{$promote_info['begin_time'][0]}}" @endif>
                                </div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input"  name="start_time" id="start_time" @if(!empty($promote_info))value="{{$promote_info['begin_time'][1]}}" @endif>
                                </div>
                                <div class="form_prompt"></div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;结束时间：</div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input"  name="end_date" id="end_date" @if(!empty($promote_info)) value="{{$promote_info['end_time'][0]}}" @endif>
                                </div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input"  name="end_time" id="end_time" @if(!empty($promote_info)) value="{{$promote_info['end_time'][1]}}" @endif>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;促销价格：</div>
                                <div class="label_value">
                                    <input type="number" name="price" class="text" value="@if(!empty($promote_info)){{$promote_info['price']}}@endif" maxlength="10" autocomplete="off" id="price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;促销总数量：</div>
                                <div class="label_value">
                                    <input type="number" name="num" class="text" value="@if(!empty($promote_info)){{$promote_info['num']}}@endif" maxlength="5"  autocomplete="off" id="num">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最小起售量：</div>
                                <div class="label_value">
                                    <div class="pro_detail">
                                        <div class="pur_volume ml15">
                                            <span class="pur bbright">-</span>
                                            <input type="text" name="min_limit" class="pur_num" value="@if(!empty($promote_info)){{$promote_info['min_limit']}}@endif" id="min_limit"/>
                                            <span class="pur bbleft">+</span>
                                        </div>
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最大限购量：（0 不限）</div>
                                <div class="label_value">
                                    <div class="pro_detail">
                                        <div class="pur_volume ml15"><span class="pur bbright">-</span>
                                            <input type="text" name="max_limit" class="pur_num" value="@if(!empty($promote_info)){{$promote_info['max_limit']}}@endif" id="max_limit"/>
                                            <span class="pur bbleft">+</span>
                                        </div>
                                    </div>
                                    <div class="form_prompt"></div>
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
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        layui.use('laydate', function() {
            var laydate = layui.laydate;

            laydate.render({
                elem: '#start_date'
            });

            laydate.render({
                elem: '#start_time'
                ,type: 'time'
            });
            laydate.render({
                elem: '#end_date'
            });

            laydate.render({
                elem: '#end_time'
                ,type: 'time'
            });
        });
        $(".cat_id").change(function(res){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/seller/goods/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        if (i==0){
                            $(".goods_id").append('<option selected value="'+data[i]['id']+'" data-num="'+data[i]['packing_spec']+'">'+data[i]['goods_name']+'</option>');
                            $("#min_limit").val(data[i]['packing_spec']);
                        } else {
                            $(".goods_id").append('<option value="'+data[i]['id']+'" data-num="'+data[i]['packing_spec']+'">'+data[i]['goods_name']+'</option>');
                            $("#min_limit").val(data[i]['packing_spec']);
                        }

                    }
                }else{
                    $(".goods_id").append('<option value="">该分类下没有商品</option>');
                }
            },"json");
        });
        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#promote_form").valid()){
                    $("#promote_form").submit();
                }
            });
            $('#promote_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    price :{
                        required : true,
                        number:true
                    },
                    num :{
                        required : true,
                        number:true
                    },
                    goods_id:{
                        required : true,
                        number:true
                    },
                    start_date:{
                        required:true
                    },
                    end_date:{
                        required:true
                    }
                },
                messages:{
                    price:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    start_date :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    end_date :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });

            // 限制商品总数
            $("#num").change(function () {
                let spec = Number($("select[name=goods_id] option:selected").attr('data-num'));
                let num = Number($(this).val());
                let b_num = num % spec;
                if (isNaN(spec)){
                    layer.msg('请先选择商品');
                    $(this).val('');
                }
                if (b_num >0){
                    $(this).val(num-b_num);
                    layer.msg('商品总量只能是产品规格的倍数');
                }
            });

            // 减
            $(".bbright").click(function(){
                let spec = Number($("select[name=goods_id] option:selected").attr('data-num'));
                let num = Number($(this).siblings('.pur_num').val());
                let b_num = num % spec;
                if (isNaN(spec)){
                    layer.msg('请先选择商品');
                    $(this).val('');
                }
                if (isNaN(num) || num<0){
                    $(this).siblings('.pur_num').val('');
                } else {
                    if (num-spec<0){
                        $(this).siblings('.pur_num').val(0);
                    } else {
                        if (num-spec-b_num>0){
                            $(this).siblings('.pur_num').val(num-spec-b_num);
                        } else{
                            $(this).siblings('.pur_num').val(num-spec-b_num);
                        }

                    }
                }
            });

            // 加
            $(".bbleft").click(function(){
                var _num;
                let tota_num = Number($("#num").val());
                let spec = Number($("select[name=goods_id] option:selected").attr('data-num'));
                let num = Number($(this).siblings('.pur_num').val());
                let b_num = num % spec;
                if (isNaN(spec)){
                    layer.msg('请先选择商品');
                    $(this).val('');
                }
                if (isNaN(tota_num) || tota_num <=0 ){
                    layer.msg('请先填写商品总数');
                    $(this).val('');
                }
                _num = num+spec;
                if (_num>=tota_num){
                     $(this).siblings('input').val(tota_num);
                }
                if (b_num>0){
                    $(this).siblings('input').val(_num-b_num);
                } else {
                    $(this).siblings('input').val(_num);
                }
            });
        });

        $(".pur_num").change(function () {
            let spec = Number($("select[name=goods_id] option:selected").attr('data-num'));
            let num = Number($(this).val());
            let b_num = num % spec;
            if (isNaN(spec)){
                layer.msg('请先选择商品');
                $(this).val('');
            }
            if (b_num >0){
                $(this).val(num-b_num);
            }
        });

    </script>


@stop
