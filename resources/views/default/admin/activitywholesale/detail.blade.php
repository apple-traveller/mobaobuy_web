@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/activity/wholesale?currentPage={{$currpage}}" class="s-back">返回</a>集采拼团详情</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了集采拼团的详细信息。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;商家名称：</div>
                                <div class="label_value font14">{{$result['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品名称：</div>
                                <div class="label_value font14">{{$result['goods_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;价格：</div>
                                <div class="label_value font14">{{$result['price']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;数量：</div>
                                <div class="label_value font14">{{$result['num']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;所属品牌：</div>
                                <div class="label_value font14">{{$result['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;开始时间：</div>
                                <div class="label_value font14">{{$result['begin_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;结束时间：</div>
                                <div class="label_value font14">{{$result['end_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;已参与数量：</div>
                                <div class="label_value font14">{{$result['partake_quantity']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;最小参与量：</div>
                                <div class="label_value font14">{{$result['min_limit']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;最大限购数量：</div>
                                <div class="label_value font14">{{$result['max_limit']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;定金比例：</div>
                                <div class="label_value font14">{{$result['deposit_ratio']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;添加时间：</div>
                                <div class="label_value font14">{{$result['add_time']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;点击次数：</div>
                                <div class="label_value font14">{{$result['click_count']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">审核状态：</div>
                                <div class="value">
                                    @if($result['review_status']==3)
                                        已通过审核
                                    @else
                                    <input @if($result['review_status']==1) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="1" value="待审核" >
                                    <input @if($result['review_status']==2) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="2" value="审核不通过" >
                                    <input @if($result['review_status']==3) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="3" value="已审核" >
                                    <span style="color: #00bbc8; margin-left: 20px;">点击按钮直接修改状态</span>
                                    @endif
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

            //修改支付状态
            $(".pay_status").click(function(){

                var review_status = $(this).attr("data-id");
                $.post('/admin/activity/wholesale/modifyStatus',{'id':"{{$result['id']}}",'review_status':review_status},function(res){
                    if(res.code==1){
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            window.location.reload();
                        });

                    }else{
                        alert(res.msg);
                    }
                },"json");
            });

        });
    </script>
@stop
