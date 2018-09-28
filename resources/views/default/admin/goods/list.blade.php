@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">产品 - 产品列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了商城所有的商品信息，可对商品进行编辑修改操作。</li>
                    <li>可输入商品名称关键字进行搜索，侧边栏进行高级搜索。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/goods/addForm"><div class="fbutton"><div class="add" title="添加新产品"><span><i class="icon icon-plus"></i>添加新产品</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/goods/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="goods_name" value="{{$goods_name}}" class="text nofocus goods_name" placeholder="产品名称" autocomplete="off">
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
                                    <th width="5%"><div class="tDiv">产品编码</div></th>
                                    <th><div class="tDiv">产品名称</div></th>
                                    <th width="10%"><div class="tDiv">所属品牌</div></th>
                                    <th width="1%"><div class="tDiv">单位</div></th>
                                    <th width="8%"><div class="tDiv">产品型号</div></th>
                                    <th width="8%"><div class="tDiv">包装规格</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($goods as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['brand_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['unit_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_model']}}</div></td>
                                    <td><div class="tDiv">{{$vo['packing_spec']}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/goods/detail?id={{$vo['id']}}&currpage={{$currpage}}" title="查看" class="btn_edit"><i class="icon icon-edit"></i>查看</a>
                                            <a href="/admin/goods/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a><!---->
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div class="tDiv">

                                            <div class="list-page">
                                                <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->

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
                            var goods_name = $(".goods_name").val();
                            window.location.href="/admin/goods/list?currpage="+obj.curr+"&goods_name="+goods_name;
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
                    window.location.href="/admin/goods/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
