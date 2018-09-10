@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/checkbox.min.css')}}" />
    <div class="warpper">
        <div class="title">企业 - 企业列表</div>
        <div class="content">
            <div class="tabs_info">
                <ul>
                    <li class="curr">
                        <a href="/firm/list">企业列表</a>
                    </li>

                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出会员列表"><span><i class="icon icon-download-alt"></i>导出企业列表</span></div></div></a>
                    </div>

                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                        <div class="refresh_span">刷新 - 共{{$firmCount}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/firm/list" name="searchForm" >
                            <div class="input">
                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <input type="text" value="{{$firm_name}}" name="firm_name" class="text nofocus" placeholder="企业名称" autocomplete="off">
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

                                    <th width="5%"><div class="tDiv">编号</div></th>
                                    <th width="10%"><div class="tDiv">企业名称</div></th>
                                    <th width="10%"><div class="tDiv">账号</div></th>
                                    <th width="10%"><div class="tDiv">联系人姓名</div></th>

                                    <th width="10%"><div class="tDiv">代理凭证</div></th>
                                    <th width="5%"><div class="tDiv">注册日期</div></th>
                                    <th width="5%"><div class="tDiv">访问次数</div></th>

                                    <th width="5%"><div class="tDiv">状态</div></th>
                                    <th width="20%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                                <tbody>
                                @foreach($firms as $firm)
                                    <tr class="">

                                        <td><div class="tDiv">{{$firm->id}}</div></td>
                                        <td><div class="tDiv">{{$firm->firm_name}}</div></td>
                                        <td><div class="tDiv">{{$firm->user_name}}</div></td>
                                        <td><div class="tDiv">{{$firm->contactName}}</div></td>

                                        <td><div class="tDiv"><img src="{{$firm->attorney_letter_fileImg}}" style="width:50px;height:50px;" ></div></td>
                                        <td><div class="tDiv">{{$firm->reg_time}}</div></td>
                                        <td><div class="tDiv">{{$firm->visit_count}}</div></td>

                                        <td>
                                            <label class="el-switch el-switch-lg">
                                                <input type="checkbox" @if($firm->is_freeze==0)checked @endif  name="switch" value="{{$firm->is_freeze}}"  data-id="{{$firm->id}}"   hidden>
                                                <span class="j_click el-switch-style"></span>
                                            </label>
                                        </td>

                                        <td class="handle">
                                            <div class="tDiv a2">
                                                <a href="{{url('/firm/detail')}}?id={{$firm->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                <a href="{{url('/firm/pointflow')}}?firm_id={{$firm->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>积分</a>
                                                <a href="{{url('/firm/log')}}?id={{$firm->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                                <a href="{{url('/firm/firmuser')}}?firm_id={{$firm->id}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>企业用户</a>
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

                                                {{$firms->links()}}

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
            var firm_id = $(this).siblings('input').attr('data-id');
            var input = $(this).siblings('input');
            if (input.val() === '1') {
                is_freeze = 0;
            } else {
                is_freeze = 1;
            }

            layui.use(['layer'], function() {
                layer = layui.layer;
                $.post("{{url('/firm/modify')}}",{"id":firm_id,"is_freeze":is_freeze,"_token":$("#_token").val()},function(res){
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

            location.href = "/firm/export";
        }

    </script>
@stop
