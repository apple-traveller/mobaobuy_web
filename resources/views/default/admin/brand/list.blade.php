@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">品牌 - 品牌列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>展示了商城自营品牌的相关信息。</li>
                    <li>可以通过品牌关键字搜索相关品牌信息。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/brand/addForm"><div class="fbutton"><div class="add" title="添加新品牌"><span><i class="icon icon-plus"></i>添加新品牌</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/brand/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="brand_name" value="{{$brand_name}}" class="text nofocus brand_name" placeholder="文章标题" autocomplete="off">
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
                                    <th width="21%"><div class="tDiv"><a href="#">品牌名称</a></div></th>
                                    <th width="8%"><div class="tDiv"><a href="#">品牌首字母</a></div></th>
                                    <th width="10%"><div class="tDiv"><a href="#">品牌logo</a></div></th>
                                    <th width="8%"><div class="tDiv"><a href="#">品牌描述</a></div></th>
                                    <th width="8%"><div class="tDiv"><a href="#">排序</a></div></th>
                                    <th width="8%"><div class="tDiv"><a href="#">是否删除</a></div></th>
                                    <th width="15%"><div class="tDiv"><a href="#">是否推荐</a></div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($links as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['brand_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['brand_first_char']}}</div></td>
                                    <td>
                                        <div class="tDiv">
                                            <span class="show">
                                            <i class="icon icon-picture" data-tooltipimg="{{$vo['brand_logo']}}" ectype="tooltip" title="tooltip"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td><div class="tDiv">{{$vo['brand_desc']}}</div></td>
                                    <td>
                                        <div class="tDiv changeInput">
                                            <input type="text" name="sort_order" data-id="{{$vo['id']}}" class="text w40" value="{{$vo['sort_order']}}" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tDiv">
                                            <div class="tDiv">
                                                <label class="el-switch el-switch-lg">
                                                    <input type="checkbox" @if($vo['is_delete']==1) checked @endif  name="switch" value="{{$vo['is_delete']}}"  data-id="{{$vo['id']}}"   hidden>
                                                    <span class="j_click1 el-switch-style"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="tDiv">
                                            <label class="el-switch el-switch-lg">
                                                <input type="checkbox" @if($vo['is_recommend']==1) checked @endif  name="switch" value="{{$vo['is_recommend']}}"  data-id="{{$vo['id']}}"   hidden>
                                                <span class="j_click2 el-switch-style"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/brand/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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
                            var brand_name = $(".brand_name").val();
                            window.location.href="/admin/brand/list?currpage="+obj.curr+"&brand_name="+brand_name;
                        }
                    }
                });
            });
        }
        var tag_token = $("#_token").val();
        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/brand/delete?id="+id;
                    layer.close(index);
                });
            });
        }

        $('.j_click1').click(function(){
            var is_delete ;
            var id = $(this).siblings('input').attr('data-id');
            var input = $(this).siblings('input');
            if (input.val() === '1') {
                is_delete = 0;
            } else {
                is_delete = 1;
            }
            layui.use(['layer'], function() {
                layer = layui.layer;
                $.post("{{url('/admin/brand/status')}}",{"id":id,"is_delete":is_delete,"_token":$("#_token").val()},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {icon: 1});
                        console.log();
                        input.val(res.data);
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });
        });

        $('.j_click2').click(function(){
            var is_recommend ;
            var id = $(this).siblings('input').attr('data-id');
            var input = $(this).siblings('input');
            if (input.val() === '1') {
                is_recommend = 0;
            } else {
                is_recommend = 1;
            }
            layui.use(['layer'], function() {
                layer = layui.layer;
                $.post("{{url('/admin/brand/status')}}",{"id":id,"is_recommend":is_recommend,"_token":$("#_token").val()},function(res){
                    if(res.code==200){
                        layer.msg(res.msg, {icon: 1});
                        input.val(res.data);
                    }else{
                        layer.msg(res.msg, {icon: 5});
                    }
                },"json");
            });
        });


        $(".changeInput input").blur(function(){
                var sort_order = $(this).val();
                var id = $(this).attr('data-id');
                var postData = {
                    'id':id,
                    'sort_order':sort_order,
                    '_token':tag_token,
                }
                console.log(postData);
                var url = "/admin/brand/sort";
                $.post(url,postData,function(res){
                    if(res.code==200){
                        window.location.href=res.data;
                    }else{
                        alert('更新失败');
                    }
                },"json");
        });

    </script>
@stop
