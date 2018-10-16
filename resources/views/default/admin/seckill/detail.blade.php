@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/seckill/list?currpage={{$pcurrpage}}" class="s-back">返回</a>秒杀活动 - 秒杀商品详情</div>
        <div class="content">

                <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>以下蓝色代表当前状态，修改状态请点击相应按钮</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="order_total_fr">
                        <div  class="layui-btn layui-btn-primary  @if($review_status==3) layui-btn-normal @endif" style="margin-right: 30px;"><a data-id="" href="/admin/seckill/verify?id={{$id}}&review_status=3">审核通过</a></div>
                        <div  class="layui-btn layui-btn-primary  @if($review_status==2) layui-btn-normal @endif"  style="margin-right: 30px;"><a href="/admin/seckill/verify?id={{$id}}&review_status=2">审核不通过</a></div>
                        <div  class="layui-btn layui-btn-primary  @if($review_status==1) layui-btn-normal @endif"  style="margin-right: 30px;"><a href="/admin/seckill/verify?id={{$id}}&review_status=1">待审核</a></div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="1" cellspacing="1">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">编号</div></th>
                                    <th width="15%"><div class="tDiv">商品名称</div></th>
                                    <th width="15%"><div class="tDiv">秒杀价格</div></th>
                                    <th width="15%"><div class="tDiv">秒杀总数量</div></th>
                                    <th width="10%"><div class="tDiv">闲置数量</div></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($seckill_goods as $vo)
                                <tr>
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['sec_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['sec_num']}}</div></td>
                                    <td><div class="tDiv">{{$vo['sec_limit']}}</div></td>
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
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/seckill/detail?currpage="+obj.curr;
                        }
                    }
                });
            });
        }

    </script>
@stop
