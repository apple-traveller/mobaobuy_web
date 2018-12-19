@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">促销 - 集采火拼列表</div>
        <div class="content">

            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>展示了所有优惠活动相关信息列表。</li>
                    <li>展示信息有：商家名称、集采火拼名称、起始时间等，可进行添加、编辑、删除或批量删除等操作。</li>
                </ul>
            </div>

            <div class="flexilist">
                <div class="common-head">
                    <div class="order_state_tab">
                        <a href="/admin/activity/wholesale?is_expire=0" @if($is_expire==0) class="current" @endif>全部<em @if($is_expire!=0) style="display:none;" @endif>({{$total}})</em></a>
                        <a href="/admin/activity/wholesale?is_expire=1" @if($is_expire==1) class="current" @endif>进行中<em @if($is_expire!=1) style="display:none;" @endif>({{$total}})</em></a>
                        <a href="/admin/activity/wholesale?is_expire=2" @if($is_expire==2) class="current" @endif>已结束<em @if($is_expire!=2) style="display:none;" @endif>({{$total}})</em></a>
                    </div>
                    <div class="fl">
                        <a href="/admin/activity/wholesale/add"><div style="margin-left:10px;margin-top:6px;" class="fbutton"><div class="add" title="添加集采火拼活动"><span><i class="icon icon-plus"></i>添加集采火拼活动</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/activity/wholesale" name="searchForm" >
                            <div class="input">
                                <input type="text" name="shop_name" value="{{$shop_name}}" class="text nofocus" placeholder="商家名称" autocomplete="off">
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
                                    <th><div class="tDiv">编号</div></th>
                                    <th><div class="tDiv">申请时间</div></th>
                                    <th><div class="tDiv">商家名称</div></th>
                                    <th><div class="tDiv">拼团商品</div></th>
                                    <th><div class="tDiv">拼团价格</div></th>
                                    <th><div class="tDiv">目标数量</div></th>
                                    <th><div class="tDiv">已参与数量</div></th>
                                    {{--<th><div class="tDiv">最小拼团量</div></th>
                                    <th><div class="tDiv">最大限购量</div></th>
                                    <th><div class="tDiv">订金比例</div></th>
                                    <th><div class="tDiv">开始时间</div></th>
                                    <th><div class="tDiv">结束时间</div></th>--}}
                                    <th><div class="tDiv">活动状态</div></th>
                                    <th><div class="tDiv">审核状态</div></th>
                                    <th><div class="tDiv">操作</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($list))
                                @foreach($list as $k=>$v)
                                    <tr class="">
                                        <td><div class="tDiv">{{$v["id"]}}</div></td>
                                        <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                        <td><div class="tDiv">{{$v['shop_name']}}</div></td>
                                        <td><div class="tDiv">{{$v['goods_name']}}</div></td>
                                        <td><div class="tDiv">¥{{$v['price']}}</div></td>
                                        <td><div class="tDiv">{{$v['num']}}{{$goods_unit}}</div></td>
                                        <td><div class="tDiv">{{$v['partake_quantity']}}{{$goods_unit}}</div></td>
                                        {{--<td><div class="tDiv">{{$v['min_limit']}}</div></td>
                                        <td><div class="tDiv">{{$v['max_limit']}}</div></td>
                                        <td><div class="tDiv">{{$v['deposit_ratio']}}</div></td>
                                        <td><div class="tDiv">{{$v['begin_time']}}</div></td>
                                        <td><div class="tDiv">{{$v['end_time']}}</div></td>--}}
                                        <td>
                                            <div class="tDiv">
                                                {{--
                                                    待开始（待审核、审核通过但是结束时间大于当前时间）
                                                    进行中（审核通过并且时间在区间内）
                                                    已结束（审核不通过或者结束时间小于当前时间）
                                                --}}
                                                @if($v['review_status']==1 && $v['end_time'] > \Carbon\Carbon::now())
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待开始</div>
                                                @elseif($v['review_status']==3 && $v['begin_time'] < \Carbon\Carbon::now() &&  $v['end_time'] > \Carbon\Carbon::now())
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius '>进行中</div>
                                                @else
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-danger'>已结束</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td><div class="tDiv">
                                                @if($v['review_status']==1)
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>待审核</div>
                                                @elseif($v['review_status']==2)
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-danger'>不通过</div>
                                                @elseif($v['review_status']==3)
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius '>审核通过</div>
                                                @endif</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/activity/wholesale/detail?id={{$v['id']}}&currpage={{$currentPage}}&is_expire={{$is_expire}}" title="查看" class="btn_see">
                                                    <i class="sc_icon sc_icon_see"></i>
                                                    @if($v['review_status']==3)
                                                    查看
                                                    @else
                                                        审核
                                                    @endif
                                                </a>
                                                <a href="/admin/activity/wholesale/add?id={{$v['id']}}&currpage={{$currentPage}}&is_expire={{$is_expire}}"  title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                                <a href="/admin/activity/wholesale/delete?id={{$v['id']}}&currentPage={{$currentPage}}"  data_id="{{$v['id']}}" data_page = "{{$currentPage}}" title="删除" class="btn_trash"><i class="sc_icon icon-trash"></i>删除</a>
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
                                    <td colspan="14">
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
                            window.location.href="/admin/activity/wholesale?currpage="+obj.curr+"&shop_name={{$shop_name}}"+"&is_expire={{$is_expire}}";
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
                    window.location.href="/admin/promote/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
