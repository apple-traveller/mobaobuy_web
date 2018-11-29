@extends(themePath('.')."seller.include.layouts.master")
@section('body')

    <div class="warpper">
        <div class="title"><a href="/admin/shop/store" class="s-back">返回</a>店铺 - 添加店铺</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shop/store/save" method="post" enctype="multipart/form-data" name="theForm" id="store_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商家：</div>
                                <div class="label_value">
                                    <input type="text"  shop-id="" value="" autocomplete="off" id="company_name" size="40"  class="text">
                                    <input type="hidden" name="shop_name" id="company_name_val" />
                                    <input type="hidden" name="shop_id" id="shop_id" />
                                    <ul class="query_company_name" style="overflow:auto;display:none;height:200px;position: absolute; z-index: 2; top: 62px; background: #fff;width: 320px; box-shadow: 0px -1px 1px 2px #dedede;">
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
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

            // 商家 获取焦点请求所有的商家数据
            $("#company_name").focus(function(){
                $(".query_company_name").children().filter("li").remove();
                $.ajax({
                    url: "/admin/shop/ajax_list",
                    dataType: "json",
                    data:{},
                    type:"POST",
                    success:function(res){
                        if(res.code==1){
                            $(".query_company_name").show();
                            var data = res.data;
                            for(var i=0;i<data.length;i++){
                                $(".query_company_name").append('<li data-shop-id="'+data[i].id+'" class="created_company_name" style="cursor:pointer;margin-left: 4px">'+data[i].company_name+'</li>');
                            }
                        }
                    }
                })
            });

            //点击将li标签里面的值填入input框内
            $(document).delegate(".created_company_name","click",function(){
                //$("#company_name").siblings("div").filter(".notic").remove();
                var company_name = $(this).text();
                var shop_id = $(this).attr("data-shop-id");
                $("#company_name").val(company_name);
                $("#company_name_val").val(company_name);
                $("#shop_id").val(shop_id);
                $(".query_company_name").hide();
            });

            $("#company_name").blur(function(){

                let _name = $("#company_name_val").val();
                $(this).val(_name);
            });
        });
    </script>


@stop
