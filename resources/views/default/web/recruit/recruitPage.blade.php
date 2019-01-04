@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('recruit')['title'])
@section('keywords', getSeoInfoByType('recruit')['keywords'])
@section('description', getSeoInfoByType('recruit')['description'])
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
			border-bottom: 1px solid #dedede;
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

		/*.position_info {*/
			/*overflow: hidden;*/
		/*}*/
		.recruitment_item .position_info dl.company_dl dd {
			margin-left: 0;
		}
		/*.position_info dd .dd_top {*/
			/*overflow: hidden;*/
		/*}*/
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
		#posi span{
			margin:0 auto;
		}
		table{
			table-layout: fixed;
		}
		table td>p
	        {
			            white-space: nowrap;
			            overflow: hidden;
		            text-overflow: ellipsis;

	    }
		.job_desc{
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
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
        })
	</script>
@endsection
	@section('content')
		@if(!empty($recruitInfo['list']))
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

				<table align="center" style="width:1200px;margin:0 auto;text-align:center;">
					<tr style="background-color: #ccc;height:30px;">
						<td>职位名称</td>
						<td>工作地点</td>
						<td>职位类别</td>
						<td>部门名称</td>
					</tr>

					@foreach($recruitInfo['list'] as $v)

						<tr style="height:50px;margin-top:20px;width:1200px;line-height:30px;">
							<td><a href="/recruit/list/{{$v['id']}}" style="font-weight: bold;">{{$v['recruit_job']}}</a></td>
							<td>{{$v['recruit_place']}}</td>
							<td>{{$v['job_type']}}</td>
							<td>{{$v['recruit_branch']}}</td>

						</tr>
						<tr><td class="job_desc" colspan="4" style="text-align: left;padding-left: 130px;padding-right: 130px;">{{strip_tags($v['job_desc'])}}</td></tr>
						<tr><td colspan="4" style="border-bottom: 0.1px solid #efeded;margin-top: 13px;padding-top: 12px;"></td></tr>
						{{--<p style="width:1200px;height:2px;color:red;"></p>--}}
					@endforeach
				</table>
				<div style="margin:0 auto;width:1200px;" id="recruit">
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
		<script>
			$(function(){
                paginate();
			})

			function getInfo(currpage,place) {
                $.ajax({
                    url: '/recruit/recruitByCondition',
                    type: 'post',
                    data: {'place':place,'currpage':currpage},
                    success:function (res) {
                        console.log(res);
                        if(res.code == 200){
                            var data = res.data;
                            var currpage = data.currpage;
                            var pageSize = data.pageSize;
                            var total = data.total;
                            var list = data.list;
                            var strHtml = '';
                            for(var i = 0; i < list.length; i++){
                                strHtml += '<section class="recruitment_item wrap_style " data-e="false"><div class="position_info"> <dl class="company_dl"> <dd> <p class="dd_top"> <a class="name" ka="job-godetail1" href="javascript:(0);" target="_blank" style="font-size: 18px;">'+list[i]['recruit_job']+'</a><a href="javascript:(0);" class="city" target="_blank" style="margin-left: 15px;">[工作地点:'+list[i]['recruit_place']+']</a><span class="ud_time" style="margin-left: 20px;color: #aaa;">'+list[i]['add_time']+'发布</span> </p> <div class="dd_bot"> <span class="salary">职位薪资:'+list[i]['recruit_pay']+'</span> <div class="info"> <span>经验:'+list[i]['working_experience']+'</span> <em class="line"></em> <span>学历:'+list[i]['education']+'</span> <em class="line"></em> <span>类型:'+list[i]['recruit_type']+'</span> </div> </div> </dd> </dl> </div> <div class="obligation"> <p>岗位说明：;'+list[i]['job_desc']+'</p> </div> </section>';
                            }
                            $('#recruit').children('section').remove();
                            $('#recruit').prepend(strHtml);
                            layui.use(['laypage'], function() {
                                var laypage = layui.laypage;
                                laypage.render({
                                    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                                    , count: total //数据总数，从服务端得到
                                    , limit: pageSize   //每页显示的条数
                                    , curr: currpage  //当前页
                                    , prev: "上一页"
                                    , next: "下一页"
                                    , theme: "#88be51" //样式
                                    , jump: function (obj, first) {
                                        if (!first) {
//                                            window.location.href='/recruit/list?city='+place+'&currpage='+obj.curr;
                                            getInfo(obj.curr,place);
                                        }
                                    }
                                });
                            });
                        }
                    }
                })
            }

			function getPlace(currpage,obj){
                $(obj).addClass('current').siblings().removeClass('current');
                var place = $(obj).text();
                if(place == ''){
                    return;
                }
                getInfo(currpage,place);

			}

            //分页
            function paginate(){
                layui.use(['laypage'], function() {
                    var laypage = layui.laypage;
                    laypage.render({
                        elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                        , count: "{{$recruitInfo['total']}}" //数据总数，从服务端得到
                        , limit: "{{$pageSize}}"   //每页显示的条数
                        , curr: "{{$currpage}}"  //当前页
                        , prev: "上一页"
                        , next: "下一页"
                        , theme: "#88be51" //样式
                        , jump: function (obj, first) {
                            if (!first) {
//                       getInfo(obj.curr);
                                window.location.href='/recruit/page?currpage='+obj.curr;
                            }
                        }
                    });
                });
            }
		</script>
@endsection
