@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">企业黑名单 - 黑名单列表</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
            <ul>
                <li>记录信用差的企业。</li>
            </ul>
        </div>
        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出企业黑名单列表"><span><i class="icon icon-download-alt"></i>导出企业黑名单列表</span></div></div></a>
                    <a href="/admin/blacklist/addForm"><div class="fbutton"><div class="add" title="添加企业黑名单"><span><i class="icon icon-plus"></i>添加企业黑名单</span></div></div></a>
                </div>

                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$count}}条记录</div>
                </div>

                <div class="search">
                    <form action="/admin/blacklist/list" name="searchForm" >
                        <div class="input">
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <input type="text" value="{{$firm_name}}" name="firm_name" class="text nofocus firm_name" placeholder="会员名称" autocomplete="off">
                            <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="/admin/blacklist/deleteall" name="listForm" >
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list"><label for="all_list" class="checkbox_stars"></label></div></th>
                                <th width="5%"><div class="tDiv">编号</div></th>
                                <th width="10%"><div class="tDiv">企业名称</div></th>
                                <th width="10%"><div class="tDiv">税号</div></th>
                                <th width="8%"><div class="tDiv">添加时间</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @foreach($blacklist as $list)
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="{{$list['id']}}" class="checkbox" id="checkbox_{{$list['id']}}"><label for="checkbox_{{$list['id']}}" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">{{$list['id']}}</div></td>
                                <td><div class="tDiv">{{$list['firm_name']}}</div></td>
                                <td><div class="tDiv">{{$list['taxpayer_id']}}</div></td>
                                <td><div class="tDiv">{{$list['add_time']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="javascript:;" onclick="remove({{$list['id']}})" title="删除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="tDiv">
                                        <div class="tfoot_btninfo">
                                            <input type="hidden" name="act" value="batch_remove">
                                            <input type="submit" value="删除" name="remove" ectype="btnSubmit" class="btn btn_disabled" disabled="disabled">
                                        </div>
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
                    , count: "{{$count}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            var firm_name = $(".firm_name").val();
                            window.location.href="/admin/blacklist/list?currpage="+obj.curr+"&firm_name="+firm_name;
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
                    window.location.href="/admin/blacklist/delete?id="+id;
                    layer.close(index);
                });
            });

        }

        //导出会员
        function download_userlist()
        {
            location.href = "/admin/blacklist/export";
        }

    </script>
@stop
