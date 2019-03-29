@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">文章 - 文章列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示所有分类下的文章。</li>
                    <li>可通过搜索文章标题进行搜索。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/article/addForm"><div class="fbutton"><div class="add" title="添加新文章"><span><i class="icon icon-plus"></i>添加新文章</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$count}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/article/list" name="searchForm" >
                            <div style="width: 179px;float: left;">
                                    <select style="height:30px;border:1px solid #dbdbdb;line-height:30px;" name="cat_id" id="cat_id">
                                        <option value="0">顶级分类</option>
                                        @foreach($cateTrees as $vo)
                                            <option @if($vo['id']==$cat_id) selected @endif  value="{{$vo['id']}}">|<?php echo str_repeat('-->',$vo['level']).$vo['cat_name'];?></option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="input">
                                <input type="text" name="title" value="{{$title}}" class="text nofocus" placeholder="文章标题" autocomplete="off">
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
                                        <th width="16%"><div class="tDiv"><a href="#">文章标题</a></div></th>
                                        <th width="13%"><div class="tDiv"><a href="#">文章英文标题</a></div></th>
                                        <th width="10%"><div class="tDiv"><a href="#">文章分类</a></div></th>
                                        <th width="8%"><div class="tDiv"><a href="#">点击量</a></div></th>
                                        <th width="8%"><div class="tDiv"><a href="#">排序</a></div></th>
                                        <th width="8%"><div class="tDiv"><a href="#">是否显示</a></div></th>
                                        <th width="12%"><div class="tDiv"><a href="#">添加日期</a></div></th>
                                        <th width="20%" class="handle">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($articles))
                                @foreach($articles as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['id']}}</div></td>
                                        <td><div class="tDiv">{{$vo['title']}}</div></td>
                                        <td><div class="tDiv">{{$vo['title_en']}}</div></td>
                                        <td><div class="tDiv">{{$vo['cat_name']}}</div></td>
                                        <td><div class="tDiv">{{$vo['click']}}</div></td>
                                        <td><div class="tDiv changeInput"><input type="text" name="sort_order" data-id="{{$vo['id']}}" class="text w40" value="{{$vo['sort_order']}}" ></div></td>
                                        <td>
                                            <div class="tDiv">
                                                <div class="tDiv">
                                                    <div class="switch @if($vo['is_show']) active @endif" title="@if($vo['is_show']) 是 @else 否 @endif" onclick="listTable.switchBt(this, '{{url('/admin/article/change/isShow')}}','{{$vo['id']}}')">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <input type="hidden" value="0" name="">
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/article/detail?id={{$vo['id']}}&currpage={{$currpage}}"  title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                <a href="/admin/article/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                                <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a><!---->
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr class=""> <td style="color:red;">未查询到数据</td></tr>
                                @endif
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
                    , count: "{{$count}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/article/list?currpage="+obj.curr;
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
                    window.location.href="/admin/article/delete?id="+id;
                    layer.close(index);
                });
            });

        }




        $(".changeInput input").blur(function(){
                var sort_order = $(this).val();
                var id = $(this).attr('data-id');
                var postData = {
                    'id':id,
                    'sort_order':sort_order,
                    '_token':tag_token,
                }
                var url = "/admin/article/sort";
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
