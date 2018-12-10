@extends(themePath('.')."seller.include.layouts.master")
@section('body')
    <div class="warpper">
        <div class="title">订单 - 订单列表</div>
        <div class="content">
            <div class="flexilist" id="listDiv">
                <div class="common-head order-coomon-head">
                    <div class="order_state_tab">
                        <a href="/seller/order/list" @if(empty($tab_code)) class="current" @endif>全部订单@if(empty($tab_code)) <em>({{$total}})</em> @endif</a>
                        <a href="/seller/order/list?tab_code=waitAffirm" @if($tab_code=='waitAffirm') class="current" @endif>待确认 <em id="waitAffirm"></em> </a>
                        <a href="/seller/order/list?tab_code=waitDeposit" @if($tab_code=='waitDeposit') class="current" @endif>待付定金 <em id="waitDeposit"></em> </a>
                        <a href="/seller/order/list?tab_code=waitPay" @if($tab_code=='waitPay') class="current" @endif>待付款 <em id="waitPay"></em> </a>
                        <a href="/seller/order/list?tab_code=waitSend" @if($tab_code=='waitSend') class="current" @endif>待发货<em id="waitSend"></em> </a>
                        <a href="/seller/order/list?tab_code=finish" @if($tab_code=='finish') class="current" @endif>已完成<em id="finish"></em> </a>
                        <a href="/seller/order/list?tab_code=cancel" @if($tab_code=='cancel') class="current" @endif>已作废 <em id="waitAffirm"></em> </a>
                    </div>
                    <div class="refresh">
                        <div class="refresh_tit" title="刷新数据" onclick="javascript:history.go(0)">
                            <i class="icon icon-refresh" style="display: block;margin-top: 1px;"></i></div>
                        <div class="refresh_span" >刷新 - 共{{$total}}条记录</div>
                    </div>

                    <div class="search">
                        <form action="/seller/order/list" name="searchForm" >
                            <div class="input">
                                <input type="text" name="order_sn" value="{{$order_sn}}" class="text nofocus w180" placeholder="订单编号" autocomplete="off">
                                <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
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
                                    <th width="9%"><div class="tDiv">下单日期</div></th>
                                    <th width="9%"><div class="tDiv">订单编号</div></th>
                                    <th width="9%"><div class="tDiv">会员账号</div></th>
                                    <th width="9%"><div class="tDiv">收货人</div></th>
                                    <th width="7%"><div class="tDiv">订单状态</div></th>
                                    <th width="6%"><div class="tDiv">运费</div></th>
                                    <th width="6%"><div class="tDiv">总金额</div></th>
                                    <th width="6%"><div class="tDiv">付款方式</div></th>
                                    <th width="13%" class="handle">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $vo)
                                    <tr class="">
                                        <td><div class="tDiv">{{$vo['add_time']}}</div></td>
                                        <td><div class="tDiv">{{$vo['order_sn']}}</div></td>
                                        <td>
                                            <div class="tDiv">
                                                @foreach($users as $v)
                                                    @if($v['id']==$vo['user_id'])
                                                        {{$v['user_name']}}
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td><div class="tDiv"><div>{{$vo['consignee']}}</div><div>{{$vo['mobile_phone']}}</div><div>{{$vo['address']}}</div></div></td>
                                        <td><div class="tDiv">{{$vo['_status']}}</div></td>
                                        <td><div class="tDiv">{{$vo['shipping_fee']}}</div></td>
                                        <td><div class="tDiv">{{$vo['goods_amount']}}</div></td>
                                        <td><div class="tDiv">@if($vo['pay_type']==1) 先款后货 @elseif($vo['pay_type']==2) 货到付款 @endif </div></td>
                                        <td class="handle">
                                            <div class="tDiv a3">
                                                <a href="/seller/order/detail?id={{$vo['id']}}&currentPage={{$currentPage}}"  title="查看" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                                @if($tab_code=='waitAffirm')
                                                <a href="javascript:void(0);" onclick="conf({{ $vo['id'] }})"  title="确认" class="btn_see"><i class="sc_icon icon-edit"></i>确认</a>
                                                <a href="javascript:void(0);" onclick="cancelOne({{ $vo['id'] }})"  title="取消" class="btn_see"><i class="sc_icon icon-trash"></i>取消</a>
                                                @elseif($tab_code=='waitDeposit')
                                                    <a href="javascript:void(0);"  title="确认收款" onclick="receiveDep({{ $vo['id'] }})" class="btn_see"><i class="sc_icon icon-edit"></i>确认收款</a>
                                                    <a href="javascript:void(0);" onclick="cancelOne({{ $vo['id'] }})"  title="取消" class="btn_see"><i class="sc_icon icon-trash"></i>取消</a>
                                                @elseif($tab_code=='waitPay')
                                                    <a href="javascript:void(0);"  title="确认收款" onclick="receiveM({{ $vo['id'] }})" class="btn_see"><i class="sc_icon icon-edit"></i>确认收款</a>
                                                    <a href="javascript:void(0);" onclick="cancelOne({{ $vo['id'] }})"  title="取消" class="btn_see"><i class="sc_icon icon-trash"></i>取消</a>
                                                @elseif($tab_code=='waitSend')
                                                    <a href="/seller/order/delivery?order_id={{$vo['id']}}&currentPage={{$currentPage}}"  title="发货" class="btn_see"><i class="sc_icon icon-edit"></i>发货</a>
                                                    <a href="javascript:void(0);" onclick="cancelOne({{ $vo['id'] }})"  title="取消" class="btn_see"><i class="sc_icon icon-trash"></i>取消</a>
                                                @endif
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
        // window.location.reload();
        paginate();
        function paginate(){
            layui.use(['laypage'], function() {
                var laypage = layui.laypage;
                laypage.render({
                    elem: 'page' //注意，这里 是 ID，不用加 # 号
                    , count: "{{$total}}" //数据总数，从服务端得到
                    , limit: "{{$pageSize}}"   //每页显示的条数
                    , curr: "{{$currentPage}}"  //当前页
                    , jump: function (obj, first) {
                        if (!first) {
                            window.location.href="/seller/order/list?currentPage="+obj.curr+"&tab_code={{$tab_code}}";
                        }
                    }
                });
            });
        }
        //作废订单
        function cancelOne(id)
        {
            layui.use('layer', function(){
                let index = parent.layer.getFrameIndex(window.name);
                parent.layer.iframeAuto(index);
                let layer = layui.layer;
                layer.prompt({
                    title: '确认取消订单,并输入原因',
                }, function(value, index, elem){

                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'order_status': 0,
                            'to_buyer':value
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:2000});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                            setTimeout( window.location.href="/seller/order/list?id="+id,3000)
                        }
                    });

                    layer.close(index);
                });
            });
        }
        $.ajax({
            url:'/seller/order/getStatusCount',
            data:'',
            type:'POST',
            success:function (result) {
                if (result.code == 1) {
                    let res = result.data;
                    if(res.waitDeposit > 0){
                        $('#waitDeposit').html(res.waitDeposit);
                    }
                    if(res.waitAffirm > 0){
                        $('#waitAffirm').html(res.waitAffirm);
                    }
                    if(res.waitPay > 0){
                        $('#waitPay').html(res.waitPay);
                    }
                    if(res.waitSend > 0){
                        $('#waitSend').html(res.waitSend);
                    }
                }
            }
        })

        // 确认订单
        function conf(id)
        {
            layui.use(['layer','upload'], function(){
                let layer = layui.layer;
                let upload = layui.upload;
                layer.open({
                    type: 1,
                    title: '确认订单',
                    btn:['确定','取消'],
                    // area: ['350px', '220px'],
                    content: '<div class="layui-upload">' +
                        '<button type="button" class="layui-btn" id="test1" style="margin-left: 129px;margin-top: 9px;">上传合同</button>' +
                        '  <div class="layui-upload-list">' +
                        '    <img class="layui-upload-img" id="demo1" data-img="" style="width: 360px;height: 250px">' +
                        '    <p id="demoText"></p>' +
                        '  </div>' +
                        '</div>',
                    yes: function(index){
                        let img = $('#demo1').data('img');
                        let action_note = $("#action_note").val();
                        if (img===''){
                            return layer.msg('未上传合同，无法确定');
                        } else {
                            layer.close(index);
                            $.ajax({
                                url:'/seller/order/updateOrderStatus',
                                data: {
                                    'id':id,
                                    'action_note': action_note,
                                    'order_status': 3,
                                    'contract': img
                                },
                                type: 'post',
                                success: function (res) {
                                    if (res.code === 1){
                                        layer.alert(res.msg, {icon: 1,time:600});
                                    } else {
                                        layer.alert(res.msg, {icon: 5,time:2000});
                                    }
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });

                var uploadInst = upload.render({
                    elem: '#test1'
                    , url: '/uploadImg'
                    ,data:{
                        'upload_type':'img',
                        'upload_path':'order/contract'
                    }
                    , before: function (obj) {
                        //预读本地文件示例，不支持ie8
                        obj.preview(function (index, file, result) {
                            $('#demo1').attr('src', result); //图片链接（base64）
                        });
                    }
                    , done: function (res) {
                        //如果上传失败
                        if (res.code !== 1) {
                            return layer.msg('上传失败');
                        } else {  //上传成功
                            $('#demo1').data('img', res.data.path);
                        }
                    }
                    , error: function () {
                        //演示失败状态，并实现重传
                        var demoText = $('#demoText');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function () {
                            uploadInst.upload();
                        });
                    }
                });



                // layer.confirm('确认订单?', {icon: 3, title:'提示'}, function(index){
                //     let action_note = $("#action_note").val();
                //     $.ajax({
                //         url:'/seller/order/updateOrderStatus',
                //         data: {
                //             'id':id,
                //             'action_note':action_note,
                //             'order_status': 3,
                //         },
                //         type: 'post',
                //         success: function (res) {
                //             if (res.code == 1){
                //                 layer.alert(res.msg, {icon: 1,time:600});
                //             } else {
                //                 layer.alert(res.msg, {icon: 5,time:2000});
                //             }
                //         }
                //     });
                //     layer.close(index);
                //     parent.location.reload();
                // });
            });
            // layui.use('layer', function(){
            //     let index = parent.layer.getFrameIndex(window.name);
            //     parent.layer.iframeAuto(index);
            //     let layer = layui.layer;
            //     layer.prompt({
            //         title: '确认订单,并输入交货日期',
            //     }, function(value, index, elem){
            //
            //
            //         let action_note = $("#action_note").val();
            //         $.ajax({
            //             url:'/seller/order/updateOrderStatus',
            //             data: {
            //                 'id':id,
            //                 'action_note':action_note,
            //                 'order_status': 3,
            //                 'delivery_period':value
            //             },
            //             type: 'post',
            //             success: function (res) {
            //                 if (res.code == 1){
            //                     layer.msg(res.msg, {icon: 1,time:2000});
            //                 } else {
            //                     layer.msg(res.msg, {icon: 5,time:2000});
            //                 }
            //                 setTimeout( window.location.href="/seller/order/list?id="+id,3000)
            //             }
            //         });
            //
            //         layer.close(index);
            //     });
            // });
        }
        // 确认收到定金
        function receiveDep(id) {
            layui.use('layer', function(){
                let index = parent.layer.getFrameIndex(window.name);
                parent.layer.iframeAuto(index);
                let layer = layui.layer;
                layer.prompt({
                    title: '确认收到定金，填写备注',
                }, function(value, index){
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'deposit_status': 1,
                            'action_note':value
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg, {icon: 1,time:2000});
                            } else {
                                layer.msg(res.msg, {icon: 5,time:2000});
                            }
                            setTimeout( window.location.href="/seller/order/list?id="+id,3000)
                        }
                    });

                    layer.close(index);
                });
            });
        }
        // 确认收款
        // 收款
        function receiveM(id) {
            layui.use('layer', function(){
                let layer = layui.layer;
                layer.confirm('确认收到付款?', {icon: 3, title:'提示'}, function(index){
                    let action_note = $("#action_note").val();
                    $.ajax({
                        url:'/seller/order/updateOrderStatus',
                        data: {
                            'id':id,
                            'pay_status': 1,
                            'action_note':action_note
                        },
                        type: 'post',
                        success: function (res) {
                            if (res.code === 1){
                                layer.alert(res.msg, {icon: 1,time:600});
                            } else {
                                layer.alert(res.msg, {icon: 5,time:2000});
                            }
                        }
                    });
                    layer.close(index);
                    setTimeout( window.location.href="/seller/order/list?id="+id,3000)
                });
            });
        }

    </script>
@stop
