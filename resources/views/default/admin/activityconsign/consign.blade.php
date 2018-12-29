@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">促销 - 寄售清仓</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>展示了所有清仓特卖相关信息列表。</li>
                    <li>展示信息有：商家名称、库存数量、起始时间等，可进行添加、编辑、删除或批量删除等操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/activity/consign/add"><div class="fbutton"><div class="add" title="添加清仓特卖"><span><i class="icon icon-plus"></i>添加清仓特卖</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据">
                            <i class="icon icon-refresh" style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span" >刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/activity/consign" name="searchForm" >
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
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="6%"><div class="tDiv">商品编码</div></th>
                                    <th width="10%"><div class="tDiv">商品名称</div></th>
                                    <th width="6%"><div class="tDiv">库存数量</div></th>
                                    <th width="6%"><div class="tDiv">报价总数</div></th>
                                    <th width="6%"><div class="tDiv">店铺售价</div></th>
                                    <th width="6%"><div class="tDiv">业务员</div></th>
                                    <th width="6%"><div class="tDiv">联系方式</div></th>
                                    <th width="9%"><div class="tDiv">交货地</div></th>
                                    <th width="9%"><div class="tDiv">添加时间</div></th>
                                    <th width="9%"><div class="tDiv">生产日期</div></th>
                                    <th width="7%"><div class="tDiv">活动状态</div></th>
                                    <th width="7%"><div class="tDiv">审核状态</div></th>
                                    <th width="9%"><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($consign_list))
                                @foreach($consign_list as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['store_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}{{$goods_unit}}</div></td>
                                    <td><div class="tDiv">{{$vo['total_number']}}{{$goods_unit}}</div></td>
                                    <td><div class="tDiv">￥{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{$vo['salesman']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contact_info']}}</div></td>
                                    <td><div class="tDiv">{{$vo['delivery_place']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['production_date']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['consign_status'] == 0 && ($vo['expiry_time'] > \Carbon\Carbon::now() || $vo['expiry_time'] == null))
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待开始</div>
                                            @elseif($vo['consign_status'] == 1 && ($vo['expiry_time'] > \Carbon\Carbon::now() || $vo['expiry_time'] == null))
                                                <div class='layui-btn layui-btn-sm layui-btn-radius '>进行中</div>
                                            @else
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-danger'>已结束</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['consign_status']==0)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待审核</div>
                                            @elseif($vo['consign_status']==2)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-danger'>不通过</div>
                                            @elseif($vo['consign_status']==1)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius '>审核通过</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/activity/consign/detail?id={{$vo['id']}}&currpage={{$currentPage}}" title="查看" class="btn_see">
                                                <i class="sc_icon sc_icon_see"></i>
                                                @if($vo['consign_status']==1)
                                                    查看
                                                @else
                                                    审核
                                                @endif
                                            </a>
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="/admin/activity/consign/edit?id={{$vo['id']}}&currentPage={{$currentPage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                    <tr class=""> <td style="color:red;">未查询到数据</td></tr>
                                @endif
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
                            window.location.href="/admin/activity/consign?currentPage="+obj.curr+"&goods_name="+"{{$goods_name}}";
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
                        'url':'/admin/shopgoodsquote/delete',
                        'data':{
                            'id':id
                        },
                        'type':'get',
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
                });
            });
        }
    </script>
@stop
