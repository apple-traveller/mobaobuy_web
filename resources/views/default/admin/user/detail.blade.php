@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/user/list?is_firm={{$info['is_firm']}}" class="s-back">返回</a>会员 - 会员详情信息</div>
        <div class="content">


            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="users.php" name="theForm" id="user_update" novalidate="novalidate">
<hr/>
                            <div>基础信息</div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员名称：</div>
                                <div class="label_value font14">{{$info['user_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;邮件地址：</div>
                                <div class="label_value font14">{{$info['email']}}</div>

                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;注册时间：</div>
                                <div class="label_value font14">{{$info['reg_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次访问ip：</div>
                                <div class="label_value font14">{{$info['last_ip']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次登录时间：</div>
                                <div class="label_value font14">{{$info['last_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员积分：</div>
                                <div class="label_value font14">{{$info['points']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员可用金额：</div>
                                <div class="label_value font14">{{$info['user_money']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员冻结金额：</div>
                                <div class="label_value font14">{{$info['frozen_money']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;用户头像：</div>
                                <div class="label_value font14"><img src="{{$info['avatar']}}" style="width:80px;height:80px;"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;默认收货地址：</div>
                                <div class="label_value font14">{{$info['address_id']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;访问次数：</div>
                                <div class="label_value font14">{{$info['visit_count']}}</div>
                            </div>

                            @if($info['is_firm']==1)
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;授权委托书电子版：</div>
                                    <div class="label_value font14">
                                        @if($info['attorney_letter_fileImg']=="") 未上传
                                        @else
                                            <p ><a href="{{$info['attorney_letter_fileImg']}}" style="color:red;font-size: 15px" download="attorney_letter_fileImg">点击下载原图</a></p>
                                        @endif
                                        {{--<img src="{{$info['attorney_letter_fileImg']}}" style="width:300px;height:300px;">--}}
                                    </div>
                                </div>
                            @endif

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否通过审核：</div>
                                <div class="label_value font14">
                                    @if($info['is_validated']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已审核</div>
                                    @elseif($info['is_validated']==0)<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-warm'>待审核</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value font14">
                                    @if($info['is_freeze']==1)冻结
                                    @elseif($info['is_freeze']==0)未冻结
                                    @endif
                                </div>
                            </div>
                            <hr/>
                            <div>发票信息</div>
                            @if(!empty($user_invoices))
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;公司抬头：</div>
                                    <div class="label_value font14">{{$user_invoices['company_name']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;税号：</div>
                                    <div class="label_value font14">{{$user_invoices['tax_id']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开户银行：</div>
                                    <div class="label_value font14">{{$user_invoices['bank_of_deposit']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;银行账号：</div>
                                    <div class="label_value font14">{{$user_invoices['bank_account']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开票地址：</div>
                                    <div class="label_value font14">{{$user_invoices['company_address']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;开票电话：</div>
                                    <div class="label_value font14">{{$user_invoices['company_telephone']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;收票人：</div>
                                    <div class="label_value font14">{{$user_invoices['consignee_name']}}</div>
                                </div>

                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;收票人电话：</div>
                                    <div class="label_value font14">{{$user_invoices['consignee_mobile_phone']}}</div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;收票地址：</div>
                                    <div class="label_value font14">
                                        国家：{{$user_invoices['country']}}
                                        省：{{$user_invoices['province']}}
                                        市：{{$user_invoices['city']}}
                                        县：{{$user_invoices['district']}}
                                        街道：{{$user_invoices['street']}}
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;收票详细地址：</div>
                                    <div class="label_value font14">{{$user_invoices['consignee_address']}}</div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;添加时间：</div>
                                    <div class="label_value font14">{{$user_invoices['add_time']}}</div>
                                </div>
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;状态：</div>
                                    <div class="label_value font14">
                                        @if($user_invoices['audit_status']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已审核</div>
                                        @elseif($user_invoices['audit_status']==0)<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-warm'>待审核</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                    无发票信息
                            @endif

                            <div>收货地址信息</div>
                            @if(!empty($user_invoices))
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;公司抬头：</div>
                                    <div class="label_value font14">{{$user_invoices['company_name']}}</div>
                                </div>


                            @else
                                无发票信息
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
