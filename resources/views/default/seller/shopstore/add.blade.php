@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/seller/store" class="s-back">返回</a>店铺 - 添加店铺</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/store/save" method="post" enctype="multipart/form-data" name="theForm" id="store_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
                                <div class="label_value">
                                    <input type="text" name="store_name" class="text" value="" maxlength="40" autocomplete="off" id="store_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文店铺名称：</div>
                                <div class="label_value">
                                    <input type="text" name="store_name_en" class="text" value="" maxlength="40" autocomplete="off" id="store_name_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;主营品类：</div>
                                <div class="label_value">
                                    <input type="text" name="main_cat" class="text" value="" maxlength="40" autocomplete="off" id="main_cat">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;英文主营品类：</div>
                                <div class="label_value">
                                    <input type="text" name="main_cat_en" class="text" value="" maxlength="40" autocomplete="off" id="main_cat_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;主营品牌：</div>
                                <div class="label_value">
                                    <input type="text" name="main_brand" class="text" value="" maxlength="40" autocomplete="off" id="main_brand">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;英文主营品牌：</div>
                                <div class="label_value">
                                    <input type="text" name="main_brand_en" class="text" value="" maxlength="40" autocomplete="off" id="main_brand_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;规格：</div>
                                <div class="label_value">
                                    <input type="text" name="spec" class="text" value="" maxlength="40" autocomplete="off" id="spec">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;英文规格：</div>
                                <div class="label_value">
                                    <input type="text" name="spec_en" class="text" value="" maxlength="40" autocomplete="off" id="spec_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_area" class="text" value="" maxlength="40" autocomplete="off" id="delivery_area">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;英文交货地：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_area_en" class="text" value="" maxlength="40" autocomplete="off" id="delivery_area_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;交货方式：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_method" class="text" value="" maxlength="40" autocomplete="off" id="delivery_method">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;英文交货方式：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_method_en" class="text" value="" maxlength="40" autocomplete="off" id="delivery_method_en">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">商品图片：</div>
                                <div class="label_value">
                                    <button style="float: left;" type="button" class="layui-btn upload-file" data-type="" data-path="store" >
                                        <i class="layui-icon">&#xe681;</i> 上传图片
                                    </button>
                                    <input type="hidden" value="" class="text" id="store_img"  name="store_img" style="display:none;">
                                    <img  style="width:60px;height:60px;display:none;margin-top: -5px;margin-left:10px;" class="layui-upload-img">
                                    <div style="margin-left: 10px;line-height:40px;" class="form_prompt"></div>
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
                    store_name_en :{
                        required : true,
                    },
                },
                messages:{
                    store_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    store_name_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
            layui.use(['upload','layer'], function(){
                var upload = layui.upload;
                var layer = layui.layer;

                //文件上传
                upload.render({
                    elem: '.upload-file' //绑定元素
                    ,url: "/uploadImg" //上传接口
                    ,accept:'file'
                    ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                    }
                    ,done: function(res){
                        //上传完毕回调
                        if(1 == res.code){
                            var item = this.item;
                            item.siblings('input').attr('value', res.data.path);
                            item.siblings('img').show().attr('src', res.data.url);
                            item.siblings('div').filter(".form_prompt").remove();
                        }else{
                            layer.msg(res.msg, {time:2000});
                        }
                    }
                });
            });
        });
    </script>


@stop
