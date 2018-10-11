@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">单位 - 单位列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>该页面展示了商城所有的产品单位信息，可对单位进行编辑修改操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/unit/addForm"><div class="fbutton"><div class="add" title="添加单位"><span><i class="icon icon-plus"></i>添加单位</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="20%"><div class="tDiv">编号</div></th>
                                    <th width="20%"><div class="tDiv">单位名称</div></th>
                                    <th width="20%"><div class="tDiv">添加时间</div></th>
                                    <th width="20%"><div class="tDiv">排序</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($units as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['id']}}</div></td>
                                    <td><div class="tDiv">{{$vo['unit_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                    <td><div class="tDiv changeInput">
                                            <input name="sort_order" data-id="{{$vo['id']}}" class="text w40" value="{{$vo['sort_order']}}"  type="text">
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="/admin/unit/editForm?id={{$vo['id']}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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

        function remove(id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/unit/delete?id="+id;
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
            var url = "/admin/unit/sort";
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
