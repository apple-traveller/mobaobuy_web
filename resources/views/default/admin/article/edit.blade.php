@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <div class="warpper">
        <div class="title"><a href="/admin/article/list?currpage={{$currpage}}" class="s-back">返回</a>文章 - 编辑文章</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="javascript:void(0);">通用信息</a></li>
                    <li class=""><a href="javascript:void(0);">文章内容</a></li>
                </ul>
            </div>
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>请注意选择文章分类；请严谨描述文章内容。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                    <li>输入关键字时请用逗号隔开。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/article/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章标题：</div>
                                <div class="label_value">
                                    <input type="text" name="title" class="text" value="{{$article['title']}}" maxlength="40" autocomplete="off" id="title">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$article['id']}}">
                            <!--  -->
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;文章分类：</div>
                                <div class="label_value">

                                    <select style="float:left;height:30px;border:1px solid #dbdbdb;line-height:30px;" name="cat_id" id="cat_id">

                                        @foreach($cateTrees as $vo)
                                            <option @if(isset($vo['hasChild'])) disabled="disabled"  @endif @if($vo['id']==$article['cat_id']) selected  @endif value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                                    <div style="float: left;margin-left: 10px;" class="notice">子分类才能被选中</div>

                                </div>
                            </div>

                            <div class="item">
                                <div class="label">是否显示：</div>
                                <div class="label_value">
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input type="radio" @if($article['is_show']==1) selected  @endif class="ui-radio" name="is_show" id="sex_3" value="1" checked>
                                            <label for="sex_3" class="ui-radio-label">显示</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" @if($article['is_show']==0) selected  @endif class="ui-radio" name="is_show" id="sex_4" value="0">
                                            <label for="sex_4" class="ui-radio-label">不显示</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="item">
                                <div class="label">文章作者：</div>
                                <div class="label_value"><input type="text" name="author" class="text" autocomplete="off" value="{{$article['author']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label">关键字：</div>
                                <div class="label_value"><input type="text" name="keywords" class="text" autocomplete="off" value="{{$article['keywords']}}"><div class="form_prompt"></div></div>

                            </div>
                            <div class="item">
                                <div class="label">网页描述：</div>
                                <div class="label_value">
                                    <textarea name="description" class="textarea">{{$article['description']}}</textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">排序：</div>
                                <div class="label_value"><input type="text" name="sort_order" class="text text_2 valid" autocomplete="off" id="sort_order" value="{{$article['sort_order']}}" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">外部链接：</div>
                                <div class="label_value"><input type="text" name="file_url" class="text valid" autocomplete="off" id="link_url" value="{{$article['file_url']}}" aria-invalid="false"></div>
                            </div>
                            <div class="item">
                                <div class="label">上传图片：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn upload-file" data-type="" data-path="article" >上传图片</button>
                                    <input type="text" value="{{$article['image']}}" class="text"  name="image" style="display:none;">
                                    <img @if(empty($article['image'])) style="width:60px;height:60px;display:none;" @else style="width:60px;height:60px;" src="{{getFileUrl($article['image'])}}"  @endif   class="layui-upload-img"><br/>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                        <div class="switch_info" style="display: none;">
                            <div class="item">
                                <script id="container" name="content" type="text/plain"><?php echo html_entity_decode($article['content']);?></script>

                                <div class="form_prompt"></div>
                            </div>
                        </div>
                        <input type="hidden" name="currpage" value="{{$currpage}}">
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

    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            initialFrameWidth : '100%',//宽度
            initialFrameHeight: 500//高度
        });
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
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


        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#article_form").valid()){
                    var content = ue.getContent();
                    if(content==""){
                        alert("文章内容不能为空");
                        return false;
                    }
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



                },
                messages:{
                    title:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'文章标题不能为空'
                    },
                    content:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'文章内容不能为空'
                    },


                }
            });
        });
    </script>

@stop
