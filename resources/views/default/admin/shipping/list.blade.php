@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">物流公司 - 物流公司列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>

                </ul>
            </div>
            <div class="flexilist" id="listDiv">
                <div class="common-head order-coomon-head">
                    <div class="fl">
                        <a href="/admin/shipping/add">
                            <div class="fbutton">
                                <div class="add" title="添加物流公司">
                                    <span><i class="icon icon-plus"></i>添加物流公司</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)">
                            <i class="icon icon-refresh"  style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/admin/shipping" name="searchForm" >
                            <div class="input">
                                <input type="text" name="shipping_name" value="{{$shipping_name}}" class="text nofocus w180" placeholder="公司名称" autocomplete="off">
                                <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
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
                                    <th width="10%"><div class="tDiv">ID</div></th>
                                    <th width="10%"><div class="tDiv">编码</div></th>
                                    <th width="10%"><div class="tDiv">名称</div></th>
                                    <th width="50%"><div class="tDiv">描述</div></th>
                                    <th width="10%"><div class="tDiv">状态</div></th>
                                    <th width="10%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping_list as $v)
                                    <tr class="">
                                        <td><div class="tDiv">{{$v['id']}}</div></td>
                                        <td><div class="tDiv">{{$v['shipping_code']}}</div></td>
                                        <td><div class="tDiv">{{$v['shipping_name']}}</div></td>
                                        <td><div class="tDiv">{{$v['shipping_desc']}}</div></td>
                                        <td>
                                            <div class="tDiv">
                                                @if($v['enabled']==0)
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>已禁用</div>
                                                @else
                                                    <div class='layui-btn layui-btn-sm layui-btn-radius'>已启用</div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="handle">
                                            <div class="tDiv a3">
                                                @if($v['enabled']==0)
                                                    <a href="javascript:void(0);" data-id="{{$v['id']}}" data-status="{{$v['enabled']}}" title="启用" class="btn_see onEnabled"><i class="layui-icon layui-icon-ok-circle"></i>启用</a>
                                                @else
                                                    <a href="javascript:void(0);" data-id="{{$v['id']}}" data-status="{{$v['enabled']}}" title="禁用" class="btn_see onEnabled"><i class="layui-icon layui-icon-close-fill"></i>禁1用</a>
                                                @endif
                                                <a href="/admin/shipping/edit?id={{$v['id']}}" title="编辑" class="btn_see"><i class="layui-icon layui-icon-edit"></i>编辑</a>
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
                    , curr: "{{$currentPage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/shipping?currentPage="+obj.curr;
                        }
                    }
                });
            });
        }
        $(function(){
            $(".onEnabled").click(function () {alert(1);
                var id = $(this).data("id");
                var status = $(this).data("status");
                $.post('/admin/shipping/setStatus', {
                    'id': id,
                    'status': status,
                }, function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {
                            icon: 6,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            window.location.href="/admin/shipping";
                        });

                    } else {
                        layer.alert(res.msg);
                    }
                }, "json");
            });
        });




    </script>
@stop
