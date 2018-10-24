@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '职员列表')

@section('css')
	<style>
       .whitebg{background: #FFFFFF;}
       .fl{float:left;}
       .ml15{margin-left:15px;}
       .br1{border: 1px solid #DEDEDE;}
       .pr {position:relative; }.pa{position: absolute;}
       .mt10{margin-top:10px;}
       .product_table,.Real_time{width: 905px;margin: 0 auto;margin-top: 20px;}
        .product_table li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .product_table li:nth-child(odd){background-color: #f4f4f4;}
        .product_table li{height: 45px;line-height: 45px;}
        .product_table li span{text-align: center;display: inline-block;float: left;}
        .product_table_btn{width: 60px;height: 25px;line-height: 25px;text-align: center;color: #fff;border-radius: 3px;}
        .cz_line{height: 14px;width: 1px;}
        .product_table .wh181{width: 181px;}
        .product_table .wh135{width: 135px;}
        .product_table .wh85{width: 85px;}
        .product_table .wh90{width: 90px;}
        .product_table .wh100{width: 100px;}
        .product_table .wh130{width: 130px;}
        .product_table .wh155{width: 155px;}
        .product_table .wh219{width: 219px;}
        .product_table .wh115{width: 115px;}
        .product_table .wh209{width: 209px;}
        .product_table .wh226{width: 226px;}
        .ovh{overflow: hidden;}
        .mt20{margin-top:20px;}
        .code_greenbg{background-color: #75b335;} 
        .br0{border: 0px;}
        .no_infor{width:125px;margin:0 auto; text-align: center;margin-top: 200px; display: none;}
        .tac{text-align:center !important;}
        .reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
        .reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
        .reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
        .reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
        .news_pages ul.pagination {text-align: center;}
        .news_pages ul.pagination li {display: inline-block;}
        .news_pages ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .news_pages ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .news_pages ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
        .fr{float:right;}
        .add_stock{width: 104px; height: 35px;line-height: 35px;background-color: #fe853b;border-radius: 3px;cursor: pointer;}
        .white,a.white,a.white:hover{color:#fff; text-decoration:none;}

        /*黑色*/
        .block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
        .power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-275px;position:fixed;margin-left:-250px;}
        .whitebg{background: #FFFFFF;}
        .pay_title{height: 50px;line-height: 50px;}
        .f4bg{background-color: #f4f4f4;}
        .pl30{padding-left:30px;}
        .gray,a.gray,a.gray:hover{color:#aaa;}
        .fs16{font-size:16px;}
        .fr{float:right;}
        .frame_close{width: 15px;height: 15px;line-height:0;
     display: block;outline: medium none;
     transition: All 0.6s ease-in-out;
     -webkit-transition: All 0.6s ease-in-out;
     -moz-transition: All 0.6s ease-in-out;
     -o-transition: All 0.6s ease-in-out;}
     .mr15{margin-right:15px;}
     .mt15{margin-top:15px;}
     .power_list{width: 415px;margin: 0 auto;overflow: hidden;margin-bottom: 35px;}
    .power_list li{margin-top: 15px;}
    .power_list li span{width: 60px;text-align: right; float: left;line-height: 40px;overflow: hidden;}
    .ml30{margin-left:30px;}
    .mt25{margin-top:25px;}
    .pay_text{width: 330px;height:40px;line-height: 40px;margin-left: 20px;border: 1px solid #e6e6e6;padding: 8px;box-sizing: border-box;}
    .addr_list li .pay_text{width: 343px;}
    .power_cate{width: 330px;margin-left: 80px;} 
    .br1{border: 1px solid #DEDEDE;}
    .power_cate_check_box{width: 235px;margin: 0 auto;margin-top: 25px;margin-bottom: 40px;}
    .power_cate_check_box li{float:left;overflow: hidden;margin-left: 65px;margin-top: 15px;}
    .power_cate_check_box li:nth-child(odd){margin-left: 0px;}
    .power_cate_check_box li span{line-height: 20px;color: #666;}
    input[type='checkbox']{width: 20px;height: 20px;background-color: #fff;-webkit-appearance:none;border: 1px solid #c9c9c9;border-radius: 2px;outline: none;}
    .check_box input[type=checkbox]:checked{background: url(../img/interface-tickdone.png)no-repeat center;}
    .mr5{margin-right:5px;}
    .til_btn{width: 120px;height: 40px;line-height: 40px;font-size: 16px;color: #fff;border-radius:3px;margin-left: 139px;cursor: pointer;}
    .code_greenbg{background-color: #75b335;} 
    .blackgraybg{background-color: #a0a0a0;}
    .xcConfirm .popBox .sgBtn.cancel{background-color: #546a79; color: #FFFFFF;}
	</style>
@endsection

@section('js')
	<script type="text/javascript">
        $(function(){
//          显示编辑框
            $('span').delegate('.edit_member','click',function(){
                $('#power_edit_frame').show();
                $('.block_bg').show();
                var id = $('.edit_member').attr('id');
                $.ajax({
                     url: "/editFirmUser",
                     dataType: "json",
                     data: {
                        'id':id
                    },
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        $('#firmUserName').val(data['data']['firm_user_info']['real_name']);
                        $('#firmUserPhone').val(data['data']['user_phone']);
                        $('#firmUserPhone').attr('disabled','disabled');
                        if(data['data']['firm_user_info']['can_po']){
                            $('#can_po').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_pay']){
                            $('#can_pay').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_stock_in']){
                            $('#can_stock_in').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_stock_out']){
                            $('#can_stock_out').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_confirm']){
                            $('#can_confirm').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_approval']){
                            $('#can_approval').attr("checked",'checked');
                        }
                        if(data['data']['firm_user_info']['can_stock_view']){
                            $('#can_stock_view').attr("checked",'checked');
                        }
                        // if(data['data']['firm_user_info']['can_stock_out']){
                        //     $('#can_stock_out').attr("checked",'checked');
                        // }
                    }
                })
            });
            //隐藏关闭框
            $('.cancel,.frame_close').click(function(){
                $('#power_edit_frame,.block_bg').hide();
                window.location.reload();
            })

            $('.addFirmUser').click(function(){
                $('#power_edit_frame').show();
                $('.block_bg').show();
            })

        });

        function del(obj) {
                var id = $(obj).attr('id');
                var flag = confirm("是否确认删除?");
                if(flag===true){
                      $.ajax({
                        'type':'post',
                        'data':{'id':id},
                        'url':'{{url('/delFirmUser')}}',
                        success:function(res){
                            // var result = JSON.parse(res);
                            if(res.code){
                                alert('删除成功');
                                window.location.reload();
                            }else{
                                alert('删除失败');
                                window.location.reload();
                            }
                        }
                    })
                }   
            }

        //保存
        function addFirmUserSave(){
            var phone = $('#firmUserPhone').val();
            var realName = $('#firmUserName').val();
            var arr = Array();
            $.each($('input:checkbox:checked'),function(){
                arr.push($(this).val());
            });
           
           //编辑
            if($('#firmUserPhone').attr('disabled') == 'disabled'){
                 Ajax.call('{{url('addFirmUser')}}', {'phone':phone,'permi':arr,'user_name':realName,'isEdit':1}, function(result){
                    if(result.code){
                        $.msg.alert('修改成功');
                        window.location.reload();
                    }else{
                        $.msg.alert(result.msg);
                    }
                 }, "POST", "JSON");
            }else{
                //新增
                 Ajax.call('{{url('addFirmUser')}}', {'phone':phone,'permi':arr,'user_name':realName,'isEdit':0}, function(result){
                    if(result.code){
                        $.msg.alert('添加成功');
                        window.location.reload();
                    }else{
                        $.msg.alert(result.msg);
                    }
                 }, "POST", "JSON");

            }
           
        }
	</script>
@endsection

@section('content')
<div class="ovh">
    <div class="fr add_stock tac white addFirmUser">+新增职员</div>
</div>
<ul class="product_table ovh mt20">
    <li><span class="wh226">编号</span><span class="wh226">职员姓名</span><span class="wh226">手机号</span><span class="wh226">操作</span></li>
    @foreach($firmUserInfo as $k=>$v)
    <li><span class="wh226">{{$v['id']}}</span><span class="wh226">{{$v['real_name']}}</span><span class="wh226">{{$v['phone']}}</span><span class="wh226"><button class="product_table_btn code_greenbg br0 edit_member" id="{{$v['id']}}">编辑</button><button id="{{$v['id']}}" onclick="del(this)"  class="product_table_btn br0 ml15 del_power">删除</button></span></li>
   @endforeach
</ul>
<div class="no_infor">
    <img src="img/serach_infor.png" />
    <p class="tac">暂无会员信息！</p>
</div>
           <!--  </div> -->


           <!--遮罩-->
    <div class="block_bg"></div>
    <!--编辑框-->
    <div class="power_edit whitebg" id="power_edit_frame">
        <div class="pay_title f4bg"><span class="fl pl30 gray fs16">新增/编辑</span><a class="fr frame_close mr15 mt15"><img src="img/close.png" width="15" height="15"></a></div>
        <ul class="power_list ml30 mt25">
            <li>
                <div class="ovh mt10"><span>手机号码:</span><input type="text" class="pay_text fl" id="firmUserPhone" placeholder="请输入员工手机号码"/></div>
                <div class="ml">注：职员必须先用手机号在平台注册个人账号</div>
            </li>
            <li><div class="ovh mt10"><span>职员姓名:</span><input type="text" class="pay_text fl" id="firmUserName" placeholder="请输入员工姓名"/></div></li>
            <li>
                <div class="power_cate mt10 br1 ovh">
                <ul class="power_cate_check_box ovh">
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="1" id="can_po" /><span class="fl">提交订单</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="2" id="can_pay" /><span class="fl">订单支付</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="3" id="can_confirm" /><span class="fl">确认收货</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="4" id="can_stock_out" /><span class="fl">出库管理</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="5"/><span class="fl" id="can_approval">审核订单</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="6"/><span class="fl" id="">查看订单</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="7" id="can_stock_in" id="can_stock_in" /><span class="fl">入库管理</span></label></li>
                <li><label class="check_box"><input class="check_box mr5 check_all fl" name="" type="checkbox" value="8"/><span class="fl" id="can_stock_view">查看库存</span></label></li>

                </ul>
                </div>
            </li>
            <li><div class="til_btn fl tac  code_greenbg" style="margin-left: 80px;" onclick="addFirmUserSave()">保 存</div><div class="til_btn tac  blackgraybg fl cancel" style="margin-left: 45px;">取消</div></li>
        </ul>
    </div>
    <!--确认删除-->
   <!--  <div class="confirm_del whitebg" id="confirm_del">
        <p class="tac fs16 mt25 mb20">确定删除此条信息？</p>
        <div class="confirm_del_btn"><button class="del_btn orangebg white">确认</button><button class="del_btn ml20">取消</button></div>
    </div> -->
@endsection
