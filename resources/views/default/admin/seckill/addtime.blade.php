@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <div class="warpper">
        <div class="title"><a href="/admin/seckill/time/list" class="s-back">返回</a>秒杀 - 添加秒杀活动时间段</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>第一次新增秒杀时间段可对开始时间进行修改，以后默认为上一时段结束时间的后一秒。</li>
                    <li>秒杀时段名称将会显示在秒杀列表页的时间段内。</li>
                    <li>编辑秒杀结束时段时不会影响到下一秒杀时段开始时间，结束时间不得小于当前时段开始时间&不得大于下一时段结束时间。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/seckill/time/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;秒杀时段标题：</div>
                                <div class="label_value">
                                    <input type="text" name="title" class="text" value="" maxlength="40" autocomplete="off" id="title">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;开始时间段：</div>
                                <div class="label_value">
                                    <input type="text" name="begin_time" class="text" value="" maxlength="40" autocomplete="off" id="begin_time">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>结束时间段：</div>
                                <div class="label_value">
                                    <input type="text" name="end_time" class="text" value="" maxlength="40" autocomplete="off" id="end_time">
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
        var ue = UE.getEditor('container',{initialFrameHeight:400});
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    <script type="text/javascript">
        var tag_token = $("#_token").val();
        layui.use(['laydate','layer'], function(){
            var upload = layui.upload;
            var laydate = layui.laydate;

            laydate.render({
                elem: '#begin_time' //指定元素
                ,type: 'time'
            });

            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'time'
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
                    begin_time :{
                        required : true,
                    },
                    end_time :{
                        required : true,
                    }
                },
                messages:{
                    title:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    begin_time:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    end_time:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>

@stop
