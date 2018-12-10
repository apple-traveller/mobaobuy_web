@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">物流 - 物流信息列表</div>
    <div class="content visible">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>展示网站维护的物流信息列表。</li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="/admin/logistics/add"><div class="fbutton"><div class="add" title="添加新物流信息"><span><i class="icon icon-plus"></i>添加新物流信息</span></div></div></a>
                </div>
                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                </div>
                <div class="search">
                    <form action="/admin/logistics/list" name="searchForm" >
                        <div class="input">
                            <input type="text" name="shipping_billno" value="{{$shipping_billno}}" class="text nofocus w180" placeholder="物流单号" autocomplete="off">
                            <input type="submit" class="btn"  ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">ID</div></th>
                                    <th width="10%"><div class="tDiv">运单号</div></th>
                                    <th width="10%"><div class="tDiv">添加时间</div></th>
                                    <th width="15%"><div class="tDiv">物流公司</div></th>
                                    <th width="15%" class="handle">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($logistics))
                            @foreach($logistics as $vo)
                            <tr class="">
                                <td><div class="tDiv">{{$vo['id']}}</div></td>
                                <td><div class="tDiv"><span style="cursor: pointer;color:red;" class="viewShippingContent" content="{{$vo['shipping_content']}}">{{$vo['shipping_billno']}}</span></div></td>
                                <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                <td><div class="tDiv">{{$vo['shipping_company']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="/admin/logistics/edit?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                        <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr class=""><td style="color:red;">未查询到数据</td></tr>
                            @endif
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
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/logistics/list?currpage="+obj.curr;
                        }
                    }
                });
            });
        }

        layui.use(['layer'], function() {
            var layer = layui.layer;
            $(".viewShippingContent").click(function(){
                var content = $(this).attr('content');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['410px', '200px'],
                    content: '<textarea style="margin-left:20px;margin-top:20px;" cols="50" rows="6">'+content+'</textarea>'
                });
            });
        });



        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/logistics/delete?id="+id;
                    layer.close(index);
                });
            });
        }

    </script>
@stop
