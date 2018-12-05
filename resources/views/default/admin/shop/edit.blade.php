@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/shop/list?currpage={{$currpage}}" class="s-back">返回</a>店铺 - 编辑入驻店铺</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/shop/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">



                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
                                <div class="label_value">
                                    <input type="text" name="shop_name" class="text" value="{{$shop['shop_name']}}" maxlength="40" autocomplete="off" id="shop_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;企业全称：</div>
                                <div class="label_value">
                                    <input type="text" name="company_name" class="text" value="{{$shop['company_name']}}" maxlength="40" autocomplete="off" id="company_name">
                                    <div class="form_prompt"></div>
                                    <div class="notic"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                <div class="label_value">
                                    <input type="text" name="contactName" class="text" value="{{$shop['contactName']}}" maxlength="40" autocomplete="off" id="contactName">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>负责人手机：</div>
                                <div class="label_value">
                                    <input type="text" name="contactPhone" class="text" value="{{$shop['contactPhone']}}" maxlength="40" autocomplete="off" id="contactPhone">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>授权委托书电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn upload-file" style="float:left;" data-type="" data-path="shop" ><i class="layui-icon">&#xe681;</i>上传图片</button>
                                    <input type="text" value="{{$shop['attorney_letter_fileImg']}}" class="text"  name="attorney_letter_fileImg" style="display:none;">
                                    <img @if(!empty($shop['attorney_letter_fileImg'])) style="width:50px;height:50px;float:left;margin-left:10px;margin-top:-5px;" src="{{getFileUrl($shop['attorney_letter_fileImg'])}}" @else style="width:30px;height:30px;display:none;margin-right:10px;float: left;" @endif class="layui-upload-img"  >
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                <div class="label_value">
                                    <button type="button" class="layui-btn upload-file" style="float:left;" data-type="" data-path="shop" ><i class="layui-icon">&#xe681;</i>上传图片</button>
                                    <input type="text" value="{{$shop['license_fileImg']}}" class="text"  name="license_fileImg" style="display:none;">
                                    <img @if(!empty($shop['license_fileImg'])) style="width:50px;height:50px;float:left;margin-left:10px;margin-top:-5px;" src="{{getFileUrl($shop['license_fileImg'])}}" @else style="width:30px;height:30px;display:none;margin-right:10px;float: left;" @endif class="layui-upload-img" id="demo_license_fileImg" >

                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>营业执照注册号：</div>
                                <div class="label_value">
                                    <input type="text" name="business_license_id" class="text" value="{{$shop['business_license_id']}}" maxlength="40" autocomplete="off" id="business_license_id">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>纳税人识别号：</div>
                                <div class="label_value">
                                    <input type="text" name="taxpayer_id" class="text" value="{{$shop['taxpayer_id']}}" maxlength="40" autocomplete="off" id="taxpayer_id">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>结算银行：</div>
                                <div class="label_value">
                                    <input type="text" name="settlement_bank_account_name" class="text" value="{{$shop['settlement_bank_account_name']}}" maxlength="40" autocomplete="off" id="settlement_bank_account_name">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>结算公司银行账号：</div>
                                <div class="label_value">
                                    <input type="text" name="settlement_bank_account_number" class="text" value="{{$shop['settlement_bank_account_number']}}" maxlength="40" autocomplete="off" id="settlement_bank_account_number">
                                    <div class="form_prompt"></div>
                                </div>
                                <div class="form_prompt"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否自营：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_self_run" id="is_self_run">
                                        <option @if($shop['is_self_run']==0) selected @endif value="0">否</option>
                                        <option @if($shop['is_self_run']==1) selected @endif value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否通过审核：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_validated" id="is_validated">
                                        <option @if($shop['is_validated']==0) selected @endif value="0">否</option>
                                        <option @if($shop['is_validated']==1) selected @endif value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="is_freeze" id="is_validated">
                                        <option @if($shop['is_freeze']==0) selected @endif value="0">否</option>
                                        <option @if($shop['is_freeze']==1) selected @endif value="1">是</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="id"  value="{{$shop['id']}}"/>
                            <input type="hidden" name="currpage"  value="{{$currpage}}"/>


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
            document.onclick=function(event){
                $(".query").hide();
            }
        });

        layui.use(['upload','layer'], function(){
            var upload = layui.upload;
            var layer = layui.layer;
            //文件上传
            upload.render({
                elem: '.upload-file' //绑定元素
                ,url: "/uploadImg" //上传接口
                ,accept:'file'
                ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    this.data={'upload_type':this.item.attr('data-type'),'upload_path':this.item.attr('data-path')};
                }
                ,done: function(res){
                    //上传完毕回调
                    if(1 == res.code){
                        var item = this.item;
                        item.siblings('input').attr('value', res.data.path);
                        item.siblings('img').show().attr('src', res.data.url);
                        item.siblings('img').parent('div').children(".form_prompt").remove();
                    }else{
                        layer.msg(res.msg, {time:2000});
                    }
                }
            });
        });

        $("#nick_name").focus(function(){
            $.post('/admin/shop/getUsers',{},function(res){
                if(res.code==200){
                    $(".query").show();
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" data-id="'+data[i].id+'" style="cursor: pointer;padding-left: 10px;box-sizing: border-box;">'+data[i].nick_name+'</li>');
                    }
                }
            },"json");
        });

        //user_id输入框模糊查询
        $("#nick_name").bind("input propertychange",function(res){
            var nick_name = $(this).val();
            $(".query").children().filter("li").remove();
            $.post('/admin/shop/getUsers',{'nick_name':nick_name},function(res){
                if(res.code==200){
                    var data = res.data;
                    for(var i=0;i<data.length;i++){
                        $(".query").append('<li class="searchAttr" data-id="'+data[i].id+'" style="cursor: pointer;padding-left: 10px;box-sizing: border-box;">'+data[i].nick_name+'</li>');
                    }
                }
            },"json");
        });

        $(document).delegate(".searchAttr","click",function(){
            var nick_name = $(this).text();
            var user_id = $(this).attr('data-id');
            $("#user_id").val(user_id);
            $("#nick_name").val(nick_name);
            $(".query").children().filter("li").remove();
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
                    shop_name :{
                        required : true,
                    },
                    company_name :{
                        required : true,
                    },
                    contactName:{
                        required : true,
                    },
                    contactPhone:{
                        required : true,
                        number:true,
                    },
                    attorney_letter_fileImg:{
                        required : true,
                    },
                    license_fileImg:{
                        required : true,
                    },
                    business_license_id:{
                        required : true,
                        number:true,
                    },
                    taxpayer_id:{
                        required : true,
                    },
                    settlement_bank_account_name:{
                        required : true,
                    },
                    settlement_bank_account_number:{
                        required : true,
                        number:true,
                    }
                },
                messages:{
                    shop_name:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    company_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contactName :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contactPhone :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    attorney_letter_fileImg :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    license_fileImg :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    business_license_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                    taxpayer_id :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    settlement_bank_account_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                    },
                    settlement_bank_account_number :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字'
                    },
                }
            });
        });
    </script>


@stop
