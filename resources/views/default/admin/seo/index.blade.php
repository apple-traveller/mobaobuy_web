@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper shop_special visible">
        <div class="title">系统设置 - 商店设置</div>
        <div class="content visible">
            <div class="tabs_info">
                <ul>
                    @foreach($seos as $vo)
                    <li @if($vo['id']==$id) class="curr" @endif ><a  href="/seo/index?id={{$vo['id']}}">{{$vo['title']}}</a></li>
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
                    <form enctype="multipart/form-data" name="theForm" action="/seo/modify" method="post" id="shopConfigForm" novalidate="novalidate" class="visible">
                        <div class="switch_info shopConfig_switch visible">

                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <input  type="hidden" name="id" value="{{$seo['id']}}"/>
                            <div class="item shop_name" data-val="101">
                                <div class="label"><span class="require-field">*</span>title：</div>
                                <div class="label_value">
                                    <input type="text" name="title" value="{{$seo['title']}}" class="text" ectype="text" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>

                            </div>

                            <div class="item shop_name" data-val="101">
                                <div class="label"><span class="require-field">*</span>keywords：</div>
                                <div class="label_value">
                                    <input type="text" name="keywords" value="{{$seo['keywords']}}" class="text" ectype="text" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item shop_name" data-val="101">
                                <div class="label"><span class="require-field">*</span>description：</div>
                                <div class="label_value">
                                    <input type="text" name="description" value="{{$seo['description']}}" class="text" ectype="text" autocomplete="off">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>



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
        // $(".changColr").click(function(){
        //     $(this).addClass('curr');
        // });


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
                    title :{
                        required : true,
                    },
                    keywords :{
                        required : true
                    },
                    description:{
                        required : true
                    }
                },
                messages:{
                    title:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'标题不能为空'
                    },
                    keywords :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'关键字不能为空'
                    },
                    description:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'描述不能为空'
                    }
                }
            });
        });
    </script>
@stop
