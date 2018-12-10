@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/admin/shipping" class="s-back">返回</a>物流公司 - @if(isset($shipping_info) && !empty($shipping_info))编辑@else添加@endif物流公司</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>

                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shipping/save" method="post" enctype="multipart/form-data" name="theForm" id="shipping_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            @if(isset($shipping_info) && !empty($shipping_info))
                                <input type="hidden" name='id' value="{{$shipping_info['id']}}" />
                            @endif
                            <div class="item">
                                <div class="label">&nbsp;编码：</div>
                                <div class="label_value">
                                    <input type="text" name="shipping_code" class="text" @if(isset($shipping_info) && !empty($shipping_info)) value="{{$shipping_info['shipping_code']}}" @endif maxlength="40" autocomplete="off" id="shipping_code">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;名称：</div>
                                <div class="label_value">
                                    <input type="text" name="shipping_name" class="text" @if(isset($shipping_info) && !empty($shipping_info)) value="{{$shipping_info['shipping_name']}}" @endif maxlength="40" autocomplete="off" id="shipping_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;描述：</div>
                                <div class="label_value">
                                    <input type="text" name="shipping_desc" class="text" @if(isset($shipping_info) && !empty($shipping_info)) value="{{$shipping_info['shipping_desc']}}" @endif maxlength="40" autocomplete="off" id="shipping_desc">
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

        $(function(){
            getShopList();
            //表单验证
            $("#submitBtn").click(function(){
                if($("#shipping_form").valid()){
                    $("#shipping_form").submit();
                }
            });

            $('#shipping_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    shipping_name :{
                        required : true,
                    },
                },
                messages:{
                    shipping_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });
        });
    </script>


@stop
