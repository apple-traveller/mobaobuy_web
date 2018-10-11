@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/brand/list?currpage={{$currpage}}" class="s-back">返回</a>品牌 - 修改品牌</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="javascript:void(0);">通用信息</a></li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/brand/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;品牌名称：</div>
                                    <div class="label_value">
                                        <input type="text" name="brand_name" class="text" value="{{$brand['brand_name']}}" maxlength="40" autocomplete="off" id="brand_name">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;品牌首字母：</div>
                                    <div class="label_value">
                                        <input type="text" name="brand_first_char" class="text" value="{{$brand['brand_first_char']}}" maxlength="40" autocomplete="off" id="brand_first_char">
                                        <div class="form_prompt"></div>
                                        <div class="notic">请仔细填写品牌首字母</div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;品牌Logo：</div>
                                    <div class="label_value">
                                        <button type="button" class="layui-btn upload-file" data-type="" data-path="brand" >上传图片</button>
                                        <input type="text" value="{{$brand['brand_logo']}}" class="text"  name="brand_logo" style="display:none;">
                                        <img  @if(empty($brand['brand_logo'])) style="width:60px;height:60px;display:none;" @else style="width:60px;height:60px;" src="{{getFileUrl($brand['brand_logo'])}}"  @endif    class="layui-upload-img"><br/>
                                        <div class="form_prompt brand_logo"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>品牌描述：</div>
                                    <div class="label_value">
                                        <textarea id="brand_desc" name="brand_desc" rows="5" cols="40">{{$brand['brand_desc']}}</textarea>
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>排序：</div>
                                    <div class="label_value">
                                        <input type="text" name="sort_order" class="text text_2 valid" autocomplete="off" id="sort_order" value="{{$brand['sort_order']}}"/>
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>

                                <input type="hidden" name="id"  value="{{$brand['id']}}"/>
                                <input type="hidden" name="currpage"  value="{{$currpage}}"/>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>是否删除：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:30%;" name="is_delete" id="is_delete">
                                            <option @if($brand['is_delete']==0) selected @endif  value="0">否</option>
                                            <option @if($brand['is_delete']==1) selected @endif  value="1">是</option>
                                        </select>
                                    </div>
                                    <div class="form_prompt"></div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>是否推荐：</div>
                                    <div class="label_value">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:30%;" name="is_recommend" id="is_recommend">
                                            <option @if($brand['is_recommend']==0) selected @endif  value="0">否</option>
                                            <option @if($brand['is_recommend']==1) selected @endif  value="1">是</option>
                                        </select>
                                    <div class="form_prompt"></div>
                                </div>

                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" value=" 确定 " class="button" id="submitBtn">
                                        <input type="reset" value=" 重置 " class="button button_reset">
                                        <input type="hidden" name="id" value="{{$brand['id']}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;

            //文件上传
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
                            $(".brand_logo").remove();
                        }else{
                            layer.msg(res.msg, {time:2000});
                        }
                    }
                });
            });

        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    $("#article_form").submit();
                }
            });

            jQuery.validator.addMethod("isLetter", function(value,element,params) {
                var exp = new RegExp(params);//实例化正则对象，参数为传入的正则表达式
                return exp.test(value);
            }, "只能是一位大写字母");

            $('#article_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    brand_name :{
                        required : true,
                    },
                    brand_first_char :{
                        required : true,
                        isLetter : "[A-Z]"
                    },
                    category_links:{
                        required : true
                    },
                    brand_logo:{
                        required : true
                    },
                    brand_desc:{
                        required : true
                    },
                },
                messages:{
                    brand_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_first_char :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    brand_desc :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });
    </script>


@stop
