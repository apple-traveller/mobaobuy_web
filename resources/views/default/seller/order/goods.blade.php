@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title"><a href="/seller/order/detail?id={{$id}}&currentPage={{$currentPage}}" class="s-back">返回</a>订单 - 编辑商品</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>直接编辑文本框中的数据，鼠标离开时自动生效</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form name="theForm" method="post" id="consignee" novalidate="novalidate">
                        <div class="switch_info" style="display: block;">
                            <div class="step_title pb5">
                                <i class="ui-step"></i>
                                <h3 class="fl">请编辑商品信息</h3>
                            </div>

                            <div class="list-div" id="listDiv">
                                <table class="table" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th width="15%" class="first">商品名称 [ 品牌 ]</th>
                                        <th width="10%">所属店铺</th>
                                        <th width="15%">商品编码</th>
                                        <th width="10%">价格</th>
                                        <th width="10%">购买数量</th>
                                        <th width="10%">已发货数量</th>
                                        <th width="10%">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderGoods as $vo)
                                        <tr>
                                            <td>{{$vo['goods_name']}}[{{$vo['brand_name']}}]</td>
                                            <td>{{$vo['shop_name']}}</td>
                                            <td>{{$vo['goods_sn']}}</td>
                                            <td class="goods_price"><input  class="text"  style="width:50px;" type="text" value="{{$vo['goods_price']}}" ></td>
                                            <td class="goods_number"><input  class="text"  style="width:50px;" type="text" value="{{$vo['goods_number']}}" ></td>
                                            <td>{{$vo['send_number']}}</td>
                                            <td><input  type="button" data-id="{{$vo['id']}}" class="btn btn35 blue_btn changGoods" value="确定修改" id="submitBtn"></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div style="float:right;margin-top:30px;" class="goodsAmount">
                                    <div style='color:red;font-size:20px;'>商品总金额：{{$goods_amount}}</div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        layui.use(['layer'], function() {
            var layer = layui.layer;
            var index = 0;
            $(".changGoods").click(function () {

                var goods_price = $(this).parent('td').siblings('.goods_price').children('input').val();
                var goods_number = $(this).parent('td').siblings('.goods_number').children('input').val();
                var id = $(this).attr('data-id');
                var postData = {
                    'id': id,
                    'goods_price': goods_price,
                    'goods_number': goods_number,
                    'order_id': "{{$id}}"
                }

                var url = "/seller/order/saveGoods";
                $.post(url, postData, function (res) {
                    console.log(res.data);
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            $(".goodsAmount").html("<div style='color:red;font-size:20px;'>商品总金额："+res.data+"</div>");
                        });
                    } else {
                        alert('更新失败');
                    }
                }, "json");

            });

        });
    </script>
@stop
