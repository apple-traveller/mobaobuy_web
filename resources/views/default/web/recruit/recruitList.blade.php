@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('recruit')['title'])
@section('keywords', getSeoInfoByType('recruit')['keywords'])
@section('description', getSeoInfoByType('recruit')['description'])
@section('css')
	<style>
		.block_bg{display:none;height: 100%;left: 0;position: fixed; top: 0;width: 100%;background: #000;opacity: 0.8;z-index:2;}
		/*.power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-175px;position:fixed;margin-left:-250px;height: 300px;}*/
		.power_edit{display:none;z-index: 2;width:520px;  left:50%; top:50%;margin-top:-175px;position:fixed;margin-left:-250px;}
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
		.whitebg{background: #FFFFFF;}
		.box-info{
			margin: 0px 10px;
			float: left;
		}

		.power_list li{font-size: 18px;overflow: hidden;}.til_btn{padding: 7px 39px;border-radius: 3px; color: #fff;}
		.code_greenbg{background-color: #75b335;}.blackgraybg{background-color: #CCCCCC;}

		.payment-order-box{padding: 30px;}
		.payment-box{padding: 30px;}
		.payment-box .p-mode-tit {padding-bottom: 15px;border-bottom: 1px solid #d2d2d2;}
		.payment-box .p-mode-tit h3{font-size: 18px;height: 18px;line-height: 18px;padding-left: 10px;border-left: 4px solid #f42424;}
		.payment-box .p-mode-list {margin-top: 20px;width: calc(100% + 12px);overflow: hidden;}
		.payment-box .p-mode-item {float: left;width: 178px;height: 88px;border: 1px solid #d2d2d2;text-align: center;position: relative;margin: 0 12px 12px 0;text-align:center}
		.payment-box .p-mode-item input[type="button"]{border: 0;width: 178px;height: 88px;display: block;font-size: 0;outline: 0;cursor: pointer;}
		.p-mode-list .alipay input[type="button"] {background: url({{asset(themePath('/','web').'/img/alipay-icon.png')}}) center center no-repeat;}
		.p-mode-list .wxpay input[type="button"] {background: url({{asset(themePath('/','web').'/img/wxpay-icon.png')}}) center center no-repeat;}
		.p-mode-list .enterprise_transfer input[type="button"] {background: url({{asset(themePath('/','web').'/img/enterprisepay-icon.jpg')}}) center center no-repeat;}






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
		.co_filter_condition dl.condition_item dd a:hover, .co_filter_condition dl.condition_item dd a.current {
			background-color: #38b447;
			color: #fff !important;
			-webkit-transition: all 0.3s;
			-moz-transition: all 0.3s;
			-ms-transition: all 0.3s;
			-o-transition: all 0.3s;
			transition: all 0.3s;
		}
		.co_filter_condition dl.condition_item dt {
			float: left;
			width: 68px;
			height: 24px;
			line-height: 24px;
			text-align: left;
			color: #333333;
			font-size: 14px;
			font-weight: bold;
		}
		.co_filter_condition {
			padding: 0px 30px;
			background: #ffffff;
		}
		.co_filter_condition dl.condition_item {
			position: relative;
			padding: 15px 0;
			padding-right: 50px;
		}
		.co_filter_condition dl.condition_item dd {
			display: block;
			height: 24px;
			overflow: hidden;
		}
		.co_filter_condition dl.condition_item dd .all_item {
			height: auto;
		}
		.co_filter_condition dl.condition_item dd a {
			display: inline-block;
			height: 24px;
			line-height: 24px;
			padding: 0 10px;
			color: #666666;
			white-space: nowrap;
			border-radius: 15px;
			margin-right: 5px;
			background-color: #fff;
		}
		.recruitment_item {
			padding: 30px 30px 20px 0px;
			/*border-bottom: 1px solid #dedede;*/
			-webkit-transition: all 0.2s linear;
			-moz-transition: all 0.2s linear;
			-ms-transition: all 0.2s linear;
			-o-transition: all 0.2s linear;
			transition: all 0.2s linear;
		}
		.recruitment_item:first-child{padding-top: 0px;}
		.recruitment_item .position_info {
			position: relative;
		}

		.position_info {
			overflow: hidden;
		}
		.recruitment_item .position_info dl.company_dl dd {
			margin-left: 0;
		}
		.position_info dd .dd_top {
			overflow: hidden;
		}
		.recruitment_item .position_info .dd_top .name {
			font-size: 18px;
		}

		a {
			color: #333333;
			outline-style: none;
		}
		a {
			/* text-decoration: none; */
		}
		.recruitment_item .position_info dl.company_dl dd .city {
			color: #58A0FE;
			margin-left: 15px;
		}

		a {
			color: #333333;
			outline-style: none;
		}
		.recruitment_item .position_info dl.company_dl dd .ud_time {
			margin-left: 20px;
			color: #aaa;
		}
		.recruitment_item .position_info .dd_bot {
			margin-top: 9px;
		}

		.position_info dd .dd_bot {
			overflow: hidden;
		}
		.recruitment_item .position_info dl.company_dl dd .f_right {
			position: absolute;
			top: 1px;
			right: 0;
		}

		.f_right {
			float: right;
		}
		.recruitment_item .obligation {
			margin-top: 15px;
		}
		.recruitment_item .obligation p {
			line-height: 1.6;
		}

		p {
			word-wrap: break-word;
		}
		.recruitment_item .position_info .dd_bot .salary {
			color: #fc5c63;
			font-size: 16px;
		}
		.recruitment_item .position_info dl.company_dl dd .info {
			display: inline-block;
			margin-left: 10px;
		}
	</style>
@endsection
@section('js')


	<script src="{{asset(themePath('/', 'web').'js/index.js')}}" ></script>
	<script type="text/javascript">
        $(function(){
            $(".nav-cate").hover(function(){
                $(this).children('.ass_menu').toggle();// 鼠标悬浮时触发
            });

            //隐藏关闭框
            $('.cancel,.frame_close').click(function(){

                $('#power_edit_frame,.block_bg').remove();
                window.location.reload();
            });
        })

        function openFrame(){
            $('.nav-cate .cate_title').css('color','rgba(0, 0, 0, 0.5)');
            $('.nav-cate .cate_title').css('background-color','rgba(0, 0, 0, 0.5)');
            $('#power_edit_frame').show();
            $('.block_bg').show();
        }

        //提交
        function resumeSave(id){
            var resume_path = $('input[name=resume_path]').val();
            if(id == '' || resume_path == ''){
                $.msg.alert('上传简历不能为空');
                return;
            }
            $.ajax({
                url:'/resumeSave',
                data:{'id':id,'resume_path':resume_path},
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code){
                        $.msg.alert('上传成功');
                        window.location.reload();
                    }else{
                        $.msg.alert(res.msg);
                    }
                }
            })
        }

	</script>
@endsection

	{{--<body style="background-color: #f4f4f4;">--}}
	@section('content')
		@if(!empty($recruitInfo))
			<div style="margin:0 auto;width:1200px;background-color: white;margin-top:20px;">
				{{--<section class="co_filter_condition mb15" style=" margin-left:5px;margin-top:20px;">--}}
					{{--<dl class="condition_item city">--}}
						{{--<dt>城市:</dt>--}}
						{{--<dd>--}}
							{{--<div class="all_item">--}}
								{{--<a ka="job-city-all" href="/job/g2090879.html#co_tab" ref="nofollow">全部</a>--}}
								{{--@if(!empty($place))--}}
									{{--@foreach($place as $v)--}}
										{{--<a ka="job-city-show" onclick="getPlace(1,this);" href="javascript:(0)" text="{{$v}}" class="">{{$v}}</a>--}}
									{{--@endforeach--}}
								{{--@endif--}}
							{{--</div>--}}
						{{--</dd>--}}
					{{--</dl>--}}
				{{--</section>--}}
				<div style="margin:0 auto;width:1130px;height: 800px;" id="recruit">

						<section class="recruitment_item wrap_style " data-e="false" style="padding-top:10px;">
							<div class="position_info" style="margin-top:30px;">
								<dl class="company_dl">
									<dd>
										<p class="dd_top">
											<a class="name" ka="job-godetail1" href="javascript:(0);" target="_blank" style="font-size: 18px;">{{$recruitInfo['recruit_job']}}</a>
											<a href="javascript:(0);" class="city" target="_blank" style="margin-left: 15px;">[工作地点:{{$recruitInfo['recruit_place']}}]</a>
											<span class="ud_time" style="margin-left: 20px;color: #aaa;">{{$recruitInfo['add_time']}}发布</span>
										</p>
										<div class="dd_bot">
											<span class="salary">职位薪资:{{$recruitInfo['recruit_pay']}}</span>
											<div class="info">
												<span>经验:{{$recruitInfo['working_experience']}}</span>
												<em class="line"></em>
												<span>学历:{{$recruitInfo['education']}}</span>
												<em class="line"></em>
												<span>类型:{{$recruitInfo['recruit_type']}}</span>
											</div>
										</div>
									</dd>
								</dl>
							</div>
							<div class="obligation">
								<p>
									岗位说明：
									{!! $recruitInfo['job_desc'] !!}
								</p>
								{{--<span style="margin-left:10px;">申请职位</span>--}}
								<input type="button" value="申请职位" style="float:left;font-size:15px;text-align: center;margin-top:5px;" onclick="openFrame();">
							</div>
						</section>


					<div class="page">
						<div class="link">
							<div class="news_pages" style="margin-top: 20px;text-align: center;">
								<ul id="page" class="pagination"></ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="nodata">暂无招聘信息</div>
		@endif
		<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>

		<div class="block_bg"></div>
		<div class="power_edit whitebg" id="power_edit_frame" style="">
			<div class="pay_title f4bg"><span class="fl pl30 gray fs16">上传简历</span><a class="fr frame_close mr15 mt15"><img src="img/close.png" width="15" height="15"></a></div>
			<ul class="power_list ml30 mt25">
				@component('widgets.upload_file',['upload_type'=>'file','upload_path'=>'user/resume_path','name'=>'resume_path'])@endcomponent
				<li style="clear:both;margin-top:30px;margin-bottom:20px;"><div style="margin-top:20px; margin-left: 80px;cursor: pointer;" class="til_btn fl tac  code_greenbg" onclick="resumeSave({{$recruitInfo['id']}})">提 交</div><div class="til_btn tac  blackgraybg fl cancel" style="margin-left: 45px;margin-top: 20px;cursor: pointer;">取消</div></li>
			</ul>
		</div>
		{{--<script>--}}
			{{--$(function(){--}}
                {{--paginate();--}}
			{{--})--}}

			{{--function getInfo(currpage,place) {--}}
                {{--$.ajax({--}}
                    {{--url: '/recruit/recruitByCondition',--}}
                    {{--type: 'post',--}}
                    {{--data: {'place':place,'currpage':currpage},--}}
                    {{--success:function (res) {--}}
                        {{--console.log(res);--}}
                        {{--if(res.code == 200){--}}
                            {{--var data = res.data;--}}
                            {{--var currpage = data.currpage;--}}
                            {{--var pageSize = data.pageSize;--}}
                            {{--var total = data.total;--}}
                            {{--var list = data.list;--}}
                            {{--var strHtml = '';--}}
                            {{--for(var i = 0; i < list.length; i++){--}}
                                {{--strHtml += '<section class="recruitment_item wrap_style " data-e="false"><div class="position_info"> <dl class="company_dl"> <dd> <p class="dd_top"> <a class="name" ka="job-godetail1" href="javascript:(0);" target="_blank" style="font-size: 18px;">'+list[i]['recruit_job']+'</a><a href="javascript:(0);" class="city" target="_blank" style="margin-left: 15px;">[工作地点:'+list[i]['recruit_place']+']</a><span class="ud_time" style="margin-left: 20px;color: #aaa;">'+list[i]['add_time']+'发布</span> </p> <div class="dd_bot"> <span class="salary">职位薪资:'+list[i]['recruit_pay']+'</span> <div class="info"> <span>经验:'+list[i]['working_experience']+'</span> <em class="line"></em> <span>学历:'+list[i]['education']+'</span> <em class="line"></em> <span>类型:'+list[i]['recruit_type']+'</span> </div> </div> </dd> </dl> </div> <div class="obligation"> <p>岗位说明：;'+list[i]['job_desc']+'</p> </div> </section>';--}}
                            {{--}--}}
                            {{--$('#recruit').children('section').remove();--}}
                            {{--$('#recruit').prepend(strHtml);--}}
                            {{--layui.use(['laypage'], function() {--}}
                                {{--var laypage = layui.laypage;--}}
                                {{--laypage.render({--}}
                                    {{--elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号--}}
                                    {{--, count: total //数据总数，从服务端得到--}}
                                    {{--, limit: pageSize   //每页显示的条数--}}
                                    {{--, curr: currpage  //当前页--}}
                                    {{--, prev: "上一页"--}}
                                    {{--, next: "下一页"--}}
                                    {{--, theme: "#88be51" //样式--}}
                                    {{--, jump: function (obj, first) {--}}
                                        {{--if (!first) {--}}
{{--//                                            window.location.href='/recruit/list?city='+place+'&currpage='+obj.curr;--}}
                                            {{--getInfo(obj.curr,place);--}}
                                        {{--}--}}
                                    {{--}--}}
                                {{--});--}}
                            {{--});--}}
                        {{--}--}}
                    {{--}--}}
                {{--})--}}
            {{--}--}}

			{{--function getPlace(currpage,obj){--}}
                {{--$(obj).addClass('current').siblings().removeClass('current');--}}
                {{--var place = $(obj).text();--}}
                {{--if(place == ''){--}}
                    {{--return;--}}
                {{--}--}}
                {{--getInfo(currpage,place);--}}

			{{--}--}}

            {{--//分页--}}
            {{--function paginate(){--}}
                {{--layui.use(['laypage'], function() {--}}
                    {{--var laypage = layui.laypage;--}}
                    {{--laypage.render({--}}
                        {{--elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号--}}
                        {{--, count: "{{$recruitInfo['total']}}" //数据总数，从服务端得到--}}
                        {{--, limit: "{{$pageSize}}"   //每页显示的条数--}}
                        {{--, curr: "{{$currpage}}"  //当前页--}}
                        {{--, prev: "上一页"--}}
                        {{--, next: "下一页"--}}
                        {{--, theme: "#88be51" //样式--}}
                        {{--, jump: function (obj, first) {--}}
                            {{--if (!first) {--}}
{{--//                       getInfo(obj.curr);--}}
                                {{--window.location.href='/recruit/list?currpage='+obj.curr;--}}
                            {{--}--}}
                        {{--}--}}
                    {{--});--}}
                {{--});--}}
            {{--}--}}
		{{--</script>--}}
@endsection
