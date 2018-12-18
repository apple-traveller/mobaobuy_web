@extends(themePath('.','web').'web.include.layouts.home')
@section('title', getSeoInfoByType('consign')['title'])
@section('keywords', getSeoInfoByType('consign')['keywords'])
@section('description', getSeoInfoByType('consign')['description'])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('plugs/layui/css/layui.css')}}" />

<link rel="stylesheet" type="text/css" href="https://www.sumibuy.com/css/global.css"/>
<style>
.look-out{width:1200px;margin:0 auto; overflow:hidden;margin-top:15px;}
.look-out-h3{line-height:25px;height:30px;border-bottom:2px solid #ff6600;font-size:14px;overflow:hidden;clear:both;}
.look-out-h3.ht3{border-bottom:2px solid #f83504;}
.look-out-h3 .tpy{font-size:18px;float:left;padding-right:30px;}
.today-h3 .ht0{float:left;color:#1caaeb;font-size:18px;padding-right:5px;background:#00a0e9;color:#fff;width:50px;text-align: center;}
.look-out-h3 .ht1{float:left;color:#ff6600;font-size:18px;padding-right:5px;}
.look-out-h3 .ht2{float:left;color:#f83504;font-size:18px;padding-right:5px;}
.look-out-h3 span{font-size:14px;background:url(/images/web/sprite.png) no-repeat left -117px; margin-left:10px;height:20px;line-height:20px;padding-left:20px;padding-right:10px;color:#fff;margin-top:4px;float:left;}
.look-out-h3 span.p1{background:url(/images/web/sprite.png) no-repeat left -96px;margin-top:4px;float:left;}

.look-out-h3 a{float:right; font-family:'瀹嬩綋'; font-size:14px;}
.buy-left{width:950px; float:left;}
.buy-form-search{padding:20px;background:#fff;}
.buy-text{border:1px solid #dedede;background:#fff;width:132px;padding:4px 5px;margin:0 10px;margin-right:12px;}
.buy-btn{border:0 none;background:none; background:#ff6600;color:#fff; cursor:pointer;width:70px;height:30px;}
.buy-list{}
.buy-list li{border-bottom:1px solid #f1f1f1;background:#fff;overflow:hidden;clear:both;zoom:1;padding:20px;}
.buy-list-text1{float:left;width:690px;}
.buy-list-te1{padding-bottom:10px;}
.buy-list-te1 .fs16{color:#75b335; font-size:15px; padding-right:10px;}
.buy-list-te2{padding-bottom:10px;}
.buy-list-te2 .gray{padding-left:20px;}
.supply_btn{border:0 none;background:none; background:#349aef;color:#fff; cursor:pointer;width:70px;height:30px;}
.supply_btn:hover{background:#228be2;}
.term_validity{float:right;}


.supply-h3{padding:10px; background:#fff; overflow:hidden; clear:both;zoom:1;border-bottom:2px solid #75b335;}
.supply-text{font-size:16px; float:left;}

.buy-list-text2{float:right;width:130px;height:90px;padding-left:20px;text-align:center;line-height:30px; margin-top:5px;border-left:1px solid #e1e1e1;}
.buy-list-text2 p{ font-size:16px;}
.buy-list-text2 a{color:#fff;padding:5px 30px;display:inline-block;margin-top:5px;font-size:16px;background:#75b335;}
.buy-list-text2 a:hover{ text-decoration:none;}
.buy-right{width:260px;float:right;}
.buy-right-release{ background:#fff;overflow:hidden;padding-bottom:10px;}
.buy-right-release-h3{font-size:16px;border-bottom:2px solid #75b335;padding:10px;}
.brrtextarea{margin-left:10px;margin-top:10px;border:0 none; background:none;width:220px;height:130px;padding:10px;background:#f7f7f7;resize:none;}
.brrtext{margin-top:10px;width:228px;padding:5px; background:#fff;border:1px solid #e1e1e1; margin-left:10px;}
.brrbtn{border:0 none;margin-top:10px;background:none;color:#fff;width:240px;margin-left:10px;background:#75b335;padding:8px 0;}
.buy-recent-trading{margin-top:10px; background:#fff;}
.buy-recent-trading-list li{padding:10px;border-bottom:1px dotted #e1e1e1;line-height:30px; overflow:hidden; clear:both;zoom:1;}
.buy-recent-trading-list li .mtmg{overflow:hidden;clear:both;}

.mui-dialog{padding:6px;width:400px;height:130px;z-index:9999;position:absolute;left:0;top:0;right:0;bottom:0;margin: auto;}
.mui-diglog-wrap{background:#fff;height: 100%; overflow:hidden;position: relative;z-index:2; box-shadow: 1px 1px 7px rgba(129, 129, 129, 0.29);}
.mui-dialog-body{ position:relative;}
.mui-dialog-header{background:#e6e6e6;font-size:14px;color: #666;line-height:35px;height:35px;padding-left:10px; font-weight: bold;}
.brandMsgTips{padding:10px;font-size:14px;color:#666;}
.brandMsgTips-p{margin-top:10px;}
.mui-dialog-skin{background:#000;width:100%;height:100%;left:0;opacity:0.2;filter:alpha(opacity=20);position:absolute;top:0;}
.mui-dialog-mask{height:100%;left:0;position:fixed;top:0;width:100%;z-index:9999;background:#000;opacity: 0.6;filter:alpha(opacity=30);}
.overlay-close {  z-index: 3;  background: url(/images/tmclose.png) no-repeat 0 0;  width: 16px;  height: 16px;  position: absolute;  right: 16px;  top: 16px;  display: block;  outline: medium none;  }
a.overlay-close:hover{background:url(/images/tmclose.png) no-repeat -16px 0;}
.qg_text{line-height:30px;}
.input-text4 { border: 1px solid #ddd;  line-height: 22px;  width: 91px;padding: 5px;  }
.qg_text span{color:#ff6600;}
.qg_textarea{ resize:none;border:1px solid #dedede;width:275px;height:80px;padding:5px;margin-top:5px;}
.qg_textarea1{ resize:none;border:1px solid #dedede;width:405px;height:80px;padding:5px;margin-top:5px;}
.qg_btn{border:0 none;background:none;background:#1caaeb;color:#fff;width:287px;height:34px; cursor:pointer;margin-left:70px;}
.ad_btn{border:0 none;background:none;background:#1caaeb;color:#fff;width:120px;height:34px; cursor:pointer;margin-left:12px;}
.cancel_btn{background:#c0bdbd;}
.close_btn{background:#c0bdbd;}
.buy_btn{padding-top:10px;}
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
@section('content')
<div class="look-out">

        <div class="buy-left" style="width: 930px;">
            <h3 class="supply-h3"><i class="supply-text">求购列表</i>

                <p class="fr">搜索：<i class="red"></i> 共搜到 <i class="orange" id="relevant_total">{{$inquireList['total']}}</i>条数据
                </p></h3>

            <div class="buy-form-search">
                <form action="" method="get">
                    分类<input class="buy-text" name="cate_name" type="text" value="" style="width: 125px;">
                    商品名称<input class="buy-text" name="goods_name" type="text" value="" style="width: 125px;">
                    厂商<input class="buy-text" name="brand_name" type="text" value="" style="width: 125px;">
                    交货地<input class="buy-text" name="delivery_area" type="text" value="" style="width: 125px;">
                    <input class="buy-btn" type="button" onclick="getInfo(1)" value="搜 索">
                </form>
            </div>

            <ul class="buy-list">
                @if(!empty($inquireList))
                @foreach($inquireList['list'] as $v)
                        {{--{{$v['unit_name']}}--}}
                <li>
                    <div class="buy-list-text1">
                        <p class="buy-list-te1"><span class="fs16">求购：{{$v['goods_name']}} {{$v['num']}}{{$v['unit_name']}}</span>
                            <span class="gray">发布时间：{{ \Carbon\Carbon::parse($v['add_time'])->diffForHumans()}}</span></p>
                        <p class="buy-list-te2 gray">意向价格 : <i class="orange">￥{{$v['price']}}</i><span class="gray">交货地：{{$v['delivery_area']}}</span><span class="gray">交货时间：{{$v['delivery_time']}}</span></p>
                        <p class="buy-list-te3 gray">跟进交易员：
                         <span>{{$v['contacts']}}</span>
                          <span>{{$v['contacts_mobile']}}</span>
                           <a target="_blank" href="http://wpa.qq.com/msgrd?v=1&amp;uin={{$v['qq']}}&amp;site=qq&amp;menu=yes">
                                <img border="0" src="img/login_qq.gif" alt="点击这里给我发消息" title="点击这里给我发消息"> {{$v['qq']}}
                            </a>
                            </p>
                    </div>
                     <div class="buy-list-text2">
                        {{--<p>正在洽谈</p>--}}
                        <a href="javascript:void(0)" class="but_login" buy_id="{{$v['id']}}">我要供货</a>
                     </div>
                </li>
                @endforeach
                @endif
            </ul>

            <div class="page" style="background:#fff; padding: 35px 0px;">
                <div class="link">
                    <div class="news_pages" style="margin-top: 20px;text-align: center;">
                        <ul id="page" class="pagination"></ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="buy-right">
            <div class="buy-right-release">
                <h3 class="buy-right-release-h3">免费找货</h3>
                <form action="" method="post" id="buyForm" enctype="multipart/form-data">
                    <textarea class="brrtextarea product_code" id="content" name="content" placeholder="写下您的真实需求，包括品种、厂商、规格等，收到后我们会立即给您回电确认，我们会尽快帮您找货"></textarea>
                    @if(empty(session('_web_user_id')))
                        <input class="brrtext mobile" type="text" id="mobile" name="contact" maxlength="11" placeholder="请输入手机号码">
                    @endif
                    <input class="brrbtn cp f_buy page_subitm" type="text" style="text-align:center;" value="立即发布">
                </form>
            </div>

            {{--<div class="buy-recent-trading">--}}
                {{--<h3 class="buy-right-release-h3">最近交易</h3>--}}
                {{--<ul class="buy-recent-trading-list">--}}
                     {{--<li>--}}
                        {{--<div class="mtmg"><p class="pr10">采购：瑞邦生物 烟酰胺 100%</p>--}}
                        {{--<p><span class="pr10">价格：<i class="orange">￥9000.00/kg</i></span></p>--}}
                        {{--<p>状态：<i class="orange">正在洽谈</i></p>--}}
                        {{--<p>时间：2018-12-14</p>--}}
                        {{--</div>--}}

                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>

<script src="http://mbbweb.com/plugs/layui/layui.all.js"></script>
<script>

    $(function(){
        paginate();

        //发布需求
        $('.page_subitm').click(function (){
            var messages = $("textarea[name=content]").val();
            if (messages == '' || messages == '写下您的真实需求，包括厂商、牌号等，收到后我们会立即给您回电确认，我们会尽快帮您找货') {
                $.msg.alert("请填写您的内容！");
                return false;
            }
            var data = $("#buyForm").serialize();
            Ajax.call('/demand/add',data,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.alert('恭喜发布成功，客服人员会在第一时间与您电话联系，请保持手机畅通');
                    window.location.reload();
                } else {
                    $.msg.alert(res.msg);

                }
            },'POST','JSON');
        });

        //点击我要供货
        $("ul").on("click",'.but_login',function() {
            var userId = "{{session('_web_user_id')}}";
            var buy_id = $(this).attr('buy_id');
            if (userId == "") {
                layer.confirm('请先登录再进行操作。', {
                    btn: ['去登陆', '再看看'] //按钮
                }, function () {
                    window.location.href = '/login';
                }, function () {

                });
                return false;
            }
            quote(buy_id);

        })

        function quote(buy_id){
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/buy/asingle',
                data: {buy_id: buy_id},
                type: 'POST',
                success: function (data) {
                    if (data.code == 1) {
//                        console.log(data);return;
                        var row = data.data;
                        var html = "<div class=\"mui-dialog-mask remove\" ></div>";
                        html += "<div class=\"mui-dialog remove\" style=\'width:500px; height: 350px; left:50%; top:50%;margin-top:-150px;position:fixed;margin-left:-250px; \' >";
                        html += "<a href=\"javascript:void(0)\" class=\"overlay-close\" onclick=\"removeLayer();\"></a>";
                        html += "<div class=\"mui-diglog-wrap\">";
                        html += "<div class=\"mui-dialog-header\">我要报价</div>";
                        html += "<div class=\"mui-dialog-body\">";
                        html += "<div class=\"brandMsgTips\" style='margin: 5px 15px; padding: 0px;'>";
                        html += "<div class=\"lh30 gray\">请在下方填写您的真实报价（价格必填），并对您的货物描述清楚。</div>";
                        html += "<form action='/buy/quote.html' method='post'>";
                        html += " <input type=\"hidden\" name=\"buy_id\"  value=\"" + buy_id + "\">";
                        html += "<div class=\"qg_text mb10\">求购：<span>"  + row['goods_name'] + ' '  + row.num + row.unit_name +' $' + row.price + ' ' + row.delivery_area + "</span></div>";
                        html += "<div>价格：<input type\"text\" class=\"input-text4 mr5\" value=" + row.price + " name=\"price\">";
                        html += "数量：<input type=\"text\" class=\"input-text4 mr5\" value=" + row.num + " name=\"num\">";
                        html += "交货地：<input type=\"text\" class=\"input-text4 mr5\" value='" + row.delivery_area + "' name=\"deliveryarea\">";
                        html += "</div>";
                        html += "<div style=\'line-height: 22px;\'>";
                        html += "<span class='fl'>备注：</span><textarea  class=\"qg_textarea1\" name=\"content\" id=\"contents\"></textarea>";
                        html += "</div>";
                        html += "<div class=\"buy_btn\" style='padding-top:5px;'><span id=\"error\" class=\"gray\" style='padding-left:42px;padding-bottom:10px;display: block;'>不合理报价会被系统自动屏蔽</span><input class=\"qg_btn but_buy_save\" type='submit' value='提交' style='margin-left:42px;'></div>";
                        html += "<div class='quote_msg red'></div>";
                        html += "</form>";
                        html += "</div>";
                        html += "</div>";
                        html += "</div>";
                        html += "<div class=\"mui-dialog-skin\"></div>";
                        html += "</div>";
                        $("body").append(html);
                    }
                },
                dataType: 'json'
            });
        }

        $(document).delegate(".but_buy_save", "click", function (event) {
            event.preventDefault();
            var buy_id = $('input[name=buy_id]').val();
            var price = $('input[name=price]').val();
            var num = $('input[name=num]').val();
            var delivery_area = $('input[name=deliveryarea]').val();
            var contents = $('#contents').val();

            if(buy_id == ''){
                $.msg.alert('信息有误，请重试');
                return;
            }

            if (price == '') {
                $.msg.alert("请输入价格");
                return;
            }
            if (num == '') {
                $.msg.alert("请输入数量");
                return;
            }
            if (delivery_area == '') {
                $.msg.alert("请输入交货地");
                return;
            }

            $.ajax({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/buy/savebuy',
                data: {buy_id: buy_id, price: price, num: num, delivery_area: delivery_area,remark:contents},
                type: 'POST',
                success: function (data) {
                    if (data.code == 1) {
                        $.msg.alert('报价提交成功');
                        window.location.reload()
                    } else {
                        $.msg.alert(data.msg);
                    }
                },
                dataType: 'json'
            });
        });


        })

    //分页
    function paginate(){
        layui.use(['laypage'], function() {
            var laypage = layui.laypage;
            laypage.render({
                elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
                , count: "{{$inquireList['total']}}" //数据总数，从服务端得到
                , limit: "{{$pageSize}}"   //每页显示的条数
                , curr: "{{$currpage}}"  //当前页
                , prev: "上一页"
                , next: "下一页"
                , theme: "#88be51" //样式
                , jump: function (obj, first) {
                    if (!first) {
//                       getInfo(obj.curr);

                        window.location.href='/wantBuy?currpage='+obj.curr;
                    }
                }
            });
        });
    }

    function removeLayer(){
        $('.mui-dialog').remove();
        $('.mui-dialog-mask').remove();
        return;
    }


    //请求ajax获取列表数据
    function getInfo(currpage){
        var _brand_name = $('input[name=brand_name]').val();
        var _cate_id = $('input[name=cat_name]').val();
        var _goods_name = $('input[name=goods_name]').val();
        var _delivery_area = $('input[name=delivery_area]').val();

        $.ajax({
            type: "get",
            url: "/condition/toBuyList",
            data: {
                'currpage':currpage,
                'brand_name':_brand_name,
                'cate_id':_cate_id,
                'goods_name':_goods_name,
                'delivery_area':_delivery_area
            },
            dataType: "json",
            success: function(res){
                if(res.code==200) {

                    var data = res.data;
                    var currpage = data.currpage;
                    var pageSize = data.pageSize;
                    var total = data.total;
                    var list = data.list;

                    $(".buy-list").children('li').remove();
                    var _html = '';
                    for (var i=0;i<list.length;i++)
                    {
                        _html += ' <li><div class="buy-list-text1"> <p class="buy-list-te1"><span class="fs16">求购：'+list[i].goods_name +list[i].num+list[i].unit_name+'</span> <span class="gray">发布时间：'+list[i].add_time+'</span></p> <p class="buy-list-te2 gray">意向价格 : <i class="orange">￥'+list[i].price+'</i><span class="gray">交货地：'+list[i].delivery_area+'</span><span class="gray">交货时间：'+list[i].delivery_time+'</span></p> <p class="buy-list-te3 gray">跟进交易员： <span>'+list[i].contacts+'</span> <span>'+list[i].contacts_mobile+'</span> <a target="_blank" href="http://wpa.qq.com/msgrd?v=1&amp;uin='+list[i].qq+'&amp;site=qq&amp;menu=yes"> <img border="0" src="img/login_qq.gif" alt="点击这里给我发消息" title="点击这里给我发消息"> '+list[i].qq+'</a> </p></div><div class="buy-list-text2"> <a href="javascript:void(0)" class="but_login" buy_id="'+list[i].id+'">我要供货</a></div> </li>';
                    }
                    $(".buy-list").append(_html);
//                    $(".news_pages").append('<ul id="page" class="pagination"></ul>');
                    $('#relevant_total').text(total);

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
//                                    window.location.href='/wantBuy?currpage='+obj.curr;
                                    getInfo(obj.curr);
                                }
                            }
                        });
                    });

                }else{
                    $(".buy-list").children('li').remove();
                    $('.page').remove();
                    $(".buy-list").nextAll().remove();
                    $(".buy-list").after(' <li class="nodata">无相关数据</li>');

                    $('#relevant_total').text('0');
                }
                console.log(res);return;
            }
        });
    }


</script>
@endsection


