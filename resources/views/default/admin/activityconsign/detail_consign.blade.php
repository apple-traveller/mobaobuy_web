@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')

    <div class="warpper">
        <div class="title"><a href="/admin/activity/consign?currentPage={{$currpage}}" class="s-back">返回</a>清仓特卖活动</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了清仓特卖活动的详细信息。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="mian-info">
                    <div class="switch_info user_basic" style="display:block;">
                        <form method="post" action="" name="theForm" id="user_update" novalidate="novalidate">

                            <div class="item">
                                <div class="label">&nbsp;商家名称：</div>
                                <div class="label_value font14">{{$consign_info['shop_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;商品名称：</div>
                                <div class="label_value font14">{{$consign_info['goods_name']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;单价：</div>
                                <div class="label_value font14">￥{{$consign_info['shop_price']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;库存数量(<span style="color:#909090;" class="unit-name">{{$good['unit_name']}}</span>)：</div>
                                <div class="label_value font14">{{$consign_info['goods_number']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;交货地：</div>
                                <div class="label_value font14">{{$consign_info['delivery_place']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;生产日期：</div>
                                <div class="label_value font14">{{$consign_info['production_date']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">&nbsp;业务员：</div>
                                <div class="label_value font14">{{$consign_info['salesman']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;手机号：</div>
                                <div class="label_value font14">{{$consign_info['contact_info']}}</div>
                            </div>

                            <div class="item">
                                <div class="label">&nbsp;QQ：</div>
                                <div class="label_value font14">{{$consign_info['QQ']}}</div>
                            </div>


                            <div class="item">
                                <div class="label">审核状态：</div>
                                <div class="value">
                                    @if($consign_info['consign_status']==1)
                                        已通过审核
                                    @else
                                    <input @if($consign_info['consign_status']==0) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="0" value="待审核" >
                                    <input @if($consign_info['consign_status']==2) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="2" value="审核不通过" >
                                    <input @if($consign_info['consign_status']==1) class="btn btn25 blue_btn pay_status" @else class="btn btn25 red_btn pay_status" @endif  type="button" data-id="1" value="已审核" >
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

            $(".pay_status").click(function(){

                var review_status = $(this).attr("data-id");
                $.post('/admin/activity/consign/modifyStatus',{'id':"{{$consign_info['id']}}",'review_status':review_status},function(res){
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
