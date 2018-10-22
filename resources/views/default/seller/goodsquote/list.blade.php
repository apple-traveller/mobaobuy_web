@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">店铺 - 店铺商品报价列表</div>
        <div class="content">
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/seller/quote/add"><div class="fbutton"><div class="add" title="添加商品报价"><span><i class="icon icon-plus"></i>添加商品报价</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/quote/list" name="searchForm" >
                            <div class="input">
                                <select style="height:30px;float:left;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="goods_name" id="cat_id">
                                    <option value="0">全部商品</option>
                                    @foreach($goods as $vo)
                                        <option @if($vo['goods_name']==$goods_name) selected @endif  value="{{$vo['goods_name']}}">{{$vo['goods_name']}}</option>
                                    @endforeach
                                </select>
                                <input type="submit" class="btn"  ectype="secrch_btn" value="">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="5%"><div class="tDiv">商品编码</div></th>
                                    <th width="10%"><div class="tDiv">商品名称</div></th>
                                    <th width="5%"><div class="tDiv">库存数量</div></th>
                                    <th width="5%"><div class="tDiv">店铺售价</div></th>
                                    <th width="10%"><div class="tDiv">交货地</div></th>
                                    <th width="15%"><div class="tDiv">添加时间</div></th>
                                    <th width="15%"><div class="tDiv">截止时间</div></th>
                                    <th width="15%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopGoodsQuote as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}</div></td>
                                    <td><div class="tDiv">{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['delivery_place']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['expiry_time']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="/seller/quote/edit?id={{$vo['id']}}&currentPage={{$currentPage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div class="tDiv">

                                            <div class="list-page">


                                                <ul id="page"></ul>

                                                <style>
                                                    .pagination li{
                                                        float: left;
                                                        width: 30px;
                                                        line-height: 30px;}
                                                </style>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}" //每页显示的条数
                    , curr: "{{$currentPage}}" //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/seller/quote/list?currentPage="+obj.curr+"&goods_name="+"{{$goods_name}}";
                        }
                    }
                });
            });
        }


        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        'url':'/seller/quote/delete',
                        'data':{
                            'id':id
                        },
                        'type':'post',
                        success: function (res) {
                            console.log(res.code);
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:1000});
                                layer.close(index);
                                window.location.reload();
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    // window.location.href="/seller/quote/delete?id="+id;

                });
            });
        }
    </script>
@stop
