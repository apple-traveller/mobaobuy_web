@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">会员 - 会员列表</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>点击积分按钮可以查看详细的积分流水。</li>
            </ul>
        </div>
        <div class="flexilist">

            <div class="common-head">
                <div class="order_state_tab">
                    <a href="/admin/user/list?is_firm=2" @if($is_firm==2) class="current" @endif>全部@if($is_firm==2) <em>({{$userCount}})</em> @endif </a>
                    <a href="/admin/user/list?is_firm=0" @if($is_firm==0&&$is_firm!="") class="current" @endif>个人@if($is_firm==0&&$is_firm!="") <em>({{$userCount}})</em> @endif</a>
                    <a href="/admin/user/list?is_firm=1" @if($is_firm==1) class="current" @endif>企业@if($is_firm==1) <em>({{$userCount}})</em> @endif</a>
                    <a href="/admin/user/list?is_firm=-1" @if($is_firm==-1) class="current" @endif>待审核@if($is_firm==-1) <em>({{$userCount}})</em> @endif </a>
                   {{-- <a href="/admin/orderinfo/list?order_status=0">企业 <em>(20)</em></a>
                    <a href="/admin/orderinfo/list?order_status=0">个人 <em>(20)</em></a>--}}
                </div>
                <div style="margin-left:10px;margin-top:4px;" class="fl">
                    <a href="/admin/user/addForm"><div class="fbutton"><div class="add" title="添加新用户"><span><i class="icon icon-plus"></i>添加新用户</span></div></div></a>
                    {{--<a href="/admin/user/addUserRealForm"><div class="fbutton"><div class="add" title="添加新用户"><span><i class="icon icon-plus"></i>添加实名认证</span></div></div></a>--}}
                    <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出会员列表"><span><i class="icon icon-download-alt"></i>导出会员列表</span></div></div></a>
                </div>

                <div  class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$userCount}}条记录</div>
                </div>

                <div class="search">
                    <form action="/admin/user/list" name="searchForm" >
                        <div class="input">
                            <input type="text" value="{{$user_name}}" name="user_name" class="text nofocus user_name" placeholder="会员名称" autocomplete="off">
                            <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv" data-id="">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="5%"><div class="tDiv">编号</div></th>
                                <th width="8%"><div class="tDiv">用户名</div></th>
                                <th width="8%"><div class="tDiv">昵称</div></th>
                                <th width="6%"><div class="tDiv">是否实名</div></th>
                                <th width="10%"><div class="tDiv">是否企业用户</div></th>
                                <th width="10%"><div class="tDiv">注册时间</div></th>
                                <th width="8%"><div class="tDiv">访问次数</div></th>
                                <th width="6%"><div class="tDiv">是否冻结</div></th>
                                <th width="28%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @if(!empty($users))
                            @foreach($users as $user)
                            <tr class="">

                                <td><div class="tDiv">{{$user['id']}}</div></td>
                                <td><div class="tDiv">{{$user['user_name']}}</div></td>
                                <td><div class="tDiv">{{$user['nick_name']}}</div></td>
                                <td>
                                    <div class="tDiv">
                                        @if($user['review_status']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>已实名</div>
                                        @elseif($user['review_status']==0 && $user['is_validated'] == 0)<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-normal'>待审核</div>
                                        @elseif($user['review_status']==2)<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-danger'>未通过</div>
                                        @else<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-primary'>未实名</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="tDiv">
                                        @if($user['is_firm']==1)<div class='layui-btn layui-btn-sm layui-btn-radius'>企业</div>
                                        @else<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-primary'>个人</div>
                                        @endif
                                    </div>
                                </td>
                               {{-- <td>
                                    <div class="tDiv">
                                        <a href="/admin/user/points?id={{$user['id']}}&pcurrpage={{$currpage}}&is_firm={{$is_firm}}" class="layui-btn layui-btn-normal">{{$user['points']}}</a>
                                    </div>
                                </td>--}}
                                <td><div class="tDiv">{{$user['reg_time']}}</div></td>
                                <td><div class="tDiv">{{$user['visit_count']}}</div></td>

                                <td>
                                    <div class="tDiv">
                                        <div class="switch @if($user['is_freeze']) active @endif" title="@if($user['is_freeze']) 是 @else 否 @endif" onclick="listTable.switchBt(this, '{{url('admin/user/change/active')}}', '{{$user['id']}}')">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>

                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="{{url('/admin/user/detail')}}?id={{$user['id']}}&currpage={{$currpage}}&is_firm={{$is_firm}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="{{url('/admin/user/log')}}?id={{$user['id']}}&pcurrpage={{$currpage}}&is_firm={{$is_firm}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="{{url('/admin/user/userRealForm')}}?id={{$user['id']}}&currpage={{$currpage}}&is_firm={{$is_firm}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>实名审核</a>
                                        <a href="{{url('/admin/user/addUserRealForm')}}?id={{$user['id']}}&currpage={{$currpage}}&is_firm={{$is_firm}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>添加认证</a>
                                        <a @if($user['is_firm']==1 && $user['review_status']==1)  @else style="display:none;" @endif href="{{url('/admin/user/firmStock')}}?firm_id={{$user['id']}}&pcurrpage={{$currpage}}&is_firm={{$is_firm}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>企业库存</a>
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
                    elem: 'page' //注意，这里是 ID，不用加 # 号
                    , count: "{{$userCount}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/user/list?currpage="+obj.curr+"&user_name={{$user_name}}"+"&is_firm={{$is_firm}}";
                        }
                    }
                });
            });
        }

        //导出会员
        function download_userlist()
        {
            location.href = "/admin/user/export";
        }

    </script>
@stop
