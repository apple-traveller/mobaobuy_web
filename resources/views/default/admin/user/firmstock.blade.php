@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/user/list?review_status={{$review_status}}&currpage={{$pcurrpage}}" class="s-back">返回</a>企业 - 库存列表</div>
        <div class="content">

            <div class="flexilist">
                <!--商品分类列表-->
                <div class="common-head">
                    <div class="refresh ml0">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" >
                        <div class="list-div" id="listDiv">

                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>

                                    <th width="5%"><div class="tDiv">企业名称</div></th>
                                    <th width="30%"><div class="tDiv">商品名称</div></th>
                                    <th width="12%"><div class="tDiv">库存数</div></th>
                                    <th width="30%"><div class="tDiv">操作</div></th>

                                </tr>
                                </thead>
                                <tbody>
                                @if($total==0)
                                <tr class=""><td class="no-records" colspan="12">没有找到任何记录</td></tr>
                                @else
                                    @foreach($firm_stocks as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['nick_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['number']}}</div></td>
                                        <td><div class="tDiv"><div data-firm-id="{{$firm_id}}" data-goods-id="{{$vo['goods_id']}}" class="layui-btn  layui-btn-sm firm_stock_flow">查看流水</div></div></td>
                                    </tr>
                                    @endforeach
                                @endif
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
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/user/firmStock?currpage="+obj.curr+"&firm_id={{$firm_id}}"+"&review_status={{$review_status}}"+"&pcurrpage={{$pcurrpage}}";
                        }
                    }
                });
            });
        }



        layui.use(['layer','laypage'], function() {
            var layer = layui.layer;
            var laypage = layui.laypage;


            $(".firm_stock_flow").click(function(){

                var firm_id = $(this).attr("data-firm-id");
                var goods_id = $(this).attr("data-goods-id");
                var currpage = 1;
                $.ajax({
                    type: "POST",
                    url: "/admin/user/firmStockFlow",
                    data: {"currpage":currpage,"firm_id":firm_id,"goods_id":goods_id},
                    dataType: "json",
                    success: function(res){
                        if(res.code==200){
                            var data = res.data;
                            var list = data.list;
                            var currpage = data.currpage;
                            var total = data.total;
                            var pageSize = data.pageSize;
                            var html = '<div class="list-div" id="listDiv">' +
                                '<table cellpadding="0" cellspacing="0" border="0">' +
                                '<thead>' +
                                '<tr>' +
                                '<th width="15%"><div class="tDiv">业务伙伴名称</div></th>' +
                                '<th width="5%"><div class="tDiv">流水类型</div></th>' +
                                '<th width="10%"><div class="tDiv">商品名称</div></th>' +
                                '<th width="10%"><div class="tDiv">出入库数量</div></th>' +
                                '<th width="20%"><div class="tDiv">描述</div></th>' +
                                '<th width="10%"><div class="tDiv">流水时间</div></th>' +
                                '<th width="10%"><div class="tDiv">订单号</div></th>' +
                                '<th width="10%"><div class="tDiv">价格</div></th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody class="ajaxStock">';

                            for(var i=0;i<list.length;i++){
                                html += '<tr class="">' +
                                    '<td><div class="tDiv">'+list[i].partner_name+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].flow_type+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].goods_name+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].number+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].flow_desc+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].flow_time+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].order_sn+'</div></td>' +
                                    '<td><div class="tDiv">'+list[i].price+'</div></td>' +
                                    '</tr>'
                            }

                            html += '</tbody>' +
                                '<tfoot>' +
                                '<tr><td colspan="12"><div class="tDiv">' +
                                '<div class="list-page">' +
                                '<ul id="page2"></ul>' +
                                '<style>.pagination li{ float: left;width: 30px;line-height: 30px;}</style>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '</div>';

                            index = layer.open({
                                type: 1,
                                title: '库存流水',
                                area: ['950px', '580px'],
                                content: html
                            });

                            laypage.render({
                                elem: 'page2'
                                , count: total //数据总数，从服务端得到
                                , limit: pageSize   //每页显示的条数
                                , curr: currpage  //当前页
                                , jump: function (obj, first) {
                                    if (!first) {
                                        getStockFlow(obj.curr,firm_id,goods_id)
                                    }
                                }
                            });

                        }else{
                            layer.msg(res.msg);
                        }
                    }
                });

            function getStockFlow(currpage,firm_id,goods_id){
                 $.ajax({
                     type: "POST",
                     url: "/admin/user/firmStockFlow",
                     data: {"currpage":currpage,"firm_id":firm_id,"goods_id":goods_id},
                     dataType: "json",
                     success: function(res){
                         if(res.code==200){
                             var data = res.data;
                             var list = data.list;
                             var currpage = data.currpage;
                             var total = data.total;
                             var pageSize = data.pageSize;
                             var html = ''

                             $(".ajaxStock").find('*').remove();

                             for(var i=0;i<list.length;i++){
                                 html += '<tr class="">' +
                                     '<td><div class="tDiv">'+list[i].partner_name+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].flow_type+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].goods_name+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].number+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].flow_desc+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].flow_time+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].order_sn+'</div></td>' +
                                     '<td><div class="tDiv">'+list[i].price+'</div></td>' +
                                     '</tr>'
                             }

                             $(".ajaxStock").append(html);

                         }else{
                             layer.msg(res.msg);
                         }
                     }
                 });
            }








            });

        });
    </script>
@stop
