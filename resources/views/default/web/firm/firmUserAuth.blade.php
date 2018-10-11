<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<style type="text/css">
  ul{
    float:left;
  }
  li{
  float:left;
  list-style: none;
  }
</style>
<body>
  @if($userInfo['is_firm'])
    <div>
  	设置权限
    @foreach($firmUser as $v)
    <div>
      <p>员工真实姓名:{{$v['real_name']}}</p>
    </div>
    <ul>
      <li>采购<input type="checkbox" name="can_po" @if($v['can_po']) checked="checked" @endif></li>
      <li>付款<input type="checkbox" name="can_pay" @if($v['can_pay']) checked="checked" @endif></li>
      <li>确认收货<input type="checkbox" name="can_confirm" @if($v['can_confirm']) checked="checked" @endif></li>
      <li>其他入库<input type="checkbox" name="can_stock_in" @if($v['can_stock_in']) checked="checked" @endif></li>
      <li>库存出库<input type="checkbox" name="can_stock_out" @if($v['can_stock_out']) checked="checked" @endif></li>
    </ul>
    @endforeach
    </div>

  @else
  <div>我的权限
     <ul>
      <li>采购<input type="checkbox" name="can_po"></li>
      <li>付款<input type="checkbox" name="can_pay"></li>
      <li>确认收货<input type="checkbox" name="can_confirm"></li>
      <li>其他入库<input type="checkbox" name="can_stock_in"></li>
      <li>库存出库<input type="checkbox" name="can_stock_out"></li>
    </ul>
  </div>
@endif

 
</body>
</html>
<script type="text/javascript">
	function search(){
		var user_name = $('#user_name').val();
		$.ajax({
                headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'user_name':user_name},
                'url':'{{url('/createFirmUser')}}',
                success:function(res){
                	var result = JSON.parse(res);
                   	 if(result['code']){
                   		var result = JSON.parse(res);
                   	 	var str = '';
                   	 	str = '<div>员工姓名<input type="text" name="real_name" /><p>用户名：'+result['info']['user_name']+'</p><p>昵称：'+result['info']['nick_name']+'</p><input id="po" type="checkbox" name="can" value="1" /> 采购<input type="checkbox" id="pay" name="can" value="2"/> 付款　<input id="po" type="checkbox" name="can" value="3" /> 收货<input type="hidden" name="_id" value="'+result['info']['id']+'"><input type="button" name="" value="确认" onclick="permiss();"></div>';	
                   	 	$('#endsearch').html(str);
                   	 }else{
                   	 	alert('没有找到');
                   	 }
                }
		})
	}

	function permiss(){
		 var userId = $("input[name=_id]").val();
		 var realName = $("input[name=real_name]").val();
		 var permi = Array();
		 // var can_po = $("input:checkbox[name='can_po']:checked").val();
		 // var can_pay = $("input:checkbox[name='can_pay']:checked").val();
		 
		$("input:checkbox[name='can']:checked").each(function() {
		  	permi.push($(this).val());  // 每一个被选中项的值
		});

		$.ajax({
                headers:{ 'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                'type':'post',
                'data':{'user_id':userId,'permi':permi,'user_name':realName},
                'url':'{{url('/addFirmUser')}}',
                success:function(res){
                	var result = JSON.parse(res);
                	if(result.code){
                		alert('绑定会员成功');
                		window.location.href = '/';
                	}else{
                		alert('绑定会员失败');
                		window.location.reload();
                	}
                }
         })
	}
</script>