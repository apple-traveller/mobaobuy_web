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
                                <div class="label">&nbsp;会员：</div>
                                <div class="label_value font14">{{$nick_name}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;店铺名称：</div>
                                <div class="label_value font14">{{$shop['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;企业全称：</div>
                                <div class="label_value font14">{{$shop['company_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;负责人姓名：</div>
                                <div class="label_value font14">
                                    <input type="text" name="contactName" class="text" value="{{$shop['contactName']}}" maxlength="40" autocomplete="off" id="contactName">
                                    <div class="notice"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;负责人手机：</div>
                                <div class="label_value font14">
                                    <input type="text" name="contactPhone" class="text" value="{{$shop['contactPhone']}}" maxlength="40" autocomplete="off" id="contactPhone">
                                    <div class="notice"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;营业执照注册号：</div>
                                <div class="label_value font14">
                                    <input type="text" name="business_license_id" class="text" value="{{$shop['business_license_id']}}" maxlength="40" autocomplete="off" id="business_license_id">
                                    <div class="notice"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;纳税人识别号：</div>
                                <div class="label_value font14">
                                    <input type="text" name="taxpayer_id" class="text" value="{{$shop['taxpayer_id']}}" maxlength="40" autocomplete="off" id="taxpayer_id">
                                    <div class="notice"></div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;授权委托书电子版：</div>
                                <div class="label_value font14">
                                    @if(empty($shop['attorney_letter_fileImg']))
                                        未上传
                                    @else
                                    <div  path="{{getFileUrl($shop['attorney_letter_fileImg'])}}" class="layui-btn viewPic">点击查看</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">营业执照副本电子版：</div>
                                <div class="label_value font14">
                                    @if(empty($shop['license_fileImg']))
                                        未上传
                                    @else
                                        <div  path="{{getFileUrl($shop['license_fileImg'])}}" class="layui-btn viewPic">点击查看</div>
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">注册时间：</div>
                                <div class="label_value font14">{{$shop['reg_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">上次登录时间：</div>
                                <div class="label_value font14">{{$shop['last_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">上次登录IP：</div>
                                <div class="label_value font14">{{$shop['last_ip']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;拜访次数：</div>
                                <div class="label_value font14">{{$shop['visit_count']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;是否自营：</div>
                                <div class="label_value font14">
                                    @if($shop['is_self_run']==1)
                                    是
                                    @else
                                    否
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">是否冻结：</div>
                                <div class="label_value font14">
                                    @if($shop['is_freeze']==1)
                                        是
                                    @else
                                        否
                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="label">审核状态：</div>
                                <div class="value">
                                    <input @if($shop['is_validated']==1) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn review_status" @endif  type="button" data-status="1" value="已审核" >
                                    <input @if($shop['is_validated']==0) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn review_status" @endif  type="button" data-status="0" value="未审核" >
                                    <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态</span>
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

            $("#contactName").blur(function(){
                let contactName = $(this).val();
                var id = "{{$shop['id']}}";
                $.post("{{url('/admin/shop/change/modifyAjax')}}",{"id":id,"contactName":contactName},function(res){
                    if(res.code==200){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            $(this).val(res.data.contactName);
                        });
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });

            $("#contactPhone").blur(function(){
                let contactPhone = $(this).val();
                var id = "{{$shop['id']}}";
                $.post("{{url('/admin/shop/change/modifyAjax')}}",{"id":id,"contactPhone":contactPhone},function(res){
                    if(res.code==200){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            $(this).val(res.data.contactPhone);
                        });
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });

            $("#business_license_id").blur(function(){
                let business_license_id = $(this).val();
                var id = "{{$shop['id']}}";
                $.post("{{url('/admin/shop/change/modifyAjax')}}",{"id":id,"business_license_id":business_license_id},function(res){
                    if(res.code==200){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            $(this).val(res.data.business_license_id);
                        });
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });

            $("#taxpayer_id").blur(function(){
                let taxpayer_id = $(this).val();
                var id = "{{$shop['id']}}";
                $.post("{{url('/admin/shop/change/modifyAjax')}}",{"id":id,"taxpayer_id":taxpayer_id},function(res){
                    if(res.code==200){
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            $(this).val(res.data.taxpayer_id);
                        });
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });

        });
    </script>
@stop
