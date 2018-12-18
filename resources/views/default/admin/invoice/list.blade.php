@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
<div class="warpper">
    <div class="title">发票 - 发票申请列表</div>
    <div class="content">
        <div class="explanation" id="explanation">
            <div class="ex_tit">
                <i class="sc_icon"></i>
                <h4>操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span>
            </div>
            <ul>
                <li>该页面展示所有的发票信息。</li>
            </ul>
        </div>
        <div class="flexilist">

            <div class="common-head">

                <div class="order_state_tab">
                    <a href="/admin/invoice/list?status=-1" @if($status==-1) class="current" @endif>全部@if($status==-1)  <em>({{$total}})</em> @endif </a>
                    <a href="/admin/invoice/list?status=1"  @if($status==1)  class="current" @endif>待开票@if($status==1) <em>({{$total}})</em> @endif </a>
                    <a href="/admin/invoice/list?status=2"  @if($status==2)  class="current" @endif>已开票@if($status==2) <em>({{$total}})</em> @endif </a>
                    <a href="/admin/invoice/list?status=0"  @if($status==0)  class="current" @endif>已取消@if($status==0) <em>({{$total}})</em> @endif </a>
                </div>

                <div  class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                </div>
                <div class="search">
                    <form action="/admin/demand/list" name="searchForm" method="post" >
                        <div class="input">
                            <input type="text" id="test" name="add_time" placeholder="根据时间选择" value="{{$add_time}}" class="text nofocus goods_name" autocomplete="off">
                            <input type="submit" class="btn"  ectype="secrch_btn" value="">
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
                                <th width="10%"><div class="tDiv">发票编号</div></th>
                                <th width="10%"><div class="tDiv">店铺名称</div></th>
                                <th width="10%"><div class="tDiv">买家电话</div></th>
                                <th width="10%"><div class="tDiv">发票总金额</div></th>
                                <th width="10%"><div class="tDiv">订单数量</div></th>
                                <th width="10%"><div class="tDiv">状态</div></th>
                                <th width="10%"><div class="tDiv">创建时间</div></th>
                                <th width="18%" class="handle">操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(!empty($invoices))
                            @foreach($invoices as $vo)
                            <tr class="">
                                <td>
                                    <div class="tDiv">
                                        @if(empty($vo['invoice_numbers']))
                                            无
                                        @else
                                            {{$vo['invoice_numbers']}}
                                        @endif

                                    </div>
                                </td>
                                <td><div class="tDiv">{{$vo['shop_name']}}</div></td>
                                <td><div class="tDiv">{{$vo['member_phone']}}</div></td>
                                <td><div class="tDiv">￥{{$vo['invoice_amount']}}</div></td>
                                <td><div class="tDiv">{{$vo['order_quantity']}}</div></td>
                                <td>
                                    <div class="tDiv">
                                        @if($vo['status']==2)<div class='layui-btn layui-btn-sm layui-btn-radius'>已开票</div>
                                        @elseif($vo['status']==1)<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-primary'>待开票</div>
                                        @else <div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-danger'>已取消</div>
                                        @endif
                                    </div>
                                </td>
                                <td><div class="tDiv">{{$vo['created_at']}}</div></td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="{{url('/admin/invoice/detail')}}?id={{$vo['id']}}&currpage={{$currpage}}&status={{$status}}" class="btn_see">
                                            <i class="sc_icon sc_icon_see"></i>查看
                                        </a>
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
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currpage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/admin/invoice/list?currpage="+obj.curr;
                        }
                    }
                });
            });
        }

        $(function(){
            layui.use(['laydate'], function() {
                var laydate = layui.laydate;
                laydate.render({
                    elem: '#test'
                    ,range: true //或 range: '~' 来自定义分割字符
                });
            });
        });

    </script>
@stop
