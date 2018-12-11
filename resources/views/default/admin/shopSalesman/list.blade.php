@extends(themePath('.')."seller.include.layouts.master")
{{--<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/general.css')}}" />--}}
{{--<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'layui/css/dsc/style.css')}}" />--}}
@section('body')
    <div class="warpper">
        <div class="title">业务员列表</div>
        <div class="content">
            <div class="explanation" id="explanation">
                <div class="ex_tit">
                    <i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span>
                </div>
                <ul>
                    <li>展示了所有商家的业务员相关信息列表。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="/admin/salesman/add"><div class="fbutton">
                                <div class="add" title="添加业务员">
                                    <span>
                                        <i class="icon icon-plus">

                                        </i>
                                        添加业务员
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据">
                            <i class="icon icon-refresh"  style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span">刷新 - 共{{$total}}条记录</div>
                    </div>
                </div>
                <div class="common-content">
                    <form method="POST" action="" name="listForm">
                        <div class="list-div" id="listDiv">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th width="14%"><div class="tDiv">商家名称</div></th>
                                    <th width="12%"><div class="tDiv">姓名</div></th>
                                    <th width="10%"><div class="tDiv">电话</div></th>
                                    <th width="10%"><div class="tDiv">QQ</div></th>
                                    <th width="10%"><div class="tDiv">添加时间</div></th>
                                    <th width="10%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $v)
                                    <tr class="">
                                        <td><div class="tDiv">{{$v['company_name']}}</div></td>
                                        <td><div class="tDiv">{{$v['name']}}</div></td>
                                        <td><div class="tDiv">{{$v['mobile']}}</div></td>
                                        <td><div class="tDiv">{{$v['qq']}}</div></td>
                                        <td><div class="tDiv">{{$v['add_time']}}</div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/admin/salesman/edit?id={{$v['id']}}&currentPage={{$currentPage}}" title="编辑" class="btn_edit"><i class="icon icon-edit"></i>编辑</a>
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
        layui.use(['upload','layer','laypage'], function() {
            let layer = layui.layer;
            let laypage = layui.laypage;

            $(".viewPic").click(function(){
                let src = $(this).attr('path');
                layer.open({
                    type: 1,
                    title: '大图',
                    // area: ['700px', '600px'],
                    content: '<img src="'+src+'">'
                });
            });

            laypage.render({
                elem: 'page' //注意，这里 是 ID，不用加 # 号
                , count: "{{$total}}" //数据总数，从服务端得到
                , limit: "{{$pageSize}}"   //每页显示的条数
                , curr: "{{$currentPage}}"  //当前页
                , jump: function (obj, first) {
                    if (!first) {
                        window.location.href="/admin/salesman/list?currentPage="+obj.curr+"&name={{$name}}";
                    }
                }
            });

        });

        $("#submitBtn").click(function () {
            let settlement_bank_account_name = $("input[name='settlement_bank_account_name']").val();
            let settlement_bank_account_number = $("input[name='settlement_bank_account_number']").val();
            let data = {};
            if (settlement_bank_account_name){
                data.settlement_bank_account_name = settlement_bank_account_name;
            }
            if (settlement_bank_account_number) {
                data.settlement_bank_account_number = settlement_bank_account_number;
            }
            if (data.length===0){
                return false;
            }
            console.log(data);
            $.ajax({
                url:'/admin/updateCash',
                data:data,
                type:'POST',
                success: function (res) {
                    if (res.code===1){
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                    window.location.reload();
                }
            });
        });
    </script>
@stop
