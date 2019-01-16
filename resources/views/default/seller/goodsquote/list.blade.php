@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <style>
        .list-div .tDiv {
             padding: 0;
        }
        .list-div td .tDiv {
            padding: 10px 0;
        }
    </style>
    <div class="warpper">
        <div class="title">店铺 - 店铺商品报价列表</div>
        <div class="content">
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/seller/quote/add"><div class="fbutton"><div class="add" title="添加商品报价"><span><i class="icon icon-plus"></i>添加商品报价</span></div></div></a>
                        <div class="fbutton batchReRelease"><div class="add" title="批量更新报价"><span><i class="icon icon-refresh"></i>批量更新发布</span></div></div>
                        <div class="fbutton batchDelete"><div class="add" title="批量删除"><span><i class="icon icon-trash"></i>批量删除</span></div></div>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据">
                            <i class="icon icon-refresh" style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span" >刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/quote/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="goods_name" value="{{$goods_name}}" class="text nofocus w180" placeholder="商品名称" autocomplete="off">
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
                                    <th width="4%"><input type="checkbox" id="theadInp"/></th>
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="6%"><div class="tDiv">商品编码</div></th>
                                    <th width="10%"><div class="tDiv">商品名称</div></th>
                                    <th width="6%"><div class="tDiv">库存数量(KG)</div></th>
                                    <th width="6%"><div class="tDiv">店铺售价</div></th>
                                    <th width="6%"><div class="tDiv">业务员</div></th>
                                    <th width="6%"><div class="tDiv">联系方式</div></th>
                                    <th width="8%"><div class="tDiv">交货地</div></th>
                                    <th width="8%"><div class="tDiv">添加时间</div></th>
                                    <th width="8%"><div class="tDiv">生产日期</div></th>
                                    <th width="6%"><div class="tDiv">状态</div></th>
                                    <th width="16%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopGoodsQuote as $vo)
                                <tr class="">
                                    <td><div class="tDiv"><input type="checkbox" name="goods_id" value="{{$vo['id']}}"/></div></td>
                                    <td><div class="tDiv">{{$vo['store_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_full_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}</div></td>
                                    <td><div class="tDiv">￥{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['salesman']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contact_info']}}</div></td>
                                    <td><div class="tDiv">{{$vo['delivery_place']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
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
                                    <td>
                                        <div class="tDiv">
                                            <a href="/seller/quote/edit?id={{$vo['id']}}&currentPage={{$currentPage}}" title="编辑" class="btn_trash"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="javascript:void(0);" onclick="reRelease({{$vo['id']}})" title="更新发布" class="btn_trash"><i class="icon icon-refresh"></i>更新发布</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="13">
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


//        function remove(id)
//        {
//            layui.use('layer', function(){
//                var layer = layui.layer;
//                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
//                    $.ajax({
//                        'url':'/seller/quote/delete',
//                        'data':{
//                            'id':id
//                        },
//                        'type':'post',
//                        success: function (res) {
//                            console.log(res.code);
//                            if (res.code == 1){
//                                layer.msg(res.msg, {icon: 1,time:1000});
//                                layer.close(index);
//                                window.location.reload();
//                            } else {
//                                layer.msg(res.msg, {icon: 5,time:2000});
//                            }
//                        }
//                    });
//                    // window.location.href="/seller/quote/delete?id="+id;
//
//                });
//            });
//        }
        function remove(id)
        {
            toDelete([id])
        }
        function toDelete(ids){
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url: "/seller/quote/delete",
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
        function toAjax(ids){
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要重新发布报价么?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url: "/seller/quote/reRelease",
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
