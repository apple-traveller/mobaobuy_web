@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">店铺 - 店铺职员列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                    <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/shopuser/addForm"><div class="fbutton"><div class="add" title="添加店铺职员"><span><i class="icon icon-plus"></i>添加店铺职员</span></div></div></a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                    <div class="search">
                        <form action="/admin/shopuser/list" name="searchForm" >
                            <div class="input">
                                <select style="height:30px;float:left;border:1px solid #dbdbdb;line-height:30px;width:150px;" name="shop_id" id="cat_id">
                                    <option value="0">请选择店铺</option>
                                    @foreach($shops as $vo)
                                        <option @if($vo['id']==$shop_id) selected @endif  value="{{$vo['id']}}">{{$vo['shop_name']}}</option>
                                    @endforeach
                                </select>
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
                                    <th width="10%"><div class="tDiv">店铺名称</div></th>
                                    <th width="10%"><div class="tDiv">登录用户名</div></th>
                                    <th width="10%"><div class="tDiv">注册时间</div></th>
                                    <th width="10%"><div class="tDiv">上次登录时间</div></th>
                                    <th width="5%"><div class="tDiv">访问次数</div></th>
                                    <th width="10%"><div class="tDiv">上次登录IP</div></th>
                                    <th width="5%"><div class="tDiv">是否是管理员</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopusers as $vo)
                                <tr class="">
                                    <td>
                                        <div class="tDiv">
                                            @foreach($shops as $v)
                                            @if($v['id']==$vo['shop_id']) {{$v['shop_name']}} @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><div class="tDiv">{{$vo['user_name']}}</div></td>
                                    <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['last_time']}}</div></td>
                                    <td><div class="tDiv">{{$vo['visit_count']}}</div></td>
                                    <td><div class="tDiv">{{$vo['last_ip']}}</div></td>
                                    <td><div class="tDiv">{{status($vo['is_super'])}}</div></td>
                                    <td class="handle">
                                        <div class="tDiv a3">
                                            <a href="javascript:void(0);" onclick="remove({{$vo['id']}})" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                            <a href="/admin/shopuser/editForm?id={{$vo['id']}}&currpage={{$currpage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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
                            window.location.href="/admin/shopgoods/list?currpage="+obj.curr+"&shop_id="+"{{$shop_id}}";
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
                    window.location.href="/admin/shopgoods/delete?id="+id;
                    layer.close(index);
                });
            });
        }


    </script>
@stop
