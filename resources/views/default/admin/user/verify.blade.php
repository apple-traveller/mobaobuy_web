@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/user/list?is_firm={{$info['is_firm']}}" class="s-back">返回</a>会员 - 审核会员</div>
        <div class="content">
            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="/user/verify" name="theForm" id="user_update" novalidate="novalidate">
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
                                    @else未冻结
                                    @endif
                                </div>
                            </div>

                            @if($info['is_firm']==1)
                                <div class="item">
                                    <div class="label"><span class="require-field">*</span>&nbsp;授权委托书电子版：</div>
                                    <div class="label_value font14">
                                        <a href="{{$info['attorney_letter_fileImg']}}" target="_blank" >
                                            <p style="color:red">点击查看</p>
                                        </a>
                                        {{--<img src="{{$info['attorney_letter_fileImg']}}" style="width:300px;height:300px;">--}}
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{$info['id']}}">
                            <input type="hidden" name="is_validated" value="{{$info['is_validated']}}">
                            <div class="item">
                                <div class="label">&nbsp;</div>
                                <div class="label_value info_btn">
                                    @if($info['is_validated']==0)
                                        <input value="审核通过" class="button" id="submitBtn" type="submit">
                                    @else
                                        <input value="审核不通过" class="button" id="submitBtn" type="submit">
                                    @endif

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
