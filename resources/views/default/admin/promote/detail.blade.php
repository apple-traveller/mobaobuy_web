@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/promote/list?currpage={{$currpage}}" class="s-back">返回</a>优惠活动 - 优惠活动详情</div>
        <div class="content">


            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;店铺：</div>
                                <div class="label_value font14">{{$promote['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品：</div>
                                <div class="label_value font14">{{$promote['goods_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;开始时间：</div>
                                <div class="label_value font14">{{$promote['begin_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;结束时间：</div>
                                <div class="label_value font14">{{$promote['end_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;促销价格(<span style="color:#909090;" class="unit-name">元</span>)：</div>
                                <div class="label_value font14">{{$promote['price']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;促销总数量(<span style="color:#909090;" class="unit-name">{{$goods_info['unit_name']}}</span>)：</div>
                                <div class="label_value font14">{{$promote['num']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;当前可售数量(<span style="color:#909090;" class="unit-name">{{$goods_info['unit_name']}}</span>)：</div>
                                <div class="label_value font14">{{$promote['available_quantity']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;最小起售数量(<span style="color:#909090;" class="unit-name">{{$goods_info['unit_name']}}</span>)：</div>
                                <div class="label_value font14">{{$promote['min_limit']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;最大限购数量(<span style="color:#909090;" class="unit-name">{{$goods_info['unit_name']}}</span>)：</div>
                                <div class="label_value font14">{{$promote['max_limit']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;添加时间：</div>
                                <div class="label_value font14">{{$promote['add_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;点击次数：</div>
                                <div class="label_value font14"><div class="label_value font14">{{$promote['click_count']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">审核状态：</div>
                                <div class="value">
                                    @if($promote['review_status']==3)
                                        已通过审核
                                    @else
                                        <input @if($promote['review_status']==1) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn review_status" @endif  type="button" data-status="1" value="待审核" >
                                        <input @if($promote['review_status']==2) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn review_status" @endif  type="button" data-status="2" value="不通过" >
                                        <input @if($promote['review_status']==3) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn review_status" @endif  type="button" data-status="3" value="已审核" >
                                        <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态</span>
                                    @endif
                                </div>
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

            $(".viewContent").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '600px'],
                    content: content
                });
            });

            //审核
            $(".review_status").click(function () {

                var postData = {
                    "id": "{{$promote['id']}}",
                    "review_status": $(this).attr("data-status"),
                };
                $.post('/admin/promote/verify', postData, function (res) {
                    if (res.code == 1) {
                        //console.log(res);return false;
                        layer.msg(res.msg,{
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            window.location.href="/admin/promote/detail?id={{$promote['id']}}&currpage={{$currpage}}";
                        });
                    } else {
                        layer.msg(res.msg);
                    }
                }, "json");
            });

        });
    </script>
@stop
