@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    @include('vendor.ueditor.assets')
    <div class="warpper">
        <div class="title"><a href="/admin/recruit/list?currpage={{$currpage}}" class="s-back">返回</a>招聘 - 招聘列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form action="/admin/recruit/save" method="post" name="form" id="navigator_form" novalidate="novalidate">
                            <div class="switch_info">

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>招聘职位：</div>
                                    <div class="label_value">
                                        <input type="text" name="recruit_job" value="{{$recruit['recruit_job']}}" autocomplete="off" id="recruit_job" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>招聘人数：</div>
                                    <div class="label_value">
                                        <input type="text" name="recruit_number" value="{{$recruit['recruit_number']}}" autocomplete="off" id="recruit_number" size="40"  class="text">
                                        <div class="notic"></div>
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>工作地点：</div>
                                    <div class="label_value">
                                        <input type="text" name="recruit_place" value="{{$recruit['recruit_place']}}" autocomplete="off" id="recruit_place" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>招聘公司：</div>
                                    <div class="label_value">
                                        <input type="text" name="recruit_firm" value="{{$recruit['recruit_firm']}}" autocomplete="off" id="recruit_firm" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>薪资待遇：</div>
                                    <div class="label_value">
                                        <input type="text" name="recruit_pay" value="{{$recruit['recruit_pay']}}" autocomplete="off" id="recruit_pay" size="40"  class="text">
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{$recruit['id']}}">
                                <input type="hidden" name="currpage" value="{{$currpage}}">

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>岗位职责：</div>
                                    <div class="label_value">
                                        <script id="job_desc" name="job_desc" type="text/plain"><?php echo html_entity_decode($recruit['job_desc']);?></script>
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <input type="submit" class="button"  value=" 确定 " id="submitBtn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ue1 = UE.getEditor('job_desc',{initialFrameHeight:400});
        ue1.ready(function() {
            ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <script type="text/javascript">


        $(function(){
            //表单验证
            $("#submitBtn").click(function(){
                if($("#navigator_form").valid()){
                    $("#navigator_form").submit();
                }
            });

            $('#navigator_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                rules:{
                    recruit_job :{
                        required : true,
                    },
                    recruit_number :{
                        required : true
                    },
                    recruit_place :{
                        required : true,
                    },
                    recruit_firm :{
                        required : true,
                    },
                    recruit_pay :{
                        required : true,
                    }
                },
                messages:{
                    recruit_job :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    recruit_number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    recruit_place :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    recruit_firm :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    recruit_pay :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>

@stop
