@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">系统设置 - 友情链接列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>

                </div>
                <ul>
                    <li>该页面展示所有友情链接信息列表。</li>
                    <li>可点击链接进入相应网页，也可进行编辑或删除友情链接。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/link/addForm"><div class="fbutton"><div class="add" title="添加新链接"><span><i class="icon icon-plus"></i>添加新链接</span></div></div></a>
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div" id="listDiv">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <thead>
                            <tr>
                                <th width="20%"><div class="tDiv"><a href="javascript:listTable.sort('link_name');">链接名称</a></div></th>
                                <th width="35%"><div class="tDiv"><a href="javascript:listTable.sort('link_url');">链接地址</a></div></th>
                                <th width="20%"><div class="tDiv"><a href="javascript:listTable.sort('link_logo');">链接LOGO</a></div></th>
                                <th width="10%"><div class="tDiv"><a href="javascript:listTable.sort('show_order');">显示顺序</a></div></th>
                                <th class="handle" width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($links as $vo)
                            <tr class="">
                                <td><div class="tDiv">{{$vo['link_name']}}</div></td>
                                <td>
                                    <div class="tDiv">
                                        <a href="{{$vo['link_url']}}" target="_blank">{{$vo['link_url']}}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="tDiv">
                                        <img src="{{$vo['link_logo']}}" style="width:50px;height:50px;">
                                    </div>
                                </td>
                                <td><div class="tDiv changeInput"><input name="sort_order" data-id="{{$vo['id']}}" class="text w40" value="{{$vo['sort_order']}}" onkeyup="" type="text"></div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="/link/editForm?id={{$vo['id']}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                        <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="list-page">
                                        <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->

                                        {{$links->links()}}

                                        <style>
                                            .pagination li{
                                                float: left;
                                                width: 30px;
                                                line-height: 30px;}
                                        </style>


                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/link/delete?id="+id;
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
                '_token':'{{csrf_token()}}',
            }
            //console.log(postData);
            var url = "/link/sort";
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
