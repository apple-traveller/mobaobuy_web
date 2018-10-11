@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">店铺 - 店铺产品列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/shopgoods/addForm"><div class="fbutton"><div class="add" title="添加店铺产品"><span><i class="icon icon-plus"></i>添加店铺产品</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/shopgoods/list" name="searchForm" >
                            <div class="input">
                                <select style="height:30px;float:left;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="shop_name" id="cat_id">
                                    <option value="0">全部店铺</option>
                                    @foreach($shops as $vo)
                                        <option @if($vo['shop_name']==$shop_name) selected @endif  value="{{$vo['shop_name']}}">{{$vo['shop_name']}}</option>
                                    @endforeach
                                </select>
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
                                    <th width="10%"><div class="tDiv">产品编码</div></th>
                                    <th width="10%"><div class="tDiv">产品名称</div></th>
                                    <th width="10%"><div class="tDiv">库存数量</div></th>
                                    <th width="10%"><div class="tDiv">店铺售价</div></th>
                                    <th width="10%"><div class="tDiv">是否在售</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopGoods as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_sn']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['goods_number']}}</div></td>
                                    <td><div class="tDiv">{{$vo['shop_price']}}</div></td>
                                    <td><div class="tDiv">{{status($vo['is_on_sale'])}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="/admin/shopgoods/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}" //每页显示的条数
                    , curr: "{{$currpage}}" //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/shopgoods/list?currpage="+obj.curr+"&shop_name="+"{{$shop_name}}";
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
                    window.location.href="/admin/shopgoods/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
