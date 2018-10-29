@extends(themePath('.')."seller.include.layouts.master")
@section('styles')
    <style>
        [class^="icon-"], [class*=" icon-"] {
            line-height: 23px;
        }
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
                                            <option @if(!empty($promote_info)) @if($promote_info['goods_id']==$vo['id']) selected @endif @endif value="{{$vo['id']}}">{{$vo['goods_name']}}</option>
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
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;结束时间：</div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input"  name="end_date" id="end_date" @if(!empty($promote_info)) value="{{$promote_info['end_time'][0]}}" @endif>
                                </div>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input"  name="end_time" id="end_time" @if(!empty($promote_info)) value="{{$promote_info['end_time'][1]}}" @endif>
                                </div>
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
                                    <input type="number" name="num" class="text" value="@if(!empty($promote_info)){{$promote_info['num']}}@endif" maxlength="5" autocomplete="off" id="num">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最小起售量：</div>
                                <div class="label_value">
                                    <input type="number" name="min_limit" class="text" value="@if(!empty($promote_info)){{$promote_info['min_limit']}}@endif" maxlength="5" autocomplete="off" id="min_limit">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最大限购量：（0 不限）</div>
                                <div class="label_value">
                                    <input type="number" name="max_limit" class="text" value="@if(!empty($promote_info)){{$promote_info['max_limit']}}@endif" maxlength="5" autocomplete="off" id="max_limit">
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
        })
        $(".cat_id").change(function(res){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/seller/goods/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".goods_id").append('<option value="'+data[i]['id']+'">'+data[i]['goods_name']+'</option>');
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
                    number :{
                        required : true,
                        number:true
                    },
                    goods_id:{
                        required : true,
                        number:true
                    },
                    min_limit:{
                        required:true,
                        number:true
                    },
                    max_limit:{
                        required:true,
                        number:true
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
                    min_limit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>


@stop
