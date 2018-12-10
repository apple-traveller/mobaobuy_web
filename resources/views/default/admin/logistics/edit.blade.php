@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/logistics/list?currpage={{$currpage}}" class="s-back">返回</a>物流- 编辑物流信息</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>带*号的为必填项。</li>
                    <li>请谨慎填写运单号。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/logistics/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择快递公司：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;margin-right:10px;"  id="shipping_id">
                                        <option value="">请选择快递公司</option>
                                        @foreach($shippings as $vo)
                                            <option @if($logistic_info['shipping_company']==$vo['shipping_name']) selected  @endif value="{{$vo['id']}}">{{$vo['shipping_name']}}</option>
                                        @endforeach
                                    </select>
                                    <input id="shipping_company" value="{{$logistic_info['shipping_company']}}" type="hidden" name="shipping_company" >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>运单号：</div>
                                <div class="label_value">
                                    <input type="text" name="shipping_billno" class="text" value="{{$logistic_info['shipping_billno']}}" maxlength="40" autocomplete="off" id="shipping_billno">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;物流信息：</div>
                                <div class="label_value">
                                    <textarea id="shipping_content" name="shipping_content" class="textarea">{{$logistic_info['shipping_content']}}</textarea>
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$logistic_info['id']}}">
                            <input type="hidden" name="currpage" value="{{$currpage}}">
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
        layui.use(['layer'], function() {
            var layer = layui.layer;

            $("#shipping_id").on("change",function(){
                var shipping_company = $(this).find("option:selected").text();
                $("#shipping_id").siblings('div').filter(".form_prompt").remove();
                $("#shipping_company").val(shipping_company);
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
                    shipping_company :{
                        required : true,
                    },
                    shipping_billno :{
                        required : true,
                    },
                    shipping_content:{
                        required : true,
                    }
                },
                messages:{
                    shipping_company:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    shipping_billno :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    shipping_content :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }
                }
            });
        });
    </script>


@stop
