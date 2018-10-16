@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"><a href="/admin/seckill/list" class="s-back">返回</a>秒杀活动 - 秒杀时段列表</div>
        <div class="content">

                <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>秒杀时段列表可对时间段进行新增/编辑/删除操作。</li>
                    <li>建议设置四至五个时间段（前台显示）。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href=""><div class="fbutton"><div class="add" title="添加秒杀时段"><span>添加秒杀时段</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="post" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="1" cellspacing="1">
                                <thead>
                                <tr>
                                    <th width="10%"><div class="tDiv">编号</div></th>
                                    <th width="15%"><div class="tDiv">开始时间</div></th>
                                    <th width="15%"><div class="tDiv">结束时间</div></th>
                                    <th width="15%"><div class="tDiv">标题</div></th>
                                    <th width="10%"  class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($seckill_time as $vo)
                                <tr>
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['begin_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['end_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['title']}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
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
                            window.location.href="/admin/seckill/time/list?currpage="+obj.curr;
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
                    window.location.href="/admin/seckill/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
