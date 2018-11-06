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
                                    <div  path="{{getFileUrl($shop['attorney_letter_fileImg'])}}" class="layui-btn viewPic">点击查看</div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;营业执照副本电子版：</div>
                                <div class="label_value font14">
                                    <div  path="{{getFileUrl($shop['license_fileImg'])}}" class="layui-btn viewPic">点击查看</div>
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
                                <div class="label"><span class="require-field">*</span>&nbsp;是否自营：</div>
                                <div class="label_value font14">{{status($shop['is_self_run'])}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否冻结：</div>
                                <div class="label_value font14">{{status($shop['is_freeze'])}}</div>
                            </div>

                            <div class="item">
                                <div class="label"><span class="require-field">*</span>&nbsp;是否通过审核：</div>
                                <div class="label_value font14">
                                    <div data-status="1" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($shop['is_validated']==1) @else layui-btn-primary @endif '>已审核</div>
                                    <div data-status="0" class='review_status layui-btn layui-btn-sm layui-btn-radius @if($shop['is_validated']==0) @else layui-btn-primary @endif '>未审核</div>
                                </div>
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

            $(".review_status").click(function(res){
                var is_validated = $(this).attr("data-status") ;
                var id = "{{$shop['id']}}";
                layui.use(['layer'], function() {
                    layer = layui.layer;
                    $.post("{{url('/admin/shop/change/isValidated')}}",{"id":id,"is_validated":is_validated},function(res){
                        if(res.code==200){
                            layer.msg(res.msg,{
                                icon: 1,
                                time: 2000 //2秒关闭（如果不配置，默认是3秒）
                            },function(){
                                window.location.href="/admin/shop/detail?id={{$id}}&currpage={{$currpage}}";
                            });
                        }else{
                            layer.msg(res.msg, {icon: 5});
                        }
                    },"json");

                });
            });

        });
    </script>
@stop
