@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">商家 - 入驻供应商列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>平台所有入驻商相关信息管理。</li>
                    <li>可对入驻商进行分派权限操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/shop/addForm"><div class="fbutton"><div class="add" title="添加新商家"><span><i class="icon icon-plus"></i>添加新商家</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/shop/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="shop_name" value="{{$shop_name}}" class="text nofocus shop_name" placeholder="商家名称" autocomplete="off">
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
                                    {{--<th width="10%"><div class="tDiv">商家名称</div></th>--}}
                                    <th width="20%"><div class="tDiv">企业全称</div></th>
                                    <th width="8%"><div class="tDiv">负责人姓名</div></th>
                                    <th width="10%"><div class="tDiv">负责人手机</div></th>
                                    <th width="8%"><div class="tDiv">访问次数</div></th>
                                    <th width="8%"><div class="tDiv">是否通过审核</div></th>
                                    <th width="8%"><div class="tDiv">是否冻结</div></th>
                                    <th width="8%"><div class="tDiv">是否自营</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shops as $vo)
                                <tr class="">
                                    {{--<td><div class="tDiv">{{$vo['shop_name']}}</div></td>--}}
                                    <td><div class="tDiv">{{$vo['company_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contactName']}}</div></td>
                                    <td><div class="tDiv">{{$vo['contactPhone']}}</div></td>
                                    <td><div class="tDiv">{{$vo['visit_count']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            @if($vo['is_validated']==1)
                                                <div  class='review_status layui-btn layui-btn-sm layui-btn-radius '>已审核</div>
                                            @else
                                                <div class='review_status layui-btn layui-btn-sm layui-btn-radius  layui-btn-primary  '>待审核</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tDiv">
                                            <div class="switch @if($vo['is_freeze']) active @endif" title="@if($vo['is_freeze']) 是 @else 否 @endif" style="float: none;margin: 0 auto;" onclick="listTable.switchBt(this, '{{url('/admin/shop/change/isFreeze')}}','{{$vo['id']}}')">
                                                <div class="circle"></div>
                                            </div>
                                            <input type="hidden" value="0" name="">
                                        </div>
                                    </td>
                                    <td><div class="tDiv">{{status($vo['is_self_run'])}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/shop/detail?id={{$vo['id']}}&currpage={{$currpage}}" title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看并审核</a>
                                            <a href="/admin/shop/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="/admin/shop/logList?shop_id={{$vo['id']}}&currpage={{$currpage}}" title="日志" class="btn_edit"><i class="sc_icon sc_icon_see"></i>日志</a>
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
                            window.location.href="/admin/shop/list?currpage="+obj.curr+"&shop_name={{$shop_name}}";
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
                    window.location.href="/admin/shop/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
