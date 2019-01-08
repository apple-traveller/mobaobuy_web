@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">店铺 - 店铺商品报价列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了所有店铺报价。</li>
                    <li>可根据店铺名称进行搜索。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/shopgoodsquote/addForm"><div class="fbutton"><div class="add" title="添加商品报价"><span><i class="icon icon-plus"></i>添加商品报价</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/shopgoodsquote/list" name="searchForm" >
                            <div class="input">
                                <select style="height:30px;float:left;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="shop_name" id="cat_id">
                                    <option value="0">全部店铺</option>
                                    @foreach($shops as $vo)
                                        <option @if($vo['shop_name']==$shop_name) selected @endif  value="{{$vo['shop_name']}}">{{$vo['shop_name']}}</option>
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
                                    <th width="10%"><div class="tDiv">商家名称</div></th>
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="5%"><div class="tDiv">商品编码</div></th>
                                    <th width="10%"><div class="tDiv">商品名称</div></th>
                                    <th width="5%"><div class="tDiv">库存数量</div></th>
                                    <th width="5%"><div class="tDiv">店铺售价</div></th>
                                    <th width="7%"><div class="tDiv">交货地</div></th>
                                    <th width="7%"><div class="tDiv">业务员</div></th>
                                    <th width="7%"><div class="tDiv">联系方式</div></th>
                                    <th width="7%"><div class="tDiv">生产日期</div></th>
                                    <th width="6%"><div class="tDiv">状态</div></th>
                                    <th width="16%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopGoodsQuote as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['store_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}</div></td>
                                    <td><div class="tDiv">￥{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['delivery_place']}}</div></td>
                                    <td><div class="tDiv">{{$vo['salesman']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contact_info']}}</div></td>
                                    <td><div class="tDiv">{{$vo['production_date']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['consign_status'] == 0)
                                                待审核
                                            @elseif($vo['consign_status'] == 2)
                                                <span class="red">审核不通过</span>
                                            @else
                                                @if($vo['expiry_time'] < date('Y-m-d H:i:s'))
                                                    <span class="red">已过期</span>
                                                @else
                                                    <span class="green">销售中</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="/admin/shopgoodsquote/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="javascript:void(0);" onclick="reRelease({{$vo['id']}})" title="更新发布" class="btn_edit"><i class="icon icon-edit"></i>更新发布</a>
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
                    , curr: "{{$currpage}}" //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/shopgoodsquote/list?currpage="+obj.curr+"&shop_name="+"{{$shop_name}}";
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
                    window.location.href="/admin/shopgoodsquote/delete?id="+id;
                    layer.close(index);
                });
            });
        }
        ///admin/shopgoodsquote/reRelease
        function reRelease(id){
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要重新发布此报价么?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url: "/admin/shopgoodsquote/reRelease",
                        dataType: "json",
                        data:{"id":id},
                        type:"get",
                        success:function(res){
                            if(res.code==1){
                                $.msg.alert('发布成功');
                                window.location.reload();
                            }else{
                                $.msg.alert(res.msg)
                            }
                        }
                    })
                });
            });
        }
    </script>
@stop
