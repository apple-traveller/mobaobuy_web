<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<body>
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	请输入需要绑定的会员手机号<input type="text" name="user_name" id="user_name"><input type="button" name="" value="查找" onclick="search();"><br>
	<div id="endsearch" style="width:200px;height:30px;color:red;">未找到用户</div>
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