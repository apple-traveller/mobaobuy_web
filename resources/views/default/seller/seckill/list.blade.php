@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">订单 - 订单列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>商城所有的订单列表。</li>
                    <li>点击订单号即可进入详情页面对订单进行操作。</li>
                </ul>
            </div>
            <div class="flexilist mt30" id="listDiv">
                <div class="common-head order-coomon-head">
                        <div class="fl_label">
                            <a href="/seller/seckill/add"><div class="fbutton"><div class="add" title="添加秒杀申请"><span><i class="icon icon-plus"></i>添加秒杀申请</span></div></div></a>
                        </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/seller/order/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="order_sn" value="" class="text nofocus w180" placeholder="订单编号" autocomplete="off">
                                <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
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
                                    <th width="10%"><div class="tDiv">编号</div></th>
                                    <th width="10%"><div class="tDiv">店铺</div></th>
                                    <th width="10%"><div class="tDiv">申请时间</div></th>
                                    <th width="10%"><div class="tDiv">活动时间段</div></th>
                                    <th width="15%"><div class="tDiv">审核状态</div></th>
                                    <th width="25%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($list as $v)
                                    <tr class="">
                                        <td><div class="tDiv">{{$v['id']}}</div></td>
                                        <td><div class="tDiv">{{$v['shop_name']}}</div></td>
                                        <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                        <td><div class="tDiv">{{$v['seckill_time']}}</div></td>
                                        <td><div class="tDiv">@if($v['review_status']==1)待审核 @elseif($v['review_status']==2)审核不通过@elseif($v['review_status']==3)审核通过@endif</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="javascript:void(0)"  title="查看" class="btn_see" id="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                <a href="javascript:void(0)"  data_id = "{{$v['id']}}" data_page = "{{$currentPage}}" title="删除" class="btn_trash" id="btn_trash"><i class="sc_icon icon-trash"></i>删除</a>
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
        // window.location.reload();
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currentPage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/seller/seckill/list?currentPage="+obj.curr;
                        }
                    }
                });
            });
        }
        $('#btn_trash').click(function () {
            let seckill_id = $('#btn_trash').attr('data_id');
            let currentPage = $('#btn_trash').attr('data_page');
            $.ajax({
                'url':'/seller/seckill/delete',
                'data':{
                    'seckill_id': seckill_id,
                    'currentPage':currentPage
                },
                'type':'post',
                success:function (res) {
                    if (res.code == 1){
                        window.location.href="{{url('/seller/seckill/list')}}";
                    } else {
                        layer.msg(res.msg);
                    }
                }
            })
        });

        $("#btn_see").click(function () {
            layui.setTop(
                'title'
            );
        });
    </script>
@stop
