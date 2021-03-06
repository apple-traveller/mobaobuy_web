@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">招聘 - 简历列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>

                </div>
                <ul>
                    <li>该页面展示所有平台的投递简历。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        {{--<a href="/admin/resume/add"><div class="fbutton"><div class="add" title="添加新招聘信息"><span><i class="icon icon-plus"></i>添加新招聘信息</span></div></div></a>--}}
                    </div>
                </div>
                <div class="common-content">
                    <div class="list-div" id="listDiv">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <thead>
                            <tr>
                                <th width="10%"><div class="tDiv">序号</div></th>
                                <th width="10%"><div class="tDiv">投递职位</div></th>
                                <th class="handle" width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($resumes))
                            @foreach($resumes as $vo)
                            <tr class="">
                                <td><div class="tDiv">{{$vo['id']}}</div></td>
                                <td><div class="tDiv">{{$vo['recruit_job']}}</div></td>

                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a download="简历" href="{{asset('storage/'.$vo['resume_path'])}}" title="下载" class="btn_edit"><i class="icon icon-edit"></i>下载</a>
                                        {{--<input type="button" download="简历.docx" style="border:none;width:82px;height:40px;" onclick="window.open('{{asset($vo["resume_path"])}}')" value="点击下载">--}}
                                        <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr class=""> <td style="color:red;">未查询到数据</td></tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="list-page">
                                        <ul id="page"></ul>
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
                            window.location.href="/admin/resume/list?currpage="+obj.curr;
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
                    window.location.href="/admin/resume/delete?id="+id;
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
            var url = "/admin/recruit/sort";
            $.post(url, postData, function(res){
                if(res.code==1){
                    window.location.href=res.msg;
                }else{
                    alert('更新失败');
                }
            },"json");

        });
    </script>
@stop
