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
	    	<div class="crumbs">当前位置：<a href="/">首页</a> &gt; <a href="">人才招聘</a></div>
		
		<ul class="recruit-list">
			@if(!empty($recruitInfo))
				@foreach($recruitInfo as $v)
					<li>
						<h1>{{$v['recruit_job']}}</h1>
						<div class="recruit-list_txt">
						<p>招聘人数：{{$v['recruit_number']}}人</p>
						<p>工作地点：{{$v['recruit_place']}}</p>
						</div>
						<a class="recruit-list_btn" href="/recruit/detail/{{$v['id']}}" target="_blank">查看详情</a>
					</li>
				@endforeach
			@else
				<li class="nodata">无相关数据</li>
			@endif
				</ul>
	    </div>
	</div>


@endsection
