@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('wantBuy')['title'])
@section('keywords', getSeoInfoByType('wantBuy')['keywords'])
@section('description', getSeoInfoByType('wantBuy')['description'])
@section('css')
	<style>
		.recruit-list {margin-left: -20px;margin-top: 6px;margin-bottom: 50px;overflow: hidden;}
		.recruit-list li{float: left;background-color: #fff;    width: 385px;
			margin-left: 21px;margin-top: 5px;margin-bottom: 10px;transition: all 0.8s;}
		.recruit-list li h1 {height: 73px;line-height: 73px;font-weight: bold;font-size: 22px;
			color: #000;text-align: center; border-bottom: 1px solid #DEDEDE;}
		.recruit-list_txt {width: 305px;  margin: 30px auto;}
		.recruit-list_txt p {width: 100%;line-height: 45px;border-bottom: 1px solid #DEDEDE;text-align: center;
			font-size: 18px;color: #282828;}
		.recruit-list_btn {display: block;line-height: 37px;text-align: center;width: 130px;margin: 0 auto;
			font-size: 16px;border-radius: 25px;background: #eeeeee;margin-bottom: 35px;color: #333;}
		.recruit-list li:hover{transition: all 0.8s; box-shadow: 0px 10px 20px #cdcac3; -webkit-transition: all 0.8s;
			transform: translate(0, -10px); -webkit-transform: translate(0, -10px);-moz-transform: translate(0, -10px);
			-o-transform: translate(0, -10px); -ms-transform: translate(0, -10px);}
		.nav-div .nav-cate .ass_menu {display: none;}
	</style>
@endsection
@section('js')


	<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
	<script type="text/javascript">
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });
        })
	</script>
@endsection

{{--<body style="background-color: #f4f4f4;">--}}
@section('content')
	<!--logo-标题-->
	<div class="clearfix whitebg">
		<div class="w1200 ovh">
			<div class="mb30 mt10 ovh">
				<div class="logo fl"></div><div class="w_name fs24 gray fl mt20 ml20">人才招聘</div>
			</div>
		</div>
	</div>
	<!--内容-->
	<div class="clearfix mt10">
	    <div class="w1200">
	    	<div class="crumbs">当前位置：<a href="/">首页</a> &gt; <a href="">人才招聘</a> &gt;<span class="gray fs14">{{$recruitDetail['recruit_job']}}</span></div>
		<style type="text/css">
			.recruit_bg {background-color: #fff;overflow: hidden;}
			.recruit_liner {height: 1px;border: none;background-color: #cfcfcf;margin-top: 25px;}
			.recruit-zwei {display: block;width: 139px;    margin: 0px auto;margin-top: 20px;border-radius: 25px;height: 31px;line-height: 31px;text-align: center;background-color: #999999;color: #fff;}
			.recruit-txt {margin-left: 285px; margin-top: 30px; margin-bottom: 50px;}
			.recruit-txt li {font-size: 18px;line-height: 35px;color: #161616;}
		</style>
		<div class="recruit_bg mt10">
			@if(!empty($recruitDetail))
					<h1 class="tac fwb fs24 mt40">{{$recruitDetail['recruit_job']}}</h1>
					<div class="tac mt20"><span>招聘人数：{{$recruitDetail['recruit_number']}}人</span><span class="ml20">工作地点：{{$recruitDetail['recruit_place']}}</span><span class="ml15">招聘公司：{{$recruitDetail['recruit_firm']}}</span><span class="ml15">薪资待遇：{{$recruitDetail['recruit_pay']}}</span></div>
					<hr class="recruit_liner" noshade="noshade">
					<ul class="recruit-txt">
						<h1 class="fs18 fwb mb20">岗位职责：</h1>
						{{--<li>1、负责支票的保管、签发支付工作；</li>--}}
						{{--<li>2、负责承兑汇票的开具、台帐登记、到期承兑工作；</li>--}}
						{{--<li>3、严格按照公司的财务制度报销结算公司各项费用以及对外支付各类款项；</li>--}}
						{{--<li>4、及时、准确、逐笔登记日记帐，定期上缴各种完整的原始凭证；</li>--}}
						{{--<li>5、根据公司领导的需要，编制各种资金流动报表；</li>--}}
						{{--<li>6、做好每月的工资发放工作；</li>--}}
						{{--<li>7、完成其他由上级主管指派及自行发展的工作。</li>--}}
						{{$recruitDetail['job_desc']}}
					</ul>
				@endif
				</div>
				<a href="/recruit/list" class="recruit-zwei">返回招聘职位</a>
	    </div>
	</div>	

@endsection
