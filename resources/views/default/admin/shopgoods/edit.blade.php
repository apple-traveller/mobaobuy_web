@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shopgoods/list?currpage={{$currpage}}" class="s-back">返回</a>店铺 - 编辑店铺产品</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shopgoods/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择店铺：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="shop_id" id="shop_id">
                                        @foreach($shops as $vo)
                                            <option @if($shopGood['shop_id']==$vo['id']) selected @endif  value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择产品：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;float:left;" class="cat_id" >
                                        <option value="0">请选择分类</option>
                                        @foreach($goodsCatTree as $vo)
                                            <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;float:left;margin-left:20px;" class="goods_id" name="goods_id" id="goods_id">
                                        <option value="{{$shopGood['goods_name']}}">{{$shopGood['goods_name']}}</option>
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                                <input type="hidden" name="id" value="{{$shopGood['id']}}">
                                <input type="hidden" name="currpage" value="{{$currpage}}">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;产品库存数量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_number" class="text" value="{{$shopGood['goods_number']}}" maxlength="40" autocomplete="off" id="goods_number">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺售价：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_price" class="text" value="{{$shopGood['shop_price']}}" maxlength="40" autocomplete="off" id="shop_price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否在售：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="is_on_sale" id="is_super">
                                        <option @if($shopGood['is_on_sale']==0) selected @endif  value="0">否</option>
                                        <option @if($shopGood['is_on_sale']==1) selected @endif value="1">是</option>
                                    </select>
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
        $(".cat_id").change(function(res){
            $(".goods_id").children('option').remove();
            var cat_id = $(this).val();
            $.post('/admin/shopgoods/getGoods',{'cat_id':cat_id},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".goods_id").append('<option value="'+data[i]['id']+'">'+data[i]['goods_name']+'</option>');
                    }
                }else{
                    $(".goods_id").append('<option value="0">该分类下没有产品</option>');
                }
            },"json");
        });
        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    shop_price :{
                        required : true,
                    },
                    goods_number :{
                        required : true,
                    },
                    goods_id:{
                        required : true,
                    }
                },
                messages:{
                    shop_price:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>


@stop
