@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">
            商品 - 平台商品分类        </div>
        <div class="content">

            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/goodscategory/list?parent_id={{$last_parent_id}}"><div class="fbutton"><div class="add" title="返回上一级"><span><i class="icon icon-reply"></i>返回上一级</span></div></div></a>
                        <a href="/admin/goodscategory/addForm"><div class="fbutton"><div class="add" title="添加分类"><span><i class="icon icon-plus"></i>添加分类</span></div></div></a>
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="8%"><div class="tDiv">级别(@if(!empty($level)) {{$level}}级 @else {{null}} @endif)</div></th>
                                <th width="20%"><div class="tDiv">分类名称</div></th>
                                <th width="10%"><div class="tDiv">是否在导航栏显示</div></th>
                                <th width="10%"><div class="tDiv">是否在顶部显示</div></th>
                                <th width="10%"><div class="tDiv">别名</div></th>
                                <th width="10%"><div class="tDiv">是否显示</div></th>
                                <th width="10%"><div class="tDiv">排序</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($goodsCategorys as $vo)
                            <tr class="">
                                <td>
                                    <div class="tDiv first_setup">
                                        <div class="setup_span">
                                            <em><i class="icon icon-cog"></i>设置<i class="arrow"></i></em>
                                            <ul>
                                                <li><a href="/admin/goodscategory/addForm?parent_id={{$vo['id']}}">新增下一级</a></li>
                                                <li><a href="/admin/goodscategory/list?parent_id={{$vo['id']}}">查看下一级</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="tDiv"><a href="#" class="ftx-01">{{$vo['cat_name']}}</a></div></td>

                                <td>
                                    <div class="tDiv">
                                        {{status($vo['is_nav_show'])}}
                                    </div>
                                </td>
                                <td>
                                    <div class="tDiv">
                                        {{status($vo['is_top_show'])}}
                                    </div></td>
                                <td>
                                    <div class="tDiv">
                                        {{$vo['cat_alias_name']}}
                                    </div>
                                </td>
                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <td>
                                    <div class="tDiv">
                                        {{status($vo['is_show'])}}
                                    </div>
                                </td>
                                <td><div class="tDiv changeInput"><input type="text" name="sort_order" class="text w40 " data-id="{{$vo['id']}}" value="{{$vo['sort_order']}}" ></div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="/admin/goodscategory/editForm?id={{$vo['id']}}" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                        <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
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
                    window.location.href="/admin/goodscategory/delete?id="+id;
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
                console.log(postData);
                var url = "/admin/goodscategory/sort";
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
