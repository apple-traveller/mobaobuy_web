@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">系统设置 - 地区列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>在新增一级地区点击管理进入下一级地区，可进行删除和编辑。</li>
                    <li>地区用于商城定位，请根据商城实际情况谨慎设置。</li>
                    <li>地区层级关系必须为中国→省/直辖市→市→县，地区暂只支持到四级地区其后不显示，暂不支持国外</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl mt2">

                        @if($parent_id==0)

                        @else
                        <a href="/admin/region/list?parent_id={{$last_parent_id}}" ><div class="fbutton"><div class="add_region" title="返回上一级"><span><span><i class="icon icon-reply"></i>返回上一级</span></div></div></a>
                        @endif


                    </div>
                    <div class="add_area fr">
                        <form method="post" action="/admin/region/save" name="theForm">
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <input type="hidden" name="region_type" value="{{$region_type}}">
                            <input type="hidden" name="parent_id" value="{{$parent_id}}">
                            <input type="text" name="region_name" class="text" placeholder="请输入地区名称" autocomplete="off">
                            <input type="submit" class="btn btn30 red_btn" value="新增地区">

                        </form>
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="3%"><div class="tDiv">&nbsp;</div></th>
                                <th width="20%"><div class="tDiv">地区名称</div></th>
                                <th width="25%"><div class="tDiv">所在层级</div></th>
                                <th width="25%"><div class="tDiv">所属地区</div></th>
                                <th width="25%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($regions as $region)

                            <tr class="">

                                <td><div class="tDiv">&nbsp;</div></td>
                                <td>
                                    <div class="tDiv changeInput">
                                        <input type="text" attr-id="{{$region['region_id']}}"  class="text w80 changeInput" value="{{$region['region_name']}}" >
                                    </div>
                                </td>
                                <td>
                                    <div class="tDiv">
                                        @if($region['region_type']==0)一级地区
                                        @elseif($region['region_type']==1)二级地区
                                        @elseif($region['region_type']==2)三级地区
                                        @else 四级地区
                                        @endif
                                    </div>
                                </td>
                                <td><div class="tDiv">{{$parentRegion}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a1">
                                        <a href="/admin/region/list?parent_id={{$region['region_id']}}" title="管理" class="btn_see"><i class="sc_icon sc_icon_see"></i>管理</a>
                                        <a href="javascript:void(0)" title="删除" onclick="remove({{$region['region_id']}},{{$parent_id}})" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
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
        //删除
        function remove(id,parent_id)
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
                    window.location.href="/admin/region/delete?region_id="+id+"&parent_id="+parent_id;
                    layer.close(index);
                });
            });

        }
        $(".changeInput input").blur(function(){
            //获取主键id
            var region_id = $(this).attr('attr-id');
            // 获取地区名称
            var region_name = $(this).val();

            var postData = {
                'region_id' : region_id,
                'region_name':region_name,
                '_token':$("#_token").val(),
                'parent_id':"{{$parent_id}}"
            };
            var url = "{{url('/admin/region/modify')}}";
            // 抛送http
            $.post(url, postData, function(result){
                // 逻辑
                if(result.code == 1) {
                    window.location.href=result.data;
                }else {
                    alert(result.msg);
                }
            },"json");
        });

    </script>
@stop
