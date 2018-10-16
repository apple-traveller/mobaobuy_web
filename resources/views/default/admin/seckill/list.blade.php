@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">促销 - 秒杀活动列表</div>
        <div class="content">

                <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>请先设置秒杀时间段。</li>
                    <li>秒杀活动列表可对活动进行编辑/删除/设置商品操作。</li>
                    <li>秒杀截止时间内多个活动可同时进行。</li>
                    <li>秒杀活动时间都是从0点到0点。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href=""><div class="fbutton"><div class="add" title="添加秒杀活动"><span><i class="icon icon-plus"></i>添加秒杀活动</span></div></div></a>
                        <a href=""><div class="fbutton"><div class="add" title="秒杀时间段列表"><span>秒杀时间段列表</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/seckill/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="shop_name" value="{{$shop_name}}" class="text nofocus" placeholder="店铺名称" autocomplete="off">
                                <input type="submit" class="btn"  ectype="secrch_btn" value="">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="1" cellspacing="1">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">编号</div></th>
                                    <th width="15%"><div class="tDiv">商家名称</div></th>
                                    <th width="15%"><div class="tDiv">开始时间</div></th>
                                    <th width="15%"><div class="tDiv">结束时间</div></th>
                                    <th width="10%"><div class="tDiv">上线/下架</div></th>
                                    <th width="15%"><div class="tDiv">审核状态</div></th>
                                    <th width="10%"  class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($seckills as $vo)
                                <tr>
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['begin_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['end_time']}}</div></td>

                                    <td>
                                        <div class="tDiv">
                                            <div class="switch @if($vo['enabled']) active @endif" title="@if($vo['enabled']) 是 @else 否 @endif" onclick="listTable.switchBt(this, '{{url('/admin/seckill/change/status')}}','{{$vo['id']}}')">
                                                <div class="circle"></div>
                                            </div>
                                            <input type="hidden" value="0" name="">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tDiv">
                                            @if($vo['review_status']==1)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待审核</div>
                                            @elseif($vo['review_status']==2)
                                                <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-danger'>审核不通过</div>
                                            @else
                                                <div class='layui-btn layui-btn-sm layui-btn-radius '>已审核</div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/adminuser/detail?id={{$vo['id']}}&currpage={{$currpage}}" title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                            <a href="/admin/adminuser/delete?id={{$vo['id']}}" title="删除" class="btn_see"><i class="icon icon-trash"></i>删除</a>
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
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/seckill/list?currpage="+obj.curr+"&shop_name={{$shop_name}}";
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
                    window.location.href="/admin/adminuser/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
