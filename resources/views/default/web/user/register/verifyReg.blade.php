<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>注册_提交成功 @yield('title')</title>
		@include(themePath('.','web').'web.include.partials.base')
		<style>
			.clearfix {display: inline-block;}
			* html .clearfix {height: 1%;}
			.clearfix {display: block;}
			.clearfix:after {clear: both;content: ".";display: block;height: 0;visibility: hidden;}
			.mt30{margin-top:30px;}
			.succes_main{width: 1200px;margin: 0 auto;border-top: 2px solid #50b200;background-color: #f6fcf0;}
			.ovh{overflow: hidden;}
			.succes_main_til{width:280px;margin:0 auto; margin-top:60px;padding-left:25px;height: 31px;line-height: 31px; color: #50b200;background: url(default/img/succes_til.png)no-repeat 0px 5px;}
			.succes_main_til .succes_til_img{margin-top: 5px;}
			.fs18{font-size:18px;}
			.tac{text-align:center !important;}
			.mt35{margin-top:35px;}
			.orange,a.orange,a.orange:hover{color:#ff6600;}
			.enter_index{width:175px;height:40px;line-height: 40px;margin:0 auto;margin-top:35px;background-color: #50b200;border: none;}
			.db{display:block;}
			.white,a.white,a.white:hover{color:#fff; text-decoration:none;}
			.tac{text-align:center !important;}
			.mt5{margin-top:5px;}
			.gray,a.gray,a.gray:hover{color:#aaa;}
			.mb50{margin-bottom:50px;}
		</style>
	</head>
	<body>
	@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '账户注册'])@endcomponent
	<div class="clearfix mt30">
		<div class="succes_main ovh">
			<div class="succes_main_til fs18">恭喜您，注册申请提交成功！</div>
			<p class="tac mt35">请等待客服人员审核，如有问题请咨询客服：<font class="orange">{{getConfig('service_phone')}}</font></p>
			<button class="enter_index db white ">进入官网首页</button>
			<p class="tac mt5 gray mb50"><span class="orange">10s</span> 后返回官网首页</p>
		</div>
	</div>
	@include(themePath('.','web').'web.include.partials.footer_service')
	@include(themePath('.','web').'web.include.partials.footer_new')
	@include(themePath('.','web').'web.include.partials.copyright')

	</body>
</html>
