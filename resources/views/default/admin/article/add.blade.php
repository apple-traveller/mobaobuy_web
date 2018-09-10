@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/article/list" class="s-back">返回</a>文章 - 添加新文章</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="javascript:void(0);">通用信息</a></li>
                    <li class=""><a href="javascript:void(0);">文章内容</a></li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/article/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章标题：</div>
                                <div class="label_value">
                                    <input type="text" name="title" class="text" value="" maxlength="40" autocomplete="off" id="title">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章分类：</div>
                                <div class="label_value">

                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:40%;" name="cat_id" id="cat_id">

                                            @foreach($cateTrees as $vo)
                                                <option  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                            @endforeach
                                        </select>

                                </div>
                            </div>

                            <div class="item">
                                <div class="label">是否显示：</div>
                                <div class="label_value">
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input type="radio" class="ui-radio" name="is_show" id="sex_3" value="1" checked>
                                            <label for="sex_3" class="ui-radio-label">显示</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" class="ui-radio" name="is_show" id="sex_4" value="0">
                                            <label for="sex_4" class="ui-radio-label">不显示</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>文章作者：</div>
                                <div class="label_value"><input type="text" name="author" class="text" autocomplete="off" value=""><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>关键字：</div>
                                <div class="label_value"><input type="text" name="keywords" class="text" autocomplete="off" value=""><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>网页描述：</div>
                                <div class="label_value">
                                    <textarea name="description" class="textarea"></textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">排序：</div>
                                <div class="label_value"><input type="text" name="sort_order" class="text text_2 valid" autocomplete="off" id="sort_order" value="50" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">外部链接：</div>
                                <div class="label_value"><input type="text" name="file_url" class="text valid" autocomplete="off" id="link_url" value="http://" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">上传图片：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn" id="avatar">上传图片</button>
                                    <input type="text"  class="text" id="image" name="image"  style="display:none;">
                                    <img  style="width:60px;height:60px;display:none;"   class="layui-upload-img" id="demo1" ><br/>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                        <div class="switch_info" style="display: none;">
                            <div class="item">
                                <script id="container" name="content" type="text/plain"></script>

                                <div class="form_prompt"></div>
                            </div>
                        </div>

                        <div class="info_btn info_btn_bf100 button-info-item0" id="info_btn_bf100">
                            <div class="label">&nbsp;</div>
                            <div class="value">
                                <input type="submit" value=" 确定 " class="button mr10" id="submitBtn">
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
        var ue = UE.getEditor('container',{
            initialFrameWidth : '100%',//宽度
            initialFrameHeight: 500//高度
        });
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
        layui.use(['upload','layer'], function() {
            var upload = layui.upload;
            var layer = layui.layer;

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar' //绑定元素
                , url: "{{url('/uploadImg')}}" //上传接口
                , accept: 'file'
                , data: {'_token': tag_token}
                , done: function (res) {
                    //上传完毕回调
                    if (200 == res.code) {
                        $('#demo1').show();
                        $('#image').val(res.data);
                        $('#demo1').attr('src', res.data);
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
                rules:{
                    title :{
                        required : true,
                    },
                    content :{
                        required : true,
                    },
                    author :{
                        required : true,
                    },
                    keywords :{
                        required : true,
                    },


                },
                messages:{
                    title:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'文章标题不能为空'
                    },
                    content:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'文章内容不能为空'
                    },
                    author:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'文章作者不能为空'
                    },
                    keywords:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'关键字不能为空'
                    },

                }
            });
        });
    </script>

@stop
