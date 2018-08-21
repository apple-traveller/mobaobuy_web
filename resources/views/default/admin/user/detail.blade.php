@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="{{url('/user/list')}}" class="s-back">返回</a>会员 - 编辑会员账号</div>
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

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="users.php" name="theForm" id="user_update" novalidate="novalidate">
                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员名称：</div>
                                <div class="label_value font14">{{$info['user_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">邮件地址：</div>
                                <div class="label_value">
                                    <input type="text" name="email" class="text" autocomplete="off" value="{{$info['email']}}" id="email">
                                    <div class="form_prompt"></div>

                                </div>
                            </div>

{{--
                            <div class="item">
                                <div class="label">会员等级：</div>
                                <div class="label_value">
                                    <div id="user_grade" class="imitate_select select_w320">
                                        <div class="cite">非特殊等级</div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0" class="ftx-01">非特殊等级</a></li>
                                            <li><a href="javascript:;" data-value="3" class="ftx-01">代销用户</a></li>
                                        </ul>
                                        <input name="user_rank" type="hidden" value="0" id="user_grade_val">
                                    </div>
                                    <input type="hidden" name="old_user_rank" value="0">
                                </div>
                            </div>--}}
                            <div class="item">
                                <div class="label">性别：</div>
                                <div class="label_value">
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input type="radio" @if($info['sex']==2)checked @endif class="ui-radio" name="sex" id="sex_0" value="0">
                                            <label for="sex_0" class="ui-radio-label">保密</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" @if($info['sex']==1)checked @endif class="ui-radio" name="sex" id="sex_1" value="1">
                                            <label for="sex_1" class="ui-radio-label">男</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" @if($info['sex']==0)checked @endif class="ui-radio" name="sex" id="sex_2" value="2" >
                                            <label for="sex_2" class="ui-radio-label">女</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="old_sex" value="2">
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;出生日期：</div>
                                <div class="label_value font14">{{$info['birthday']}}</div>
                            </div>
                            <input type="hidden" name="old_birthday" value="0000-00-00">
                           {{-- <div class="item">
                                <div class="label">信用额度：</div>
                                <div class="label_value">
                                    <input type="text" name="credit_line" id="credit_line" value="0.00" class="text" autocomplete="off">
                                    <input type="hidden" name="old_credit_line" value="0.00">
                                </div>
                            </div>--}}
                            <div class="item">
                                <div class="label">身份证信息：</div>
                                <div class="label_value">
                                    <div class="type-file-box">
                                            <span class="show">正面：
                                            	<a href="" target="_blank" class="nyroModal"><i class="icon icon-picture" data-tooltipimg="{{$info['front_of_id_card']}}" ectype="tooltip" title="tooltip"></i></a>
                                            </span>
                                        <span class="show">反面：
                                            	<a href="" target="_blank" class="nyroModal"><i class="icon icon-picture" data-tooltipimg="{{$info['reverse_of_id_card']}}" ectype="tooltip" title="tooltip"></i></a>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="item">
                                <div class="label">手机：</div>
                                <div class="label_value">
                                    <input type="text" name="extend_field5" class="text" value="{{$info['user_name']}}" autocomplete="off">

                                </div>
                            </div>
                            <!---->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
