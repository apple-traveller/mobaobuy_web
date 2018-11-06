@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/ad/position/list" class="s-back">返回</a>广告位置 - 编辑广告位</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>请设置合适的广告位名称和图片尺寸。</li>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/ad/position/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <input type="hidden" name="id" value="{{$adPosition['id']}}">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;广告位名称：</div>
                                <div class="label_value">
                                    <input type="text" name="position_name" class="text" value="{{$adPosition['position_name']}}" maxlength="40" autocomplete="off" id="position_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;宽度：</div>
                                <div class="label_value">
                                    <input type="text" name="ad_width" class="text" value="{{$adPosition['ad_width']}}" maxlength="40" autocomplete="off" id="width">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;高度：</div>
                                <div class="label_value">
                                    <input type="text" name="ad_height" class="text" value="{{$adPosition['ad_height']}}" maxlength="40" autocomplete="off" id="height">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
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
                    position_name :{
                        required : true,
                    },
                    width :{
                        required : true,
                    },
                    height:{
                        required : true,
                    }
                },
                messages:{
                    position_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    width :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    height :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
