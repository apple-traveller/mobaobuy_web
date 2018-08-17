@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="{{url('/firm/list')}}" class="s-back">返回</a>企业 - 企业详情信息</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr"><a href="users.php?act=edit&amp;id=18">基本信息</a></li>
                    <li><a href="users.php?act=address_list&amp;id=18">收货地址</a></li>
                    <li><a href="order.php?act=list&amp;user_id=18">查看订单</a></li>
                    <li><a href="user_baitiao_log.php?act=bt_add_tp&amp;user_id=18">设置白条</a></li>
                    <li><a href="account_log.php?act=list&amp;user_id=18">账目明细</a></li>
                </ul>
            </div>
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li>
                    <li>编辑会员账号信息请根据提示慎重操作，避免出现不必要的问题。</li>
                </ul>
            </div>
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
                                <div class="label">积分：</div>
                                <div class="label_value">
                                    <div class="b-price blue font14 mr20"><em>¥</em>{{$info['points']}}</div>

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
