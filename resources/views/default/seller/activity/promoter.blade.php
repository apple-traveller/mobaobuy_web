@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">优惠活动</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>

                </ul>
            </div>
            <div class="flexilist mt30" id="listDiv">
                <div class="common-head order-coomon-head">
                    <div class="fl_label">
                        <a href="/seller/activity/addPromoter"><div class="fbutton"><div class="add" title="申请"><span><i class="icon icon-plus"></i>添加申请</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/activity/Promoter" name="searchForm" >
                            <div class="input">
                                <input type="text" name="order_sn" value="" class="text nofocus w180" placeholder="商品名称" autocomplete="off">
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
                                    <th><div class="tDiv">编号</div></th>
                                    <th><div class="tDiv">申请时间</div></th>
                                    <th><div class="tDiv">促销商品</div></th>
                                    <th><div class="tDiv">促销价格</div></th>
                                    <th><div class="tDiv">促销总数量</div></th>
                                    <th><div class="tDiv">当前可销售数量</div></th>
                                    <th><div class="tDiv">最小起售量</div></th>
                                    <th><div class="tDiv">最大限购量</div></th>
                                    <th><div class="tDiv">开始时间</div></th>
                                    <th><div class="tDiv">结束时间</div></th>
                                    <th><div class="tDiv">审核状态</div></th>
                                    <th><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $k=>$v)
                                    <tr class="">
                                        <td><div class="tDiv">{{$v["id"]}}</div></td>
                                        <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                        <td><div class="tDiv">{{$v['goods_name']}}</div></td>
                                        <td><div class="tDiv">{{$v['price']}}</div></td>
                                        <td><div class="tDiv">{{$v['num']}}</div></td>
                                        <td><div class="tDiv">{{$v['available_quantity']}}</div></td>
                                        <td><div class="tDiv">{{$v['min_limit']}}</div></td>
                                        <td><div class="tDiv">{{$v['max_limit']}}</div></td>
                                        <td><div class="tDiv">{{$v['begin_time']}}</div></td>
                                        <td><div class="tDiv">{{$v['end_time']}}</div></td>
                                        <td><div class="tDiv">@if($v['review_status']==1)待审核 @elseif($v['review_status']==2)审核不通过@elseif($v['review_status']==3)审核通过@endif</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/seller/activity/addPromoter?id={{$v['id']}}"  title="编辑" class="btn_see"><i class="sc_icon sc_icon_see"></i>编辑</a>
                                                <a href="javascript:void(0);"  data_id = "{{$v['id']}}" data_page = "{{$currentPage}}" title="删除" class="btn_trash"><i class="sc_icon icon-trash"></i>删除</a>
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
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currentPage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/seller/activity/promoter?currentPage="+obj.curr;
                        }
                    }
                });
            });
        }
        $('.btn_trash').click(function () {
            let seckill_id = $(this).attr('data_id');
            console.log(seckill_id);
            $.ajax({
                url:'/seller/activity/deletePromoter',
                data:{
                    id: seckill_id
                },
                type:'post',
                success:function (res) {
                    if (res.code == 1){
                        layer.msg(res.msg);
                        setTimeout(window.location.reload(),2000);
                    } else {
                        layer.msg(res.msg);
                    }
                }
            })
        });
    </script>
@stop
