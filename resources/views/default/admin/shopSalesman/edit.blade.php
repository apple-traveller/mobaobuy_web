@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title"><a href="/admin/salesman/list?currentPage={{$currentPage}}" class="s-back">返回</a>添加业务员</div>
        <div class="content">

            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/salesman/save" method="post" enctype="multipart/form-data" name="theForm" id="salesman_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                                <input type="hidden" name="id" value="@if(!empty($info)){{$info['id']}}@endif" >
                                <input type="hidden" name="currentPage" value="{{$currentPage}}" >
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;选择商家：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="shop_id" id="shop_id" @if(!empty($info)) value="{{$info['shop_id']}}" @endif>
                                        <option value="">请选择商家</option>
                                    </select>
                                    <input type="hidden" name="shop_name" id="shop_name" @if(!empty($info)) value="{{$info['company_name']}}" @endif>
                                    <div style="margin-left: 10px;" class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="name" class="text" value="@if(!empty($info)){{$info['name']}}@endif" maxlength="40" autocomplete="off" id="name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;电话：</div>
                                <div class="label_value">
                                    <input type="text" name="mobile" class="text" value="@if(!empty($info)){{$info['mobile']}}@endif" maxlength="40" autocomplete="off" id="mobile">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">&nbsp;QQ：</div>
                                <div class="label_value">
                                    <input type="text" name="qq" class="text" value="@if(!empty($info)){{$info['qq']}}@endif" maxlength="40" autocomplete="off" id="qq">
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
            getShopList('{{$info['shop_id'] or 0}}');
            //表单验证
            $("#submitBtn").click(function(){
                if($("#salesman_form").valid()){
                    $("#salesman_form").submit();
                }
            });

            $('#salesman_form').validate({
                errorPlacement:function(error, element){
                    var error_div = element.parents('div.label_value').find('div.form_prompt');
                    element.parents('div.label_value').find(".notic").hide();
                    error_div.append(error);
                },
                ignore : [],
                rules:{
                    name :{
                        required : true,
                    },
                    mobile :{
                        required : true,
                    }

                },
                messages:{
                    name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    mobile :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    }

                }
            });
        });
        // 商家 请求所有的商家数据
        function getShopList(_id){
            $.ajax({
                url: "/admin/shop/ajax_list",
                dataType: "json",
                data:{},
                type:"POST",
                success:function(res){
                    if(res.code==1){
                        let data = res.data;
                        for(let i=0;i<data.length;i++){
                            if(_id == data[i].id){
                                $("#shop_id").append('<option value="'+data[i].id+'" selected>'+data[i].company_name+'</option>');
                            }else{
                                $("#shop_id").append('<option value="'+data[i].id+'">'+data[i].company_name+'</option>');
                            }

                        }
                    }
                }
            })
        }
    </script>


@stop
