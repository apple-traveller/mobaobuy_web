<!doctype html>
<html lang="en">
<head>
    <title>整单采购 - {{getSeoInfoByType('wholeSingle')['title']}}</title>
    <meta name="description" content="{{getSeoInfoByType('wholeSingle')['description']}}" />
    <meta name="keywords" content="{{getSeoInfoByType('wholeSingle')['keywords']}}" />
    @include(themePath('.','web').'web.include.partials.base')
    <link rel="stylesheet" type="text/css" href="https://www.mobaobuy.com/plugs/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="https://www.mobaobuy.com/default/css/quotelist.css" />
    <script src="https://www.mobaobuy.com/plugs/layui/layui.all.js"></script>
</head>

<body>
@include(themePath('.','web').'web.include.partials.top')

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

</style>
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
                        <a href="javascript:void(0)" class="but_login" buy_id="2728375">我要供货</a>
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

            <div class="buy-recent-trading">
                <h3 class="buy-right-release-h3">最近交易</h3>
                <ul class="buy-recent-trading-list">
                     <li>
                        <div class="mtmg"><p class="pr10">采购：瑞邦生物 烟酰胺 100%</p>
                        <p><span class="pr10">价格：<i class="orange">￥9000.00/kg</i></span></p>
                        <p>状态：<i class="orange">正在洽谈</i></p>
                        <p>时间：2018-12-14</p>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
<div class="clearfix whitebg ovh mt40" style="font-size: 0;"></div>
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>
<script>
    $(function(){
        paginate();
        $('.page_subitm').click(function (){
            var data = $("#buyForm").serialize();
            Ajax.call('/demand/add',data,function(res){
                console.log(res.data);
                if (res.code == 1) {
                    $.msg.alert('保存成功');
                    window.location.reload();
                } else {
                    $.msg.alert(res.msg);

                }
            },'POST','JSON');
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
//                        getInfo(obj.curr);
                        window.location.href='/wantBuy?currpage='+obj.curr;
                    }
                }
            });
        });
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
                    for (var i=0;i<list.length;i++)
                    {
                       var _html = '';
                        _html += ' <li><div class="buy-list-text1"> <p class="buy-list-te1"><span class="fs16">求购：'+list[i].goods_name +list[i].num+list[i].unit_name+'</span> <span class="gray">发布时间：'+list[i].add_time+'</span></p> <p class="buy-list-te2 gray">意向价格 : <i class="orange">￥'+list[i].price+'</i><span class="gray">交货地：'+list[i].delivery_area+'</span><span class="gray">交货时间：'+list[i].delivery_time+'</span></p> <p class="buy-list-te3 gray">跟进交易员： <span>'+list[i].contacts+'</span> <span>'+list[i].contacts_mobile+'</span> <a target="_blank" href="http://wpa.qq.com/msgrd?v=1&amp;uin='+list[i].qq+'&amp;site=qq&amp;menu=yes"> <img border="0" src="img/login_qq.gif" alt="点击这里给我发消息" title="点击这里给我发消息"> '+list[i].qq+'</a> </p></div><div class="buy-list-text2"> <a href="javascript:void(0)" class="but_login" buy_id="2728375">我要供货</a></div> </li>';
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
                                    getInfo(obj.curr);
                                }
                            }
                        });
                    });

                }else{
                    $(".buy-list").children('li').remove();
                    $('.page').remove();
                    $(".buy-list").after(' <li class="nodata">无相关数据</li>');
                    $('#relevant_total').text('0');
                }
                console.log(res);return;
            }
        });
    }


</script>


