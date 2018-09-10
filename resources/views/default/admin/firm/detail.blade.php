@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="{{url('/firm/list')}}" class="s-back">返回</a>企业 - 企业详情信息</div>
        <div class="content">


            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form  name="theForm" id="user_update" novalidate="novalidate">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;企业名称：</div>
                                <div class="label_value font14">{{$info['firm_name']}}</div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;账号：</div>
                                <div class="label_value font14">{{$info['user_name']}}</div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;联系人：</div>
                                <div class="label_value font14">{{$info['contactName']}}</div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;联系方式：</div>
                                <div class="label_value font14">{{$info['contactPhone']}}</div>
                            </div>
                            <div class="item">
                                <div class="label">总积分：</div>
                                <div class="label_value">
                                    <div class="b-price blue font14 mr20"><em>¥{{$info['points']}}</em></div>

                                </div>
                            </div>
                            <div class="item">
                                <div class="label">法律凭证：</div>
                                <div class="label_value">
                                    <div class="type-file-box">
                                            <span class="show">查看大图：
                                            	<a href="" target="_blank" class="nyroModal"><i class="icon icon-picture" data-tooltipimg="{{$info['attorney_letter_fileImg']}}" ectype="tooltip" title="tooltip"></i></a>
                                            </span>

                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;注册时间：</div>
                                <div class="label_value font14">{{$info['reg_time']}}</div>
                            </div>
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否已经通过验证：</div>
                                <div class="label_value font14">@if($info['is_validated'])通过@else不通过 @endif</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;最近一次拜登录地址：</div>
                                <div class="label_value font14">{{$info['last_ip']}}</div>
                            </div>
                            <input type="hidden" name="old_birthday" value="0000-00-00">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
