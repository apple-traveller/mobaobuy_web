@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper shop_special visible">
        <div class="title">系统设置 - 商店设置</div>
        <div class="content visible">
            <div class="tabs_info">
                <ul>
                    @foreach($topConfigs as $vo)
                    <li @if($parent_id==$vo['id'])class="curr" @endif><a  href="/admin/sysconfig/index?parent_id={{$vo['id']}}">{{$vo['name']}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i>
                    <h4>操作提示</h4>
                    <span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>商店相关信息设置，请谨慎填写信息。</li>
                </ul>
            </div>
            <div class="flexilist visible">
                <div class="mian-info visible">
                    <form enctype="multipart/form-data" name="theForm" action="/admin/sysconfig/modify" method="post" id="shopConfigForm" novalidate="novalidate" class="visible">
                        <div class="switch_info shopConfig_switch visible">

                            @foreach($childConfigs as $vo)
                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <input type="hidden" name="parent_id" value="{{$parent_id}}"/>
                            <div class="item shop_name" data-val="101">
                                <div class="label"><span class="require-field">*</span>{{$vo['name']}}：</div>
                                <div class="label_value">
                                    @if($vo['type']=='text')
                                        <input name="{{$vo['code']}}" id="{{$vo['code']}}" class="text shop_name" value="{{$vo['value']}}" autocomplete="off" type="text">
                                        <div class="form_prompt"></div>
                                        <div class="notic">{{$vo['config_desc']}}</div>
                                    @elseif($vo['type']=='select')
                                        @php
                                        $items = explode(',', $vo['store_range']);
                                        @endphp

                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;width:30%;" name="{{$vo['code']}}" id="{{$vo['code']}}">
                                        @foreach($items as $item)
                                            @php
                                                $arr = explode('|', $item);
                                            @endphp
                                            <option @if($vo['value'] == $arr[0]) selected @endif value="{{$arr[0]}}">{{$arr[1]}}</option>
                                        @endforeach
                                        </select>
                                    @elseif($vo['type']=='textarea')
                                        <textarea class="textarea"  name="{{$vo['code']}}" id="{{$vo['code']}}">{{$vo['value']}}</textarea>
                                        <div class="form_prompt"></div>
                                        <div class="notic">{{$vo['config_desc']}}</div></div>
                                    @elseif($vo['type']=='file')
                                        <button type="button" class="layui-btn" id="avatar_{{$vo['code']}}">上传图片</button>
                                        <input type="text" value="{{$vo['value']}}" class="text" id="{{$vo['code']}}" name="{{$vo['code']}}"  style="display:none;">
                                        <img @if(empty($vo['value'])) style="width:60px;height:60px;display:none;" @else style="width:60px;height:60px;" src="{{$vo['value']}}"  @endif   class="layui-upload-img" id="demo1" ><br/>
                                    @endif
                                </div>
                            </div>
                            @endforeach


                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    <input value=" 确定 " ectype="btnSubmit" class="button" type="submit">
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
            var uploadInst = upload.render({
                elem: '#avatar_shop_logo' //绑定元素
                ,url: "{{url('/uploadImg')}}" //上传接口
                ,accept:'file'
                ,data:{'_token':tag_token}
                ,done: function(res){
                    //上传完毕回调
                    if(200 == res.code){
                        $('#demo1').show();
                        $('#shop_logo').val(res.data);
                        $('#demo1').attr('src', res.data);
                        layer.msg(res.msg, {time:2000});
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }

            });

            //文件上传
            var uploadInst = upload.render({
                elem: '#avatar_icp_file' //绑定元素
                ,url: "{{url('/uploadImg')}}" //上传接口
                ,accept:'file'
                ,data:{'_token':tag_token}
                ,done: function(res){
                    //上传完毕回调
                    if(200 == res.code){
                        $('#demo1').show();
                        $('#icp_file').val(res.data);
                        $('#demo1').attr('src', res.data);
                        layer.msg(res.msg, {time:2000});
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }

            });

        });

        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#shopConfigForm").valid()){
                    $("#shopConfigForm").submit();
                }
            });


            $('#shopConfigForm').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    shop_name :{
                        required : true,
                    },
                    shop_title :{
                        required : true
                    },
                    shop_desc:{
                        required : true
                    },
                    shop_keywords:{
                        required : true
                    },
                    service_phone:{
                        required : true
                    },
                    service_email:{
                        required : true
                    },
                    shop_logo:{
                        required : true
                    },
                    copyright:{
                        required : true
                    },
                    powered_by:{
                        required : true
                    },
                    close_comment:{
                        required : true
                    },
                    stats_code:{
                        required:true
                    }
                },
                messages:{
                    shop_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'平台名称不能为空'
                    },
                    shop_title :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'平台标题不能为空'
                    },
                    shop_desc:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'平台描述不能为空'
                    },
                    shop_keywords:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'平台关键字不能为空'
                    },
                    close_comment:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'关闭原因不能为空'
                    },
                    stats_code:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'统计代码不能为空'
                    }
                }
            });
        });
    </script>
@stop
