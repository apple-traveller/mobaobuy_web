@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/articlecat/list" class="s-back">返回</a>文章 - 添加分类</div>
        <div class="content">

            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="/admin/articlecat/save" method="post" name="theForm" enctype="multipart/form-data" id="category_info_form" novalidate="novalidate">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;分类名称：</div>
                                    <div class="label_value">
                                        <input type="text" name="cat_name" class="text" id="cat_name" maxlength="20" value="" size="27">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">上级分类：</div>
                                    <div class="label_value">

                                            <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="parent_id" id="parent_id">
                                                <option value="0">顶级分类</option>
                                                @foreach($catesTree as $cates)
                                                <option @if($cates['id']==$parent_id) selected @endif value="{{$cates['id']}}">|<?php echo str_repeat('-->',$cates['level']).$cates['cat_name'];?></option>
                                                @endforeach
                                            </select>

                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">排序：</div>
                                    <div class="label_value">
                                        <input type="text" class="text text_4 valid" name="sort_order" id="sort_order" value="50" size="15" autocomplete="off" aria-invalid="false">
                                    </div>
                                </div>
                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>

                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" value=" 确定 " class="button" id="submitBtn">
                                        <input type="reset" value=" 重置 " class="button button_reset">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#category_info_form").valid()){
                    $("#category_info_form").submit();
                }
            });
            jQuery.validator.addMethod("specialchar", function(value, element) {
                return this.optional(element) || !/[@'\\"#$%&\^*]/.test(value);
            },("不能包含特殊字符"));

            $('#category_info_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    cat_name :{
                        required : true,
                        specialchar:""
                    },
                },
                messages:{
                    cat_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'分类名称不能为空'
                    },
                }
            });
        });
    </script>

@stop
