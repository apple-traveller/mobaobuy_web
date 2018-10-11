@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">订单 - 编辑订单</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>直接编辑文本框中的数据，鼠标离开时自动生效</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="mian-info">
                    <form name="theForm" action="" method="post" id="consignee" novalidate="novalidate">
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
                                        <th width="15%">产品编码</th>
                                        <th width="10%">价格</th>
                                        <th width="10%">购买数量</th>
                                        <th width="10%">已发货数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderGoods as $vo)
                                        <tr>
                                            <td>{{$vo['goods_name']}}[{{$vo['brand_name']}}]</td>
                                            <td>{{$vo['shop_name']}}</td>
                                            <td>{{$vo['goods_sn']}}</td>
                                            <td><input class="text goods_price" data-id="{{$vo['id']}}" style="width:50px;" type="text" value="{{$vo['goods_price']}}" ></td>
                                            <td><input class="text goods_number" data-id="{{$vo['id']}}" style="width:50px;" type="text" value="{{$vo['goods_number']}}" ></td>
                                            <td>{{$vo['send_number']}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>




                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="hidden" name="currpage" value="{{$currpage}}">


                        </div>

                        <div style="margin-top:-42px;margin-right:166px;" class="goods_btn">
                            <input type="button" value="返回" class="btn btn35 btn_blue" onclick="location.href='/admin/orderinfo/detail?id={{$id}}&currpage={{$currpage}}'">

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(".goods_price").blur(function(){

            var goods_price = $(this).val();
            var id = $(this).attr('data-id');
            var postData = {
                'id':id,
                'goods_price':goods_price,
                'order_id':"{{$id}}",
                'currpage':"{{$currpage}}"
            }
            var url = "/admin/orderinfo/saveOrderGoods";
            $.post(url, postData, function(res){
                console.log(res);
                if(res.code==1){
                    window.location.href=res.msg;
                }else{
                    alert('更新失败');
                }
            },"json");

        });

        $(".goods_number").blur(function(){

            var goods_number = $(this).val();
            var id = $(this).attr('data-id');
            var postData = {
                'id':id,
                'goods_number':goods_number,
                'order_id':"{{$id}}",
                'currpage':"{{$currpage}}"
            }
            var url = "/admin/orderinfo/saveOrderGoods";
            $.post(url, postData, function(res){
                console.log(res);
                if(res.code==1){
                    window.location.href=res.msg;
                }else{
                    alert('更新失败');
                }
            },"json");

        });
    </script>
@stop
