@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?is_firm={{$is_firm}}&currpage={{$currpage}}" class="s-back">返回</a>会员 - 会员详情信息</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i>
                    <h4>操作提示</h4>
                    <span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>该页面展示了会员的基本信息。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="users.php" name="theForm" id="user_update" novalidate="novalidate">
<hr/>
<div>基础信息</div>

                            <div class="item">
                                <div class="label">&nbsp;登录名：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['user_name']))
                                        {{$info['user_name']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;昵称：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['nick_name']))
                                        {{$info['nick_name']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;邮件地址：</div>
                                <div class="label_value font14">
                                    @if(!empty($info['email']))
                                        {{$info['email']}}
                                    @else
                                        无
                                    @endif
                                </div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;注册时间：</div>
                                <div class="label_value font14">{{$info['reg_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;上次访问ip：</div>
                                <div class="label_value font14">{{$info['last_ip']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;上次登录时间：</div>
                                <div class="label_value font14">{{$info['last_time']}}</div>
                            </div>



                            <div class="item">
                                <div class="label">&nbsp;会员可用金额：</div>
                                <div class="label_value font14">{{$info['user_money']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;会员冻结金额：</div>
                                <div class="label_value font14">{{$info['frozen_money']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;用户头像：</div>
                                <div class="label_value font14"><img src="{{$info['avatar']}}" style="width:80px;height:80px;"></div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;访问次数：</div>
                                <div class="label_value font14">{{$info['visit_count']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;是否冻结：</div>
                                <div class="label_value font14">
                                    @if($info['is_freeze']==1)冻结
                                    @elseif($info['is_freeze']==0)未冻结
                                    @endif
                                </div>
                            </div>

                            @if($info['is_firm']==1)
                                <div class="item">
                                    <div class="label">订单是否需审批：</div>
                                    <div class="label_value font14">
                                        <div style="float: left;" data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['need_approval']==0) @else layui-btn-primary @endif '>不需要</div>
                                        <div style="float: left;" data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($info['need_approval']==1) @else layui-btn-primary @endif '>需要</div>
                                        <div style="margin-left: 20px;"  class="notic">点击按钮直接修改状态</div>
                                    </div>
                                </div>
                            @endif



<hr/>
<div>收货地址信息</div>
                            @if(!empty($user_address))
                                <table class="layui-table">
                                    <colgroup>
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col>
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>收货人</th>
                                        <th>邮编</th>
                                        <th>手机号</th>
                                        <th>国家</th>
                                        <th>省</th>
                                        <th>市</th>
                                        <th>县</th>
                                        <th>街道</th>
                                        <th>地址别名</th>
                                        <th>收货详细地址</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user_address as $vo)
                                    <tr>
                                        <td>{{$vo['consignee']}}</td>
                                        <td>{{$vo['zipcode']}}</td>
                                        <td>{{$vo['mobile_phone']}}</td>
                                        <td>{{$vo['country']}}</td>
                                        <td>{{$vo['province']}}</td>
                                        <td>{{$vo['city']}}</td>
                                        <td>{{$vo['district']}}</td>
                                        <td>{{$vo['street']}}</td>
                                        <td>{{$vo['address_name']}}</td>
                                        <td>{{$vo['address']}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @else
                                无地址信息
                            @endif
<hr/>
<div>收藏商品信息</div>
                            @if(!empty($user_collect_goods))
                                <table class="layui-table">
                                    <colgroup>
                                        <col width="100">
                                        <col width="100">
                                        <col width="100">
                                        <col>
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>编号</th>
                                        <th>商品名称</th>
                                        <th>添加时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user_collect_goods as $vo)
                                        <tr>
                                            <td>{{$vo['id']}}</td>
                                            <td>{{$vo['goods_name']}}</td>
                                            <td>{{$vo['add_time']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                无收藏信息
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        layui.use(['layer'], function() {
            var layer = layui.layer;
            $(".viewImg").click(function () {
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="' + content + '">'
                });
            });

            $(".review_status").click(function(){
                var need_approval = $(this).attr("data-status");
                var  postData = {
                    "id": "{{$info['id']}}",
                    "need_approval":need_approval,
                };

                $.post('/admin/user/change/modifyNeedApproval', postData, function (res) {
                    if (res.code == 200) {
                        layer.msg(res.msg,{
                            icon: 6,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/user/detail?is_firm={{$is_firm}}&currpage={{$currpage}}&id={{$info['id']}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");

            });

        });
    </script>
@stop
