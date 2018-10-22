@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">店铺 - 店铺商品列表 </div>
        <div class="content">
            <div class="flexilist">
                <div class="common-head">
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/seller/goods/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="goods_name" value="{{$goods_name}}" class="text nofocus goods_name" placeholder="商品名称" autocomplete="off">
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
                                    <th width="5%"><div class="tDiv">编号</div></th>
                                    <th width="5%"><div class="tDiv">商品编码</div></th>
                                    <th><div class="tDiv">商品名称</div></th>
                                    <th width="10%"><div class="tDiv">所属品牌</div></th>
                                    <th width="1%"><div class="tDiv">单位</div></th>
                                    <th width="8%"><div class="tDiv">商品型号</div></th>
                                    <th width="8%"><div class="tDiv">包装规格</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['id']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['brand_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['unit_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_model']}}</div></td>
                                        <td><div class="tDiv">{{$vo['packing_spec']}}</div></td>
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
                            window.location.href="/seller/goods/list?currentPage="+obj.curr;
                        }
                    }
                });
            });
        }
    </script>
@stop
