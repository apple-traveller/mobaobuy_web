@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">发票管理</div>
        <div class="content">
            <div class="flexilist">
                <div class="common-head">
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/invoice/list" name="searchForm" >
                            <div class="input">

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
                                    <th><div class="tDiv">买家</div></th>
                                    <th><div class="tDiv">买家电话号</div></th>
                                    <th><div class="tDiv">订单数量</div></th>
                                    <th><div class="tDiv">发票总金额</div></th>
                                    <th><div class="tDiv">申请状态</div></th>
                                    <th><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $k=>$v)
                                <tr class="">
                                    <td><div class="tDiv">{{$v['user_name']}}</div></td>
                                    <td><div class="tDiv">{{$v['member_phone']}}</div></td>
                                    <td><div class="tDiv">{{$v['order_quantity']}}</div></td>
                                    <td><div class="tDiv">{{$v['invoice_amount']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($v['status'] == 0) 已取消 @elseif($v['status'] == 1) 待开票 @elseif($v['status']==2) 已开票 @endif
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/seller/invoice/detail?invoice_id={{$v['id']}}&currentPage={{$currentPage}}" title="详情" class="btn_see"><i class="sc_icon sc_icon_see"></i>详情</a>
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
                            {{--window.location.href="/seller/quote/list?currentPage="+obj.curr+"&goods_name="+"{{$goods_name}}";--}}
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
