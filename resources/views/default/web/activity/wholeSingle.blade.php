<!doctype html>
<html lang="en">
<head>
    <title>{{trans('home.whole_single')}} - {{getSeoInfoByType('wholeSingle')['title']}}</title>
	<meta name="description" content="{{getSeoInfoByType('wholeSingle')['description']}}" />
	<meta name="keywords" content="{{getSeoInfoByType('wholeSingle')['keywords']}}" />
    @include(themePath('.','web').'web.include.partials.base')
    <link rel="stylesheet" href="css/global.css" />
		<script type="text/javascript">
				$(function(){
					function AutoText(obj,height,time){
						var oUl = obj;
						var timer = null;
						$(oUl).hover(function(){
							clearInterval(timer);
						},function(){
							timer = setInterval(function(){
								var field = oUl.find('li:first');
								field.animate(
									{'marginTop':'-'+height+'px'},
									600,
									function(){field.css('marginTop',0).appendTo(oUl);}
									);
							},time);
						}).trigger('mouseleave');
					}					
					AutoText($('.pursh_mar'),60,2500);										
				});
		</script>
    <style type="text/css">
    	
		.logo {
		    width: 170px;
		    height: 55px;
		    margin-top: 20px;
		    float: left;
		    background: url(../img/mobao_logo.png)no-repeat;
		    background-size: 100% 100%;
		}

		.WholeSheet_banner{width:100%;position:relative;background: url(img/WholeSheet_banner.png)no-repeat center;height: 501px;overflow: hidden;}
		.WholeSheet_banner_btn{margin:20px auto;width: 287px;height: 66px;text-align: center;line-height: 66px;background-color: #f4a600;
		font-size: 30px;color: #fff;border-radius: 35px;margin-top: 330px;cursor: pointer;}
		.pursh_text{width:100%;background: rgba(3, 41, 95, 0.6);position: absolute;bottom: 0;height: 60px;line-height: 60px;}
		.pursh_main{width: 1200px;margin: 0 auto;margin-bottom: 70px;}
		.pursh_title{float:left;color:#ffd800;font-size:16px;background: url(img/gouwuche.png)no-repeat 10px 18px;padding-left: 39px;}
		.pursh_content{float: left;}
		.pursh_mar{height: 60px;overflow: hidden;cursor: default;}.pursh_mar li{height: 60px; line-height: 60px;color: #fff;}
		.pursh_mar li span{height: 60px;line-height: 60px; width: 340px;text-align: center;float: left;}
		.delivery_flow{margin-top:50px;height:335px;padding-bottom:50px;border-bottom: 1px solid #DEDEDE;}
		.delivery_flow_bg{height:335px;background: url(img/action/delivery_flow.png)no-repeat center;}
		.advantage{height: 523px;background: url(img/action/advantage.png)no-repeat center;padding-bottom: 50px;
					border-bottom: 1px solid #dedede;}
		.pursh_form_title{width: 620px;margin: 70px auto 60px;height:40px;line-height:40px;background: url(img/action/bianji.png)no-repeat 0px 8px;padding-left: 39px;}
		.pursh_service{cursor:pointer;float: left;color: #75b335;background: url(img/action/kefu.png)no-repeat  8px 5px;box-sizing: border-box;
		height: 26px;    margin-top: 10px;margin-left: 10px;padding-left: 29px;font-size: 14px;line-height: 23px;
		width: 100px; border: 1px solid #75b335;}
		.up_text{width: 100%; height: 30px;border: none;}
		.browse{    float: left; width: 82px; background-color: #75b335; height: 34px; color: #fff;text-align: center;
		line-height: 34px;}
		.updownd{    width: 226px;margin-left: 10px; height: 34px;line-height: 34px; border: 1px solid #dedede;box-sizing: border-box; float: left;}
		.upload{position: relative;float: left;width: 82px;height: 34px;line-height: 34px;background-color: #75b335;text-align: center;color: #fff;margin-left: 20px;}
		.file{width: 572px;margin: 0 auto;height: 34px;line-height: 34px;position: relative;}
		.tip{top: 35px;left: 135px;font-size: 14px;color: #999;position: absolute;}
		.filesc{width: 82px;position: absolute; left: 0;opacity: 0;}
		.textrare{float: left;resize: none;margin-left: 10px;width: 408px; height: 145px; border: 1px solid #dedede;box-sizing: border-box;padding: 10px;}
		.textrare textarea::-webkit-input-placeholder { /* WebKit browsers */　color:#ccc;font-size:16px;}
	　　	.textrare textarea:-moz-placeholder { /* Mozilla Firefox 4 to 18 */color:#ccc;font-size:16px;}
	　　	.textrare textarea::-moz-placeholder { /* Mozilla Firefox 19+ */color:#ccc;font-size:16px;}
	　　	.textrare textarea:-ms-input-placeholder { /* Internet Explorer 10+ */color:#ccc;font-size:16px;}
		.textera_file{width: 572px;margin: 0 auto;overflow: hidden;}
		.pursh_sumbit{background-color: #75b335;width: 259px;height: 50px;line-height: 50px;color: #fff;margin: 0 auto;text-align: center;margin-bottom: 10px;border-radius: 6px;font-size: 23px;margin-top: 35px;box-shadow: 0px 5px 0px #58911e; }
		/*#bill_file{
			background-color:#ccc;
		}*/
		.type-file-box {
			margin-left: 12px;
		}
    </style>
</head>
<body style="background-color: rgb(244, 244, 244);">
    @include(themePath('.','web').'web.include.partials.top')
   
  <!--   <div class="clearfix whitebg mb30">
		<div class="w1200">
			<a class="logo" style="margin-top: 45px;" href="/"></a>
			<div class="fr fs14 order_progress" >
				<div class="cart_progress cart_progress_01"></div>
			</div>

		</div>
	</div> -->


	<div class="WholeSheet">
			<div class="WholeSheet_banner">
				<a href="#pursh_form_title"><div class="WholeSheet_banner_btn">{{trans('home.sub_purchase_require')}}</div></a>
				{{--<div class="pursh_text">--}}
					{{--<div class="pursh_main">--}}
						{{--<div class="pursh_title">整单采购订单：</div>--}}
						{{--<div class="pursh_content">--}}
							{{--<ul class="pursh_mar" id="pursh_mar">--}}
								{{--<li><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span></li>--}}
								{{--<li><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span></li>--}}
								{{--<li><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span></li>--}}
								{{--<li><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span><span>上海市***有限公司已采购51万</span></li>--}}
							{{--</ul>--}}
						{{--</div>--}}
						{{----}}
					{{--</div>--}}
				{{--</div>--}}
			</div>
			<div class="pursh_main">
				<div class="delivery_flow">
					<div class="delivery_flow_bg"></div>
				</div>
				<div class="advantage">
				</div>

				<div class="pursh_form_title" id="pursh_form_title">
					<span class="fs28 fl">{{trans('home.fill_purchase_require')}}：</span>
					<span class="fl" style="color: #333333;padding-top: 2px;font-size: 16px;">{{trans('home.contact_online_sub_require')}}</span>
					<div class="pursh_service">
						<a rel="nofollow" href="javascript:" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');">{{trans('home.online_service')}}</a>
					</div>
				</div>
				<div class="file">
					<span class="tip">{{trans('home.file_format_tips')}}</span>
					<span class="fs16 fl gray"><i class="reds">*</i> {{trans('home.upload_purchase_list')}}：</span>
					<span class="ml10">
						@component('widgets.upload_file',['upload_type'=>'file','upload_path'=>'user/userSingle/','name'=>'bill_file'])@endcomponent
					</span>
					<!-- <div class="updownd"><input type="text" class="up_text"/></div> -->
					<!-- <div class="browse">浏览</div><div class="upload">上传<input type="file" class="filesc"/></div> -->
				</div>
				<div class="textera_file" style="margin-top: 55px;">
					<span class="fs16 fl gray"><i class="reds">*</i> {{trans('home.whole_single_require')}}：</span>
					<textarea name="content" class="textrare" placeholder="{{trans('home.fill_whole_single_require')}}"></textarea>
				</div>
				<div class="pursh_sumbit" onclick="demandSub();" style="cursor:pointer;">{{trans('home.sub')}}</div>
			</div>
		</div>

	

	<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>
	@include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>
<script type="text/javascript">
	function demandSub(){
		var bill_file = $('input[name=bill_file]').val();
		var content = $('textarea[name=content]').val();
		var userId = '{{session('_web_user_id')}}';
		if(userId == '' || userId < 0){
			 layer.confirm('{{trans('home.no_login_msg')}}。', {
                    btn: ['{{trans('home.login')}}','{{trans('home.see_others')}}'] //按钮
                }, function(){
                    window.location.href='/login';
                }, function(){

                });
                return false;
		}
		
		// if(){}
		if($.trim(bill_file) == '' && $.trim(content) == ''){
			alert('{{trans('home.sub_not_empty')}}');
			return;
		}
		$.ajax({
			url:'/wholeSingle/DemandSubmission',
			data:{'bill_file':bill_file,'content':content},
			dataType:'json',
			type:'post',
			success:function(res){
				if (res.code == 1) {
                    $.msg.alert('{{trans('home.sub_purchase_require_success_tips')}}');
                    $('textarea[name=content]').val('');
                    $('input[name=bill_file]').val('');
                } else {
                    $.msg.alert(res.msg);

                }
			}
		})
	}
</script>


