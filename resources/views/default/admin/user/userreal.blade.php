@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?is_firm={{$is_firm}}&currpage={{$currpage}}" class="s-back">返回{{$currpage}}</a>会员 - 审核实名认证信息</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i>
                    <h4>操作提示</h4>
                    <span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>该页面展示了会员上传的实名信息。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="#" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;
                                    @if($info['is_firm']==1)
                                        企业名称：
                                    @else
                                        真实姓名：
                                    @endif
                                </div>
                                <div class="label_value font14">
                                    <div class="editSpanInput" ectype="editSpanInput">
                                        <span onclick="listTable.edit(this,'{{url('/admin/userreal/change/realname')}}','{{$info['user_id']}}')">{{$info['real_name']}}</span>

                                        <i class="icon icon-edit"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;添加时间：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['add_time']))
                                        {{$info['add_time']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>
                        @if($info['is_firm']==0)
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;性别：</div>
                                    <div class="label_value font14">
                                        @if($info['sex']==0) 保密
                                        @elseif($info['sex']==1)男
                                        @elseif($info['sex']==2)女
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;生日：</div>
                                    <div class="label_value font14">
                                        @if(!empty($info['birthday']))
                                            {{$info['birthday']}}
                                        @else
                                            无
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;身份证正面：</div>
                                    <div class="label_value font14">
                                        @if($info['front_of_id_card']=="")
                                            未上传
                                        @else
                                            <div  content="{{getFileUrl($info['front_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;身份证反面：</div>
                                    <div class="label_value font14">
                                        @if($info['front_of_id_card']=="")
                                            未上传
                                        @else
                                            <div content="{{getFileUrl($info['reverse_of_id_card'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>
                        @else
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开票资料电子版：</div>
                                    <div class="label_value font14">
                                        @if($info['invoice_fileImg']=="") 未上传
                                        @else
                                            <div  content="{{getFileUrl($info['invoice_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                    <div class="label_value font14">
                                        @if($info['license_fileImg']=="") 未上传
                                        @else
                                            <div  content="{{getFileUrl($info['license_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;授权委托书电子版：</div>
                                    <div class="label_value font14">
                                        @if($info['attorney_letter_fileImg']=="") 未上传
                                        @else
                                            <div  content="{{getFileUrl($info['attorney_letter_fileImg'])}}" class="layui-btn viewImg">点击查看</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="contactName" id="contactName" class="text" value="{{$info['contactName']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;负责人电话：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="contactPhone" id="contactPhone" class="text" value="{{$info['contactPhone']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;是否能开专票：</div>
                                    <div class="label_value font14">
                                        <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;float:left;" name="is_special" id="is_special">
                                            <option @if($info['is_special']==0) selected @endif value="0">否</option>
                                            <option @if($info['is_special']==1) selected @endif value="1">是</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;税号：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="tax_id" id="tax_id" class="text" value="{{$info['tax_id']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开户银行：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="bank_of_deposit" id="bank_of_deposit" class="text" value="{{$info['bank_of_deposit']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;银行账号：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="bank_account" id="bank_account" class="text" value="{{$info['bank_account']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开票地址：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="company_address" id="company_address" class="text" value="{{$info['company_address']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开票电话：</div>
                                    <div class="label_value font14">
                                        <input type="text" name="company_telephone" id="company_telephone" class="text" value="{{$info['company_telephone']}}" maxlength="40" autocomplete="off" >
                                    </div>
                                </div>
                        @endif

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核意见：</div>
                                <div class="label_value">
                                    <textarea id="review_content" name="review_content" class="textarea">@if(!empty($info['review_content'])){{$info['review_content']}}@else @endif</textarea>
                                    <div class="form_prompt"></div>
                                </div>
                            </div>



                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;审核状态：</div>
                                <div class="label_value ">
                                        <div style="float: left;" data-status="0" class='review_status_1 layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==0) @else layui-btn-primary @endif '>待实名</div>
                                        <div style="float: left;" data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==1) @else layui-btn-primary @endif '>已实名</div>
                                        <div style="float: left;" data-status="2" class='review_status_1 layui-btn layui-btn-sm layui-btn-radius @if($info['review_status']==2) @else layui-btn-primary @endif '>不通过</div>
                                        <div style="margin-left: 20px;"  class="notic">点击按钮直接修改状态</div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        layui.use(['layer'], function() {
            var layer = layui.layer;

            $(".viewImg").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="'+content+'">'
                });
            });

            $(".review_status_1").click(function(){
                var review_content = $.trim($("#review_content").val());
                var  postData = {
                    "user_id": "{{$info['user_id']}}",
                    "review_content":review_content,
                    "review_status": $(this).attr("data-status"),
                    "is_firm":"{{$info['is_firm']}}",
                };
                if(review_content==''){
                    layer.msg("请填写审核意见");
                    return false;
                }

                $.post('/admin/user/userReal', postData, function (res) {
                    if (res.code == 1) {
                        //console.log(res.data);return false;
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/user/userRealForm?id={{$userid}}&currpage={{$currpage}}&is_firm={{$is_firm}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");

            });

            $(".review_status").click(function () {
                var review_content = $.trim($("#review_content").val());
                var contactName;
                var contactPhone;
                var tax_id;
                var bank_of_deposit;
                var bank_account;
                var company_address;
                var company_telephone;
                var postData;
                if($("#contactName").length>0){
                    contactName = $("#contactName").val();
                    if(contactName.length==0){
                        layer.msg("负责人姓名不能为空");
                        return false;
                    }
                }
                if($("#contactPhone").length>0){
                    contactPhone = $("#contactPhone").val();
                    if(contactPhone.length==0){
                        layer.msg("负责人电话不能为空");
                        return false;
                    }
                }
                if($("#tax_id").length>0){
                    tax_id = $("#tax_id").val();
                    if(tax_id.length==0){
                        layer.msg("税号不能为空");
                        return false;
                    }
                }
                if($("#bank_of_deposit").length>0){
                    bank_of_deposit = $("#bank_of_deposit").val();
                    if(bank_of_deposit.length==0){
                        layer.msg("开户银行不能为空");
                        return false;
                    }
                }
                if($("#bank_account").length>0){
                    bank_account = $("#bank_account").val();
                    if(bank_account.length==0){
                        layer.msg("银行账号不能为空");
                        return false;
                    }
                }
                if($("#company_address").length>0){
                    company_address = $("#company_address").val();
                    if(company_address.length==0){
                        layer.msg("开票地址不能为空");
                        return false;
                    }
                }
                if($("#company_telephone").length>0){
                    company_telephone = $("#company_telephone").val();
                    if(company_telephone.length==0){
                        layer.msg("开票电话不能为空");
                        return false;
                    }
                }
                if(review_content==''){
                    layer.msg("请填写审核意见");
                    return false;
                }
                if($("#company_telephone").length>0){
                     postData = {
                        "user_id": "{{$info['user_id']}}",
                        "review_content":review_content,
                        "review_status": $(this).attr("data-status"),
                        "is_firm":"{{$info['is_firm']}}",
                        "contactName":contactName,
                        "contactPhone":contactPhone,
                        "tax_id":tax_id,
                        "bank_of_deposit":bank_of_deposit,
                        "bank_account":bank_account,
                        "company_address":company_address,
                        "company_telephone":company_telephone
                    };
                }else{
                     postData = {
                        "user_id": "{{$info['user_id']}}",
                        "review_content":review_content,
                        "review_status": $(this).attr("data-status"),
                        "is_firm":"{{$info['is_firm']}}",
                    };
                }
                //console.log(postData);return false;
                $.post('/admin/user/userReal', postData, function (res) {
                    if (res.code == 1) {
                        //console.log(res.data);return false;
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/user/userRealForm?id={{$userid}}&currpage={{$currpage}}&is_firm={{$is_firm}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
            });
        });


    </script>
@stop
