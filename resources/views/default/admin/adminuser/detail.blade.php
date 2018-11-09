@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/adminuser/list?currpage={{$currpage}}" class="s-back">返回</a>管理员 - 管理员详情</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>管理员详细信息。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;账号：</div>
                                <div class="label_value font14">{{$adminUser['user_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;真实姓名：</div>
                                <div class="label_value font14">{{$adminUser['real_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;手机：</div>
                                <div class="label_value font14">{{$adminUser['mobile']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;邮箱：</div>
                                <div class="label_value font14">{{$adminUser['email']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;创建人：</div>
                                <div class="label_value font14">{{$created_by}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;创建时间：</div>
                                <div class="label_value font14">{{$adminUser['created_at']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;更新人：</div>
                                <div class="label_value font14">{{$updated_by}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;更新时间：</div>
                                <div class="label_value font14">{{$adminUser['updated_at']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次登录时间：</div>
                                <div class="label_value font14">{{$adminUser['last_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次登录IP：</div>
                                <div class="label_value font14">{{$adminUser['last_ip']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;访问次数：</div>
                                <div class="label_value font14">{{$adminUser['visit_count']}}</div>
                            </div>


                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;头像：</div>
                                <div class="label_value font14"><img src="{{getFileUrl($adminUser['avatar'])}}" style="width:80px;height:80px;"></div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;性别：</div>
                                <div class="label_value font14">
                                    @if($adminUser['sex']==0) 保密
                                    @elseif($adminUser['sex']==1) 男
                                    @else女
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否为超级管理员：</div>
                                <div class="label_value font14">
                                    @if($adminUser['is_super']==0) 否
                                    @else是
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value font14">
                                    @if($adminUser['is_freeze']==0) 否
                                    @else是
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
