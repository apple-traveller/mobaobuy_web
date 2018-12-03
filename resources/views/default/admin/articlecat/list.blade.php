@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title"> 文章 - 文章分类</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>文章分类。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/articlecat/list?parent_id={{$last_parent_id}}" @if($parent_id==0) style="display:none;" @endif><div class="fbutton"><div class="add" title="返回上一级"><span><i class="icon icon-reply"></i>返回上一级</span></div></div></a>
                        <a href="/admin/articlecat/addForm"><div class="fbutton"><div class="add" title="添加分类"><span><i class="icon icon-plus"></i>添加分类</span></div></div></a>
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="10%"><div class="tDiv"> </div></th>
                                <th width="10%"><div class="tDiv">标号</div></th>
                                <th width="20%"><div class="tDiv">分类名称</div></th>
                                <th width="10%"><div class="tDiv">排序</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cats as $vo)
                            <tr class="">
                                <td>
                                    <div class="tDiv first_setup">
                                        <div class="setup_span">
                                            <em><i class="icon icon-cog"></i>设置<i class="arrow"></i></em>
                                            <ul>
                                                <li><a href="/admin/articlecat/addForm?parent_id={{$vo['id']}}">新增下一级</a></li>
                                                <li><a href="/admin/articlecat/list?parent_id={{$vo['id']}}">查看下一级</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="tDiv"><a href="#" class="ftx-01">{{$vo['id']}}</a></div></td>


                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <td>
                                    <div class="tDiv">
                                        {{$vo['cat_name']}}
                                    </div>
                                </td>
                                <td><div class="tDiv changeInput"><input style="margin-left: 50px;" type="text" name="sort_order" class="text w40 " data-id="{{$vo['id']}}" value="{{$vo['sort_order']}}" ></div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        @if(!in_array($vo['id'], [ 1 , 2]) )
                                            <a href="/admin/articlecat/editForm?id={{$vo['id']}}" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var tag_token = $("#_token").val();
        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/articlecat/delete?id="+id;
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
                }
                console.log(postData);
                var url = "/admin/articlecat/sort";
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
