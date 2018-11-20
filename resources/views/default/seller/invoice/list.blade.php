@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">发票管理</div>
        <div class="content">
            <div class="flexilist">
                <div class="common-head">
                    <div class="order_state_tab">
                        <a href="/seller/invoice/list" @if($status=='') class="current" @endif>全部订单@if($status=='') <em>({{$total}})</em> @endif</a>
                        <a href="/seller/invoice/list?status=1" @if($status==1) class="current" @endif>待开票@if($status==1) <em>({{$total}})</em> @endif</a>
                        <a href="/seller/invoice/list?status=2" @if($status==2) class="current" @endif>已开票@if($status==2) <em>({{$total}})</em> @endif</a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据">
                            <i class="icon icon-refresh" style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span" >刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/invoice/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="member_phone" value="{{ $member_phone }}" class="text nofocus w180" placeholder="买家手机号" autocomplete="off">
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
                                        <div class="tDiv a2">
                                            <a href="/seller/invoice/detail?invoice_id={{$v['id']}}&currentPage={{$currentPage}}" title="详情" class="btn_see"><i class="sc_icon sc_icon_see"></i>详情</a>
                                            @if($v['status']==1)
                                            <a href="javascript:void(0);" title="审核" id="{{$v['id']}}" onclick="conf({{$v['id']}})" class="btn_see"><i class="icon icon-edit"></i>审核</a>
                                            <a href="javascript:void(0);" title="取消" onclick="cancelOne({{$v['id']}})" class="btn_see"><i class="icon icon-trash"></i>取消</a>
                                            @endif
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


        function conf(id)
        {
            console.log(3423);
            layui.use(['layer'], function(){
                let layer = layui.layer;
                let index =
                    layer.open({
                        type: 2,
                        title: "审核",
                        id: "link1",
                        shade: 0,
                        resize: false,
                        area: ['600px', '300px'],
                        offset: 't',
                        maxmin: true,
                        content: '/seller/invoice/choseExpress?invoice_id='+id,
                        success: function(layero){
                            layer.setTop(layero); //重点2
                        },
                        end:function () {
                            window.location.reload();
                        }
                    });
            });
        }
        //作废订单
        function cancelOne(id)
        {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('是否取消?', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        url:'/seller/invoice/cancelInvoice',
                        data: {
                            'invoice_id':id,
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1) {
                                layer.msg(res.msg, {icon: 1,time:600});
                                window.location.reload();
                            } else {
                                layer.msg(res.msg, {icon: 5,time:3000});
                                window.location.reload();
                            }
                        }
                    });

                });
            });
        }
    </script>
@stop
