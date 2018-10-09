@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">管理员 - 管理员列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>超级管理员不可删除。</li>
                    <li>可对管理员做增删改查和分配权限的操作。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/adminuser/addForm"><div class="fbutton"><div class="add" title="添加新管理员"><span><i class="icon icon-plus"></i>添加新管理员</span></div></div></a>
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
                                    <th width="10%"><div class="tDiv">账号</div></th>
                                    <th width="10%"><div class="tDiv">真实姓名</div></th>
                                    <th width="10%"><div class="tDiv">手机号</div></th>
                                    <th width="10%"><div class="tDiv">邮件</div></th>
                                    <th width="5%"><div class="tDiv">访问次数</div></th>
                                    <th width="5%"><div class="tDiv">上次登录IP</div></th>
                                    <th width="5%"><div class="tDiv">是否冻结</div></th>
                                    <th width="5%"><div class="tDiv">是否为超级管理员</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $vo)
                                <tr class="">
                                    <td><div class="tDiv">{{$vo['user_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['real_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['mobile']}}</div></td>
                                    <td><div class="tDiv">{{$vo['email']}}</div></td>
                                    <td><div class="tDiv">{{$vo['visit_count']}}</div></td>
                                    <td><div class="tDiv">{{$vo['last_ip']}}</div></td>

                                    <td>
                                        <div class="tDiv">
                                            <div class="switch @if($vo['is_freeze']) active @endif" title="@if($vo['is_freeze']) 是 @else 否 @endif" onclick="listTable.switchBt(this, '{{url('/admin/adminuser/change/isFreeze')}}','{{$vo['id']}}')">
                                                <div class="circle"></div>
                                            </div>
                                            <input type="hidden" value="0" name="">
                                        </div>
                                    </td>

                                    <td><div class="tDiv">{{status($vo['is_super'])}}</div></td>

                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a @if($vo['is_super']==1) style="display:none;" @endif href="/admin/adminuser/detail?id={{$vo['id']}}&currpage={{$currpage}}" title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                            <a @if($vo['is_super']==1) style="display:none;" @endif href="/admin/adminuser/delete?id={{$vo['id']}}" title="删除" class="btn_see"><i class="icon icon-trash"></i>删除</a>
                                            <a @if($vo['is_super']==1) style="display:none;" @endif href="/admin/adminuser/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
                                            <a href="/admin/adminuser/log?id={{$vo['id']}}&pcurrpage={{$currpage}}" title="日志" class="btn_edit"><i class="sc_icon sc_icon_see"></i>日志</a>
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
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/adminuser/list?currpage="+obj.curr;
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
                    window.location.href="/admin/adminuser/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
