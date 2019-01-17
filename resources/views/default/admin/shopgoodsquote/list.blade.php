@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <style>
        .list-div .tDiv {
            padding: 0;
        }
        .list-div td .tDiv {
            padding: 10px 0;
        }
        .layui-laypage select{width:80px;}
    </style>
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
                        <div class="fbutton batchReRelease"><div class="add" title="批量更新报价"><span><i class="icon icon-refresh"></i>批量更新发布</span></div></div>
                        <div class="fbutton batchDelete"><div class="add" title="批量删除"><span><i class="icon icon-trash"></i>批量删除</span></div></div>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/shopgoodsquote/list" name="searchForm" >
                            <input type="hidden" name="pagesize" value="{{$pageSize}}"/>
                            <div class="input" style="margin-right: 20px">
                                <input style="height:30px;" type="text" name="goods_name" value="{{$goods_name}}" class="text nofocus goods_name" placeholder="商品名称" autocomplete="off">
                            </div>
                            <div class="input">
                                <select style="height:30px;float:left;border:0;border-right: 1px solid #dbdbdb;line-height:30px;width:150px;" name="shop_name" id="cat_id">
                                    <option value="0">全部店铺</option>
                                    @foreach($shops as $vo)
                                        <option @if($vo['shop_name']==$shop_name) selected @endif  value="{{$vo['shop_name']}}">{{$vo['shop_name']}}</option>
                                    @endforeach
                                </select>
                                <input type="submit" class="btn" style="border-left:0" ectype="secrch_btn" value="">
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
                                    <th width="4%"><input type="checkbox" id="theadInp"/></th>
                                    <th width="8%"><div class="tDiv">商家名称</div></th>
                                    <th width="8%"><div class="tDiv">店铺名称</div></th>
                                    <th width="5%"><div class="tDiv">商品编码</div></th>
                                    <th width="9%"><div class="tDiv">商品名称</div></th>
                                    <th width="5%"><div class="tDiv">库存数量</div></th>
                                    <th width="5%"><div class="tDiv">店铺售价</div></th>
                                    <th width="6%"><div class="tDiv">交货地</div></th>
                                    <th width="6%"><div class="tDiv">业务员</div></th>
                                    <th width="6%"><div class="tDiv">联系方式</div></th>
                                    <th width="7%"><div class="tDiv">发布时间</div></th>
                                    <th width="4%"><div class="tDiv">是否置顶</div></th>
                                    <th width="4%"><div class="tDiv">状态</div></th>
                                    <th width="22%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopGoodsQuote as $vo)
                                <tr class="">
                                    <td><div class="tDiv"><input type="checkbox" name="goods_id" value="{{$vo['id']}}"/></div></td>
                                    <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['store_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}</div></td>
                                    <td><div class="tDiv">￥{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['delivery_place']}}</div></td>
                                    <td><div class="tDiv">{{$vo['salesman']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contact_info']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['is_roof'] == 1)
                                                是
                                            @else
                                                否
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['consign_status'] == 0)
                                                待审核
                                            @elseif($vo['consign_status'] == 2)
                                                <span class="red">审核不通过</span>
                                            @else
                                                @if($vo['expiry_time'] < date('Y-m-d H:i:s'))
                                                    <span class="red">已过期</span>
                                                @elseif($vo['goods_number'] <= 0)
                                                    <span class="red">已售罄</span>
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
                                            <a href="javascript:void(0);" onclick="reRelease({{$vo['id']}})" title="更新发布" class="btn_edit"><i class="icon icon-refresh"></i>更新发布</a>
                                            @if($vo['is_roof'] == 1)
                                                <a href="javascript:void(0);" onclick="onRoof('{{$vo['id']}}',1)" title="取消置顶" class="btn_edit"><i class="icon icon-edit"></i>取消置顶</a>
                                            @else
                                                <a href="javascript:void(0);" onclick="onRoof('{{$vo['id']}}',0)" title="置顶" class="btn_edit"><i class="icon icon-edit"></i>置顶</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="14">
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
                    ,limits:[10, 20, 30, 40, 50]
                    ,layout: ['count', 'prev', 'page', 'next', 'limit']
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/shopgoodsquote/list?currpage="+obj.curr+"&pagesize="+obj.limit+"&shop_name="+"{{$shop_name}}";
                        }
                    }
                });
            });
        }

        function onRoof(id,_is_cancel){
            toRoof([id],_is_cancel);
        }
        function remove(id)
        {
            toDelete([id])
        }
        function toRoof(ids,_is_cancel){
            var _info = _is_cancel == 1 ? '取消置顶' : '置顶';
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要'+_info+'吗?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url: "/admin/shopgoodsquote/roof",
                        dataType: "json",
                        data:{"ids":ids,"is_cancel":_is_cancel},
                        type:"get",
                        success:function(res){
                            if(res.code==1){
                                layer.msg(_info+'成功！',{time:2000});
                                setTimeout(function () { window.location.reload(); }, 2000);
                            }else{
                                layer.alert(res.msg);
                            }
                        }
                    });
                    layer.close(index);
                });
            });
        }
        function toDelete(ids){
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
//                    window.location.href="/admin/shopgoodsquote/delete?id="+id;
                    $.ajax({
                        url: "/admin/shopgoodsquote/delete",
                        dataType: "json",
                        data:{"ids":ids},
                        type:"get",
                        success:function(res){
                            if(res.code==1){
                                layer.msg('删除成功！',{time:2000});
                                setTimeout(function () { window.location.reload(); }, 2000);
                            }else{
                                layer.alert(res.msg);
                            }
                        }
                    });
                    layer.close(index);
                });
            });
        }
        //重新报价
        function toAjax(ids){
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要重新发布报价么?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url: "/admin/shopgoodsquote/reRelease",
                        dataType: "json",
                        data:{"ids":ids},
                        type:"get",
                        success:function(res){
                            if(res.code==1){
                                layer.msg('发布成功！',{time:2000});
                                setTimeout(function () { window.location.reload(); }, 2000);
                            }else{
                                layer.alert(res.msg);
                            }
                        }
                    });
                    layer.close(index);
                });
            });
        }
        //重新报价
        function reRelease(id){
            toAjax([id])
        }
        $(function() {
            //实现全选反选
            $("#theadInp").on('click', function() {
                $("tbody input:checkbox").prop("checked", $(this).prop('checked'));
            });
            $("tbody input:checkbox").on('click', function() {
                //当选中的长度等于checkbox的长度的时候,就让控制全选反选的checkbox设置为选中,否则就为未选中
                if($("tbody input:checkbox").length === $("tbody input:checked").length) {
                    $("#theadInp").prop("checked", true);
                } else {
                    $("#theadInp").prop("checked", false);
                }
            });
            $('.batchReRelease').click(function(){
                var _goods_ids = [];
                $.each($('input[name=goods_id]:checked'),function(){
                    _goods_ids.push($(this).val());
                });
                toAjax(_goods_ids);
            });
            $('.batchDelete').click(function(){
                var _goods_ids = [];
                $.each($('input[name=goods_id]:checked'),function(){
                    _goods_ids.push($(this).val());
                });
                toDelete(_goods_ids);
            });

        })
    </script>
@stop
