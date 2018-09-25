@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shop/list" class="s-back">返回</a>产品 - 添加入驻店铺</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shop/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_name" class="text" value="" maxlength="40" autocomplete="off" id="shop_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;企业全称：</div>
                                <div class="label_value">
                                    <input type="text" name="company_name" class="text" value="" maxlength="40" autocomplete="off" id="company_name">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="contactName" class="text" value="" maxlength="40" autocomplete="off" id="contactName">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>负责人手机：</div>
                                <div class="label_value">
                                    <input type="text" name="contactPhone" class="text" value="" maxlength="40" autocomplete="off" id="contactPhone">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>授权委托书电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn layui-btn-sm" style="float:left;margin-right:10px;" id="avatar_attorney_letter_fileImg">上传图片</button>
                                    <input type="hidden"  value="" class="text" id="attorney_letter_fileImg" name="attorney_letter_fileImg" >
                                    <img  style="width:30px;height:30px;display:none;float:left;margin-right:10px;" class="layui-upload-img" id="demo_attorney_letter_fileImg " >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn layui-btn-sm" style="float:left;margin-right:10px;" id="avatar_license_fileImg">上传图片</button>
                                    <input type="hidden"  value="" class="text" id="license_fileImg" name="license_fileImg" >
                                    <img  style="width:30px;height:30px;display:none;float:left;margin-right:10px;" class="layui-upload-img" id="demo_license_fileImg" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;产品属性：</div>
                                <div class="label_value">
                                    <div class="attribute"></div>
                                    <input type="hidden" id="goods_attr" name="goods_attr">
                                    <div class="form_prompt"></div>
                                    <div class="layui-btn attr-btn"  style="margin-top:5px;">
                                        <i class="layui-icon">&#xe608;</i> 添加属性
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;市场价：</div>
                                <div class="label_value">
                                    <input type="text" name="market_price" class="text" value="" maxlength="40" autocomplete="off" id="market_price">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;产品重量：</div>
                                <div class="label_value">
                                    <input type="text" name="goods_weight" class="text" value="" maxlength="40" autocomplete="off" id="goods_weight">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;pc商品详情：</div>
                                <div class="label_value">
                                    <script id="goods_desc" name="goods_desc" type="text/plain"></script>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;移动端商品详情：</div>
                                <div class="label_value">
                                    <script id="desc_mobile" name="desc_mobile" type="text/plain"></script>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
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
    <script type="text/javascript" src="{{asset(themePath('/').'ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset(themePath('/').'ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('goods_desc',{
            initialFrameWidth : '100%',//宽度
            initialFrameHeight: 500//高度
        });
        var ue2 = UE.getEditor('desc_mobile',{
            initialFrameWidth : '100%',//宽度
            initialFrameHeight: 500//高度
        });
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();

        layui.use(['upload','layer'], function() {
            var upload = layui.upload;
            var layer = layui.layer;
            var index = 0;

            //添加属性
            $(".attr-btn").click(function () {
                index = layer.open({
                    type: 1,
                    title: '添加属性',
                    area: ['500px', '300px'],
                    content: '<div style="position: relative;"> <input  type="text"  attr-id="" style="margin-left:20px;width:130px;" placeholder="属性名" class="text attr_name" />' +
                    '<ul class="query" style="position: absolute;top: 30px;left:20px;background: #fff;width: 152px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul>' +
                    '<input type="text" attr-value-id=""  style="width:130px;" placeholder="属性值" class="text attr_value" >' +
                    '<ul class="query1" style="position: absolute;top: 30px;left: 188px;background: #fff;width: 144px; box-shadow: 1px 1px 1px 1px #dedede;">' +
                    '</ul></div>' +
                    '<div><button  class="layui-btn layui-btn-sm layui-btn-danger">确定</button></div>'
                });

            });

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar1' //绑定元素
                , url: "/uploadImg" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $("#demo1").show();
                        $('#goods_thumb').val(res.data);
                        $("#demo1").attr('src', res.data);
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
                    }
                }
            });

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar2' //绑定元素
                , url: "/uploadImg" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $("#demo2").show();
                        $('#goods_img').val(res.data);
                        $("#demo2").attr('src', res.data);
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
                    }
                }
            });

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar3' //绑定元素
                , url: "/uploadImg" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $("#demo3").show();
                        $('#original_img').val(res.data);
                        $("#demo3").attr('src', res.data);
                        layer.msg(res.msg, {time: 2000});
                    } else {
                        layer.msg(res.msg, {time: 2000});
                    }
                }
            });
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
                    goods_name :{
                        required : true,
                    },
                    goods_sn :{
                        required : true,
                    },
                    keywords:{
                        required : true
                    },
                    brand_id:{
                        required : true
                    },
                    unit_id:{
                        required : true
                    },
                    goods_model:{
                        required : true
                    },
                    packing_spec:{
                        required : true,
                        number:true,
                    },
                    packing_unit:{
                        required : true
                    },
                    goods_thumb:{
                        required : true
                    },
                    goods_img:{
                        required : true
                    },
                    original_img:{
                        required : true
                    },
                    market_price:{
                        required : true,
                        number:true
                    },
                    goods_weight:{
                        required : true,
                        number:true
                    },
                    goods_attr:{
                        required:true
                    }
                },
                messages:{
                    goods_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_sn :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    unit_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_model :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    packing_spec :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    packing_unit :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_thumb :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    goods_img :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    original_img :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    market_price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_weight :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_attr :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'不能为空',
                    },

                }
            });
        });
    </script>


@stop
