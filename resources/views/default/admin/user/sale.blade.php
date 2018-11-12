@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">会员 - 卖货需求</div>
    <div class="content">
        <div class="flexilist">
            <div class="common-head">
                <div  class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$saleCount}}条记录</div>
                </div>

                <div class="search">
                    <form action="/admin/user/userSale" name="searchForm" >
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
                                <th width="8%"><div class="tDiv">编号</div></th>
                                <th width="23%"><div class="tDiv">请求时间</div></th>
                                <th width="23%"><div class="tDiv">会员名</div></th>
                                <th width="23%"><div class="tDiv">昵称</div></th>
                                <th width="23%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                            @if(!empty($saleList))
                            @foreach($saleList as $k=>$v)
                            <tr class="">

                                <td><div class="tDiv">{{$v['id']}}</div></td>
                                <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                <td><div class="tDiv">{{$v['user_name']}}</div></td>
                                <td><div class="tDiv">{{$v['nick_name']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="/storage/{{$v['bill_file']}}" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
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
                    , count: "{{$saleCount}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/user/list?currpage="+obj.curr+"&user_name={{$user_name}}";
                        }
                    }
                });
            });
        }

    </script>
@stop
