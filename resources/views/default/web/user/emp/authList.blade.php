@extends(themePath('.','web').'web.include.layouts.member')
@section('title', '设置订单审批属性')

@section('css')
	<style>
	
        .member_right_title_icon{background: url(../img/member_title_icon.png)no-repeat 0px 6px;}
        .ml15{margin-left:15px;}
        .white,a.white,a.white:hover{color:#fff; text-decoration:none;}
        .br0{border: 0px;}
        .date_btn{width: 90px;height: 34px;line-height: 34px;background-color: #75b335;border-radius: 2px;cursor: pointer;}
        .radiobox{display:block;position: relative;padding-left: 28px;}
        .radiobox:before{content: '';display: inline-block;width: 14px;height: 14px;border: 1px solid #cfcfcf;border-radius: 50%;
            background: #fff;position: absolute;top: 2px;left: 6px;}
        .radiobox input[type=radio]:checked:before{content: '';display: inline-block;width: 10px;height: 10px;border-radius: 50%;
            background: #75b335;position: absolute;top: 2px;left: 2px;}
        .radiobox input[type=radio]{    position: absolute;top: 2px;left: 6px;}
        .reward_table{width: 905px;margin: 0 auto;margin-top: 20px;margin-bottom: 70px;}
        .reward_table_list{width: 905px;margin: 0 auto;margin-top: 20px;margin-bottom: 70px;}
        .reward_table_list li{height: 46px;line-height: 46px;}
        .reward_table_title{width: 70%;padding: 0 10px;box-sizing: border-box;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .reward_table_num{width: 30%;}
        .reward_table_list li:nth-child(odd){background-color: #f4f4f4;}
        .reward_table_list li:first-child{font-size:14px;height:40px;line-height:40px;border: 1px solid #DEDEDEA;background-color: #eeeeee;}
        .reward_table_list li:last-child{font-size:14px;height:81px;line-height:81px;background-color: #f8f8f8;}
        .reward_table_list .reward_totle_num{float: right;margin-right: 100px;}

        .lcolor{color:#75b335;}

        .reward_table_bottom{position:absolute;bottom: 5px;right: 27px;}
        .reward_table_bottom ul.pagination {display: inline-block;padding: 0;margin: 0;}
        .reward_table_bottom ul.pagination li {height: 20px;line-height: 20px;display: inline;}
        .reward_table_bottom ul.pagination li a {color: #ccc;float: left;padding: 4px 16px;text-decoration: none;transition: background-color .3s;
            border: 1px solid #ddd;margin: 0 4px;}
        .reward_table_bottom ul.pagination li a.active {color: #75b335;border: 1px solid #75b335;}
        .reward_table_bottom ul.pagination li a:hover:not(.active) {color: #75b335;border: 1px solid #75b335;}
        .ovh{overflow: hidden;}
        .ovhwp{overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        /*会员中心-权限设置*/
        .approval_radio{width:300px;margin-bottom: 30px;}
        .approval_radio li{color: #666;margin-top: 20px;}

        .default_address input[type=checkbox],input[type=radio] {
        margin:initial;-webkit-appearance: none;appearance: none;outline: none;
        width: 16px; height: 16px;cursor: pointer;vertical-align: center;background: #fff;border: 1px solid #ccc;position: relative;}

        .default_address input[type=checkbox]:checked::after {
        content: "\2713";display: block;position: absolute;top: -1px;
        left: -1px;right: 0;bottom: 0;width: 12px;height: 16px;line-height: 17px;padding-left: 4px;
        color: #fff;background-color: #75b334;font-size: 13px;}
	</style>
@endsection

@section('js')
	<script type="text/javascript">
        function NeedApproval(){
             var approvalId = $('input[name=currentRadio]:checked').val();
             $.ajax({
                'type':'post',
                'data':{'approvalId':approvalId},
                'url':'/OrderNeedApproval',
                success:function(res){
                    if(res.code){
                        alert('审核设置成功');
                    }else{
                        alert('审核设置失败');
                        window.location.reload();
                    }
                }
             })
        }
	</script>

@endsection

@section('content')
<!--右部分-->
                <div class="reward_table ovh">  
                    <ul class="approval_radio ovh">
                        @if($approvalInfo)
                            <li><label class="radiobox"><input name="currentRadio" type="radio" value="0">下单不需要审批</label></li>
                            <li><label class="radiobox"><input name="currentRadio" type="radio" checked="" value="1">下单需要交易经理审批</label></li>
                        @else
                            <li><label class="radiobox"><input name="currentRadio" type="radio" checked="" value="0">下单不需要审批</label></li>
                            <li><label class="radiobox"><input name="currentRadio" type="radio" value="1">下单需要交易经理审批</label></li>
                        @endif
                    </ul>
                    <button class="date_btn br0 white ml15" onclick="NeedApproval()">保存</button>
                </div>


@endsection
