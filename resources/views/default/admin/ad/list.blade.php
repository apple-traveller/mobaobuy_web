@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">广告 - 广告图列表</div>
    <div class="content visible">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>展示网站页面所有的广告图片。</li>
                <li>点击广告名查看图片。</li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="/admin/ad/addForm"><div class="fbutton"><div class="add" title="添加广告图片"><span><i class="icon icon-plus"></i>添加广告图片</span></div></div></a>
                </div>
                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                </div>
                <div class="search">
                    <form action="/admin/ad/list" name="searchForm" >
                        <div class="input">
                            <select style="height:30px;float:left;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="position_id" id="position_id">
                                <option value="0">选择广告位</option>
                                @foreach($ad_positions as $vo)
                                    <option @if($vo['id']==$position_id) selected @endif  value="{{$vo['id']}}">{{$vo['position_name']}}</option>
                                @endforeach
                            </select>
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
                                    <th width="10%"><div class="tDiv">广告名称</div></th>
                                    <th width="10%"><div class="tDiv">广告位置</div></th>
                                    <th width="10%"><div class="tDiv">广告链接</div></th>
                                    <th width="15%"><div class="tDiv">开始时间</div></th>
                                    <th width="15%"><div class="tDiv">结束时间</div></th>
                                    <th width="5%"><div class="tDiv">点击次数</div></th>
                                    <th width="5%"><div class="tDiv">是否启用</div></th>
                                    <th width="5%"><div class="tDiv">排序</div></th>
                                    <th width="15%" class="handle">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $vo)
                            <tr class="">
                                <td><div style="cursor: pointer;color:green;" data-pic="{{getFileUrl($vo['ad_img'])}}" class="tDiv viwAdPicture">{{$vo['ad_name']}}</div></td>
                                <td><div class="tDiv">{{$vo['position_name']}}</div></td>
                                <td><div class="tDiv">{{$vo['ad_link']}}</div></td>
                                <td><div class="tDiv">{{$vo['start_time']}}</div></td>
                                <td><div class="tDiv">{{$vo['end_time']}}</div></td>
                                <td><div class="tDiv">{{$vo['click_count']}}</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch @if($vo['enabled']) active @endif" title="@if($vo['enabled']) 是 @else 否 @endif" onclick="listTable.switchBt(this, '{{url('/admin/ad/change/enabled')}}', '{{$vo['id']}}')">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td><div class="tDiv">{{$vo['sort_order']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="/admin/ad/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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
                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/ad/list?currpage="+obj.curr+"&position_id={{$position_id}}";
                        }
                    }
                });
            });
        }

        layui.use(['layer'], function() {
            var layer = layui.layer;
            $(".viwAdPicture").click(function(){
                var pic = $(this).attr('data-pic');
                index = layer.open({
                    type: 1,
                    title: '详情',
                    area: ['700px', '500px'],
                    content: '<img src="'+pic+'">'
                });
            });
        });



        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/ad/delete?id="+id;
                    layer.close(index);
                });
            });
        }

    </script>
@stop
