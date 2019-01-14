@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">商品分类 - 参数配置</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了所有分类的配置信息，可对配置进行编辑修改操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/goodscategoryquoteconfig/addForm"><div class="fbutton"><div class="add" title="添加新配置"><span><i class="icon icon-plus"></i>添加新配置</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/goodscategoryquoteconfig/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="cat_name" value="{{$cat_name}}" class="text nofocus cat_name" placeholder="分类名称" autocomplete="off">
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
                                    <th><div class="tDiv">编号</div></th>
                                    <th><div class="tDiv">分类名称</div></th>
                                    <th><div class="tDiv">最大值</div></th>
                                    <th><div class="tDiv">最小值</div></th>
                                    <th class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $v)
                                <tr class="">
                                    <td><div class="tDiv">{{$v['id']}}</div></td>
                                    <td><div class="tDiv">{{$v['cat_name']}}</div></td>
                                    <td><div class="tDiv">{{$v['max']}}</div></td>
                                    <td><div class="tDiv">{{$v['min']}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/goodscategoryquoteconfig/editForm?id={{$v['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="javascript:void(0);" onclick="remove({{$v['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
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

                            window.location.href="/admin/goodscategoryquoteconfig/list?currpage="+obj.curr+"&cat_name={{$cat_name}}";
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
                    window.location.href="/admin/goodscategoryquoteconfig/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
