@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
<div class="warpper">
    <div class="title">会员 - 会员列表</div>
    <div class="content">
        <div class="tabs_info">
            <ul>
                <li class="curr">
                    <a href="/user/list">会员列表</a>
                </li>
                <li>
                    <a href="user_rank.php?act=list">会员等级</a>
                </li>
                <li>
                    <a href="user_real.php?act=list">实名认证</a>
                </li>
                <li>
                    <a href="reg_fields.php?act=list">注册项设置</a>
                </li>
            </ul>
        </div>        	<div class="explanation" id="explanation">
            <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
            <ul>
                <li>会员列表展示商城所有的会员信息。</li>
                <li>可通过会员名称关键字进行搜索，如需详细搜索请在侧边栏进行高级搜索。</li>
                <li>会员等级必须在有效积分范围内，否则无法显示会员等级；<em>比如会员积分0，却没有0积分的等级就会显示无等级</em></li>
            </ul>
        </div>
        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出会员列表"><span><i class="icon icon-download-alt"></i>导出会员列表</span></div></div></a>
                    <a href="/user/addForm"><div class="fbutton"><div class="add" title="添加会员"><span><i class="icon icon-plus"></i>添加会员</span></div></div></a>
                </div>

                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$users['total']}}条记录</div>
                </div>

                <div class="search">
                    <form action="/user/list" name="searchForm" >
                        <div class="input">
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <input type="text" value="{{$user_name}}" name="user_name" class="text nofocus" placeholder="会员名称" autocomplete="off">
                            <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list"><label for="all_list" class="checkbox_stars"></label></div></th>
                                <th width="5%"><div class="tDiv"><a href="javascript:listTable.sort('user_id'); ">编号</a><img src="{{asset(themePath('/').'images/sort_desc.gif')}}"></div></th>
                                <th width="10%"><div class="tDiv">会员名称</div></th>
                                <th width="10%"><div class="tDiv">昵称</div></th>
                                <th width="8%"><div class="tDiv">真实姓名</div></th>
                                <th width="8%"><div class="tDiv">手机号</div></th>
                                <th width="8%"><div class="tDiv">注册日期</div></th>
                                <th width="8%"><div class="tDiv">访问次数</div></th>

                                <th width="6%"><div class="tDiv">状态</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @foreach($users as $user)
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="{{$user->id}}" class="checkbox" id="checkbox_{{$user->id}}"><label for="checkbox_{{$user->id}}" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">{{$user->id}}</div></td>
                                <td><div class="tDiv">{{$user->user_name}}</div></td>
                                <td><div class="tDiv">{{$user->nick_name}}</div></td>
                                <td><div class="tDiv">{{$user->real_name}}</div></td>
                                <td><div class="tDiv">{{$user->user_name}}</div></td>
                                <td><div class="tDiv">{{$user->reg_time}}</div></td>
                                <td><div class="tDiv">{{$user->visit_count}}</div></td>

                                <td>

                                    <label class="el-switch el-switch-lg">
                                        <input type="checkbox" @if($user->is_freeze==0)checked @endif  name="switch" value="{{$user->is_freeze}}"  data-id="{{$user->id}}"   hidden>
                                        <span class="j_click el-switch-style"></span>
                                    </label>


                                </td>

                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="{{url('/user/detail')}}?id={{$user->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="{{url('/user/log')}}?id={{$user->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="tDiv">
                                        <div class="tfoot_btninfo">
                                            <input type="hidden" name="act" value="batch_remove">
                                            <input type="submit" value="删除" name="remove" ectype="btnSubmit" class="btn btn_disabled" disabled="disabled">
                                        </div>
                                        <div class="list-page">
                                            <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->


                                            {{$users->links()}}

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


        $('.j_click').click(function(){
                var is_freeze ;
                var user_id = $(this).siblings('input').attr('data-id');
                var input = $(this).siblings('input');
                if (input.val() === '1') {
                    is_freeze = 0;
                } else {
                    is_freeze = 1;
                }

                layui.use(['layer'], function() {
                    layer = layui.layer;
                    $.post("{{url('/user/modify')}}",{"id":user_id,"is_freeze":is_freeze,"_token":$("#_token").val()},function(res){
                        if(res.code==1){
                            layer.msg(res.msg, {icon: 1});
                            input.val(res.data);
                        }else{
                            layer.msg(res.msg, {icon: 5});
                        }
                    },"json");

                });
        });




        //导出会员
        function download_userlist()
        {
            var args = '';
            for (var i in listTable.filter)
            {
                if(typeof(listTable.filter[i]) != "function" && typeof(listTable.filter[i]) != "undefined"){
                    args += "&" + i + "=" + encodeURIComponent(listTable.filter[i]);
                }
            }
            location.href = "/user/export";
        }

    </script>
@stop
