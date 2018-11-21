@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">会员 - 卖货需求</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>点击下载查看，可以下载用户上传的卖货需求，帮助用户完成卖货</li>
            </ul>
        </div>
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
                                    <th width="4%"><div class="tDiv">编号</div></th>
                                    <th width="20%"><div class="tDiv">请求时间</div></th>
                                    <th width="15%"><div class="tDiv">会员名</div></th>
                                    <th width="15%"><div class="tDiv">昵称</div></th>
                                    <th width="15%"><div class="tDiv">卖货详情</div></th>
                                    <th width="15%" class="handle">卖货文档</th>
                                    <th width="8%" class="handle">状态</th>
                                    <th width="18%" class="handle">操作</th>
                                </tr>
                            </thead>
                            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                            <tbody>
                                @if(!empty($saleList))
                                    @foreach($saleList as $k=>$v)
                                        <tr class="table_info">

                                            <td><div class="tDiv">{{$v['id']}}</div></td>
                                            <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                            <td><div class="tDiv">{{$v['user_name']}}</div></td>
                                            <td><div class="tDiv">{{$v['nick_name']}}</div></td>
                                            @if(!empty($v['content']))
                                                <td class="handle">
                                                    <div class="tDiv a2">
                                                        <a class="btn_see btn_see_content" onclick="see_content()" id="{{$v['id']}}" is_read="{{$v['is_read']}}" content="{{$v['content']}}"><i class="sc_icon sc_icon_see"></i>点击查看</a>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="tDiv a2">
                                                        无
                                                    </div>
                                                </td>
                                            @endif
                                            @if(!empty($v['bill_file']))
                                                <td class="handle">
                                                    <div class="tDiv a2">
                                                        <a href="/storage/{{$v['bill_file']}}" class="btn_see" id="{{$v['id']}}" is_read="{{$v['is_read']}}"><i class="sc_icon sc_icon_see"></i>下载查看</a>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="tDiv a2">
                                                        无
                                                    </div>
                                                </td>
                                            @endif

                                            <td>
                                                <div class="read_info">
                                                    @if(!empty($v['is_read']) && $v['is_read'] == 1)
                                                        已读
                                                    @else
                                                        未读
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tDiv a2 btn_read">
                                                    @if($v['is_read'] != 1)
                                                        <a href="javascript:void(0);"  id="{{$v['id']}}" is_read="{{$v['is_read']}}" class="btn_trash btn_see"><i class="layui-icon layui-icon-util"></i>设为已读</a>
                                                    @endif
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
        $(function(){
            $('.btn_see').click(function(){
                let _self = $(this);
                let _id = _self.attr('id');
                let _is_read = _self.attr('is_read');
                if(_is_read == 0){
                    $.ajax({
                        type: "GET",
                        url: "/admin/user/setRead",
                        data: {'id':_id},
                        dataType: "json",
                        success: function(res){
                            if (res.code == 1){//设置成功
                                _self.parents(".table_info").find(".read_info").text('已读');
                                _self.parents('.table_info').find('.btn_read').empty();
                            } else {
                                layer.msg(res.msg);
                            }
                        }
                    });
                }
            });
        });
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
                            window.location.href="/admin/user/userSale?currpage="+obj.curr+"&user_name={{$user_name}}";
                        }
                    }
                });
            });
        }
        function see_content(){
            let _content = $('.btn_see_content').attr('content');
            layer.alert(_content);
        }
    </script>
@stop
