@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/seller/salesman?currentPage={{$currentPage}}" class="s-back">返回</a>添加业务员</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/seller/store/save" method="post" enctype="multipart/form-data" name="theForm" id="salesman_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                                <input type="hidden" name="id" value="" >
                                <input type="hidden" name="currentPage" value="{{$currentPage}}" >
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="store_name" class="text" value="" maxlength="40" autocomplete="off" id="store_name">
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
            //表单验证
            $("#submitBtn").click(function(){
                if($("#store_form").valid()){
                    $("#store_form").submit();
                }
            });

            $('#store_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    store_name :{
                        required : true,
                    },

                },
                messages:{
                    store_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },

                }
            });
        });
    </script>


@stop
