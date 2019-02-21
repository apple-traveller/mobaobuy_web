@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <script src="{{asset(themePath('/').'plugs/zTree_v3/js/jquery.ztree.core.js')}}" ></script>
    <script src="{{asset(themePath('/').'js/create_cat_tree.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/zTree_v3/css/zTreeStyle/zTreeStyle.css')}}" />
    <div class="menuContent" style="display:none; position: absolute;">
        <ul id="setCatTree" class="ztree treeSelect" style="margin-top:0;border: 1px solid #617775;background:#f0f6e4;width: 309px;height: 360px;overflow-y: scroll;overflow-x: auto;"></ul>
    </div>

    <div class="warpper">
        <div class="title"><a href="/admin/inquire/index" class="s-back">返回</a>求购 - 添加求购信息</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“*”的选项为必填项，其余为选填项。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form action="/admin/inquire/save" method="post" enctype="multipart/form-data" name="theForm" id="article_form" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;商品名称：</div>
                                <div class="label_value">
                                    <input type="text"  value=""  autocomplete="off" name="goods_name" size="40"  class="text" id="goods_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;单位：</div>
                                <div class="label_value">
                                    <input type="text"  value="KG"  autocomplete="off" name="unit_name" size="40"  class="text" id="unit_name">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;数量(<span style="color:#909090;" class="unit-name">KG</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="num" class="text" value="" maxlength="40" autocomplete="off" id="num">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;意向价格(<span style="color:#909090;" >元</span>)：</div>
                                <div class="label_value">
                                    <input type="text" name="price" class="text" value="" maxlength="40" autocomplete="off" id="price">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货地：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_area" class="text" value="" maxlength="40" autocomplete="off" id="delivery_area">
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time" class="text" value="现货" maxlength="40" autocomplete="off" id="delivery_time">
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;英文交货时间：</div>
                                <div class="label_value">
                                    <input type="text" name="delivery_time_en" class="text" value="spot goods" maxlength="40" autocomplete="off" id="delivery_time_en">
                                    <div style="margin-left: 10px" class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;联系人：</div>
                                <div class="label_value">
                                    <input type="text" name="contacts" class="text" value="" maxlength="40" autocomplete="off" id="contacts">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;手机号：</div>
                                <div class="label_value">
                                    <input type="text" name="contacts_mobile" class="text" value="" maxlength="40" autocomplete="off" id="contacts_mobile">
                                    <div class="form_prompt"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;qq：</div>
                                <div class="label_value">
                                    <input type="text" name="qq" class="text" value="" maxlength="40" autocomplete="off" id="qq">
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

        layui.use(['layer'], function(){
            var layer = layui.layer;

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
                    num :{
                        required : true,
                        number:true
                    },
                    goods_name:{
                        required : true,
                    },
                    price:{
                        required:true,
                    },
                    delivery_area:{
                        required:true,
                    },
                    delivery_time:{
                        required:true,
                    },
                    delivery_time_en:{
                        required:true,
                    },
                    contacts:{
                        required:true,
                    },
                    contacts_mobile:{
                       required:true,
                    },
                },
                messages:{
                    num :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项',
                        number : '<i class="icon icon-exclamation-sign"></i>'+'必须为数字',
                    },
                    goods_name :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    price :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_area :{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_time:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    delivery_time_en:{
                        required : '<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contacts:{
                        required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                    contacts_mobile:{
                       required :'<i class="icon icon-exclamation-sign"></i>'+'必填项'
                    },
                }
            });




        });
    </script>


@stop
