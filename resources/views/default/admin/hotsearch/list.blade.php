@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">
            热门搜索
        </div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>展示了平台所有的搜索记录。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
{{--                        <a href="/admin/goodscategory/list?parent_id={{$last_parent_id}}"><div class="fbutton"><div class="add" title="返回上一级"><span><i class="icon icon-reply"></i>返回上一级</span></div></div></a>--}}
                        {{--<a href="/admin/goodscategory/addForm"><div class="fbutton"><div class="add" title="添加分类"><span><i class="icon icon-plus"></i>添加分类</span></div></div></a>--}}
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th width="20%"><div class="tDiv">更新时间</div></th>
                                    <th width="30%"><div class="tDiv">搜索关键字</div></th>
                                    <th width="15%"><div class="tDiv">搜索次数</div></th>
                                    <th width="15%"><div class="tDiv">是否显示</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($hot as $vo)
                            <tr class="hot_list">
                                <td><div class="tDiv">{{$vo['update_time']}}</div></td>
                                <td><div class="tDiv">{{$vo['search_key']}}</div></td>
                                <td><div class="tDiv">{{$vo['search_num']}}</div></td>
                                <td><div class="tDiv show_text">{{status($vo['is_show'])}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">

                                        @if($vo['is_show'] == 1)
                                            <a href="javascript:" onclick="setStatus('{{$vo['id']}}','{{$vo['is_show']}}',this)" id="btn_show" class="btn_status">
                                                <i class="layui-icon layui-icon-close-fill"></i>禁用
                                            </a>
                                        @else
                                            <a href="javascript:" onclick="setStatus('{{$vo['id']}}','{{$vo['is_show']}}',this)" id="btn_no_show" class="btn_status">
                                                <i class="layui-icon layui-icon-ok-circle"></i>启用
                                            </a>
                                        @endif

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
                    window.location.href="/admin/hotsearch/delete?id="+id;
                    layer.close(index);
                });
            });
        }

        function setStatus(id,is_show,obj){
            var postData = {
                'id':id,
                'is_show':is_show,
            };
            var _word = is_show == 1 ? '禁用' : '启用';
            var url = "/admin/hotsearch/setShow";

            layer.confirm('确定'+_word+'该关键字？',
                function(index){
                    $.post(url,postData,function(res){
                        if(res.code==1){
                            $(obj).attr('onclick','setStatus('+res.data.id+','+res.data.is_show+',this)');
                            $(obj).empty();
                            $(obj).parents('.hot_list').find('.show_text').empty();
                            if(res.data.is_show == 1){
                                $(obj).append('<i class="layui-icon layui-icon-close-fill"></i>禁用');
                                $(obj).parents('.hot_list').find('.show_text').append("<div class='layui-btn layui-btn-sm layui-btn-radius'>是</div>");
                            }else{
                                $(obj).append('<i class="layui-icon layui-icon-ok-circle"></i>启用');
                                $(obj).parents('.hot_list').find('.show_text').append("<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>否</div>");
                            }
                        }else{
                            $.msg.alert('更新失败');
                        }
                    },"json");
                    layer.close(index);
                }
            )
        }



        $(".changeInput input").blur(function(){
            var sort_order = $(this).val();
            var id = $(this).attr('data-id');
            var postData = {
                'id':id,
                'sort_order':sort_order,
            }
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
