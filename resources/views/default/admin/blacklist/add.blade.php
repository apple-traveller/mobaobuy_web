@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/blacklist/list" class="s-back">返回</a>企业黑名单- 添加黑名单</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>注意企业名称填全称。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form method="post" action="/admin/blacklist/save" name="theForm" id="user_form" novalidate="novalidate">
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;企业名称：</div>
                                    <div class="label_value">
                                        <input type="text" id="firm_name" name="firm_name" class="text" value="" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;企业税号：</div>
                                    <div class="label_value">
                                        <input type="text" id="taxpayer_id" name="taxpayer_id" class="text" value="" autocomplete="off">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>


                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>


                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <a href="javascript:;" class="button" id="submitBtn"> 确定 </a>
                                        <input type="hidden" name="act" value="insert">
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

        //表单验证
        $(function(){
            $("#submitBtn").click(function(){
                if($("#user_form").valid()){
                    $("#user_form").submit();
                }
            });

            $('#user_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },


            rules : {
                    firm_name : {
                        required : true
                    },
                    taxpayer_id : {
                        required : true,
                        minlength:6
                    },

                },
            messages : {
                    firm_name : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+'企业名称不能为空'
                    },
                    taxpayer_id : {
                        required : '<i class="icon icon-exclamation-sign"></i>'+'企业税号不能为空',
                        minlength : '<i class="icon icon-exclamation-sign"></i>'+'企业税号为6位数字'
                    },

               }
            });
        });
    </script>

@stop
