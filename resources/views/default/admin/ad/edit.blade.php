@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/ad/list" class="s-back">返回</a>广告图- 编辑广告图</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>带*号的为必填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/ad/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                           <input type="hidden" name="id" value="{{$ad['id']}}">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择广告位置：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="position_id" id="position_id">
                                        @foreach($ad_positions as $vo)
                                            <option @if($vo['id']==$ad['position_id']) selected @endif  value="{{$vo['id']}}">{{$vo['position_name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;名称：</div>
                                <div class="label_value">
                                    <input type="text" name="ad_name" class="text" value="{{$ad['ad_name']}}" maxlength="40" autocomplete="off" id="ad_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;广告链接：</div>
                                <div class="label_value">
                                    <input type="text" name="ad_link" class="text" value="{{$ad['ad_link']}}" maxlength="40" autocomplete="off" id="ad_link">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;排序：</div>
                                <div class="label_value">
                                    <input type="text" name="sort_order" class="text" value="{{$ad['sort_order']}}" maxlength="40" autocomplete="off" id="sort_order">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开始时间：</div>
                                <div class="label_value">
                                    <input type="text" name="start_time" value="{{$ad['start_time']}}" class="text"maxlength="40" autocomplete="off" id="start_time">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;结束时间：</div>
                                <div class="label_value">
                                    <input type="text" name="end_time" value="{{$ad['end_time']}}" class="text"  maxlength="40" autocomplete="off" id="end_time">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否nofollow：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_nofollow" id="is_nofollow">
                                        @if($ad['is_nofollow'])
                                            <option  value="{{$ad['is_nofollow']}}" selected="selected">是</option>
                                            <option  value="0">否</option>
                                        @else
                                            <option  value="{{$ad['is_nofollow']}}" selected="selected">否</option>
                                            <option  value="1">是</option>
                                        @endif
                                    </select>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field"></span>&nbsp;设置alt属性：</div>
                                <div class="label_value">
                                    <input type="text" name="alt_attr" class="text" value="{{$ad['alt_attr']}}" maxlength="40"  id="alt_attr">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div style="margin-top:10px;" class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上传图片：</div>
                                <div class="label_value">
                                    <button style="float: left;" type="button" class="layui-btn upload-file" data-type="" data-path="advertisement" ><i class="layui-icon">&#xe681;</i> 上传图片</button>
                                    <input type="text" id="ad_img" value="{{$ad['ad_img']}}" class="text"  name="ad_img" style="display:none;">
                                    <img @if(!empty($ad['ad_img'])) style="width:60px;height:60px;margin-left:10px;margin-top: -10px;" src="{{getFileUrl($ad['ad_img'])}}" @else style="width:60px;height:60px;display:none;" @endif  class="layui-upload-img"><br/>
                                    <div style="margin-left: 10px;line-height: 36px;" class="form_prompt"></div>
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
        layui.use(['laydate','layer','upload'], function() {
            var laydate = layui.laydate;
            var layer = layui.layer;
            var upload = layui.upload;
            var index;

            laydate.render({
                elem: '#start_time' //指定元素
                , type: 'datetime'
            });

            laydate.render({
                elem: '#end_time' //指定元素
                , type: 'datetime'
            });

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
                    position_id :{
                        required : true,
                    },
                    ad_name :{
                        required : true,
                    },

                    start_time:{
                        required : true,
                    },

                    ad_img:{
                        required : true,
                    }
                },
                messages:{
                    position_id:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    ad_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    start_time :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    ad_img :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
