@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/shop/list?currpage={{$currpage}}" class="s-back">返回</a>店铺 - 入驻店铺详情</div>
        <div class="content">


            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;会员：</div>
                                <div class="label_value font14">{{$nick_name}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;店铺名称：</div>
                                <div class="label_value font14">{{$shop['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;企业全称：</div>
                                <div class="label_value font14">{{$shop['company_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人姓名：</div>
                                <div class="label_value font14">{{$shop['contactName']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;负责人手机：</div>
                                <div class="label_value font14">{{$shop['contactPhone']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照注册号：</div>
                                <div class="label_value font14">{{$shop['business_license_id']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;纳税人识别号：</div>
                                <div class="label_value font14">{{$shop['taxpayer_id']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;授权委托书电子版：</div>
                                <div class="label_value font14">
                                    <div  path="{{$shop['attorney_letter_fileImg']}}" class="layui-btn viewPic">点击查看</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                <div class="label_value font14">
                                    <div  path="{{$shop['license_fileImg']}}" class="layui-btn viewPic">点击查看</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;注册时间：</div>
                                <div class="label_value font14">{{$shop['reg_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次登录时间：</div>
                                <div class="label_value font14">{{$shop['last_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;上次登录IP：</div>
                                <div class="label_value font14">{{$shop['last_ip']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;拜访次数：</div>
                                <div class="label_value font14">{{$shop['visit_count']}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否通过审核：</div>
                                <div class="label_value font14">
                                    @if($shop['is_validated']==1)
                                    <div data_value="{{$shop['is_validated']}}" class="layui-btn layui-btn-warm  is_validate">已通过</div>
                                    @else
                                    <div data_value="{{$shop['is_validated']}}" class="layui-btn layui-btn-warm layui-btn-danger is_validate">待审核</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否自营：</div>
                                <div class="label_value font14">{{status($shop['is_self_run'])}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value font14">{{status($shop['is_freeze'])}}</div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        layui.use(['upload','layer'], function() {
            var layer = layui.layer;

            $(".viewPic").click(function(){
                var src = $(this).attr('path');
                index = layer.open({
                    type: 1,
                    title: '大图',
                    area: ['700px', '600px'],
                    content: '<img src="'+src+'">'
                });
            });

            $(".is_validate").click(function(res){
                var is_validated ;
                var id = "{{$shop['id']}}";
                var input = $(this);
                if (input.attr('data_value') === '1') {
                    is_validated = 0;
                } else {
                    is_validated = 1;
                }
                layui.use(['layer'], function() {
                    layer = layui.layer;
                    $.post("{{url('/admin/brand/change/isValidated')}}",{"id":id,"is_validated":is_validated},function(res){
                        if(res.code==200){
                            layer.msg(res.msg, {icon: 1});
                            if(res.data==1){
                                input.attr('class','layui-btn layui-btn-warm  is_validate');
                                input.attr('data_value',1);
                                input.html('已通过');
                            }else{
                                input.attr('class','layui-btn layui-btn-warm layui-btn-danger is_validate');
                                input.attr('data_value',0);
                                input.html('待审核');
                            }
                        }else{
                            layer.msg(res.msg, {icon: 5});
                        }
                    },"json");

                });
            });

        });
    </script>
@stop
