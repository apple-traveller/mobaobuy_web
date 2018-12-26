
<div class="top-search-box clearfix">
    <div class="top-search-div">
        <div class="search-div">
            <div class="logo">
                <a href="/">
                    <img src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}" title="饲料添加剂供应商-饲料原料价格行情-「秣宝」饲料原料采购网" alt="饲料添加剂供应商-饲料原料价格行情-「秣宝」饲料原料采购网">
                </a>
            </div>
            <div class="search-box">
                <form action="/goodsList" method="get">
                    <input type="text" name="keyword" @if(isset($keyword)) value="{{$keyword}}" @endif class="search-input" placeholder="请输入关键词、类别进行搜索"/>
                    <input type="submit" class="opt-btn" value="搜 索"/>
                </form>

                <a rel="nofollow" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');" class="contact_artificial tac br1 db fl ml10">联系人工找货</a>

                @if(!empty(getHotSearch()))
                    <div class="hot_search_m">热门推荐：
                        @foreach(getHotSearch() as $item)
                            <a href="/goodsList?keyword={{$item['search_key']}}" target="_blank">{{$item['search_key']}}</a>
                        @endforeach
                    </div>
                @endif
            </div>
            <a rel="nofollow" class="shopping_cart mt40 tac" href="/cart"><span class="fl ml25"><i class="iconfont icon-gouwuche"></i>我的购物车</span><span id="shopping-amount" class="pro_cart_num">0</span></a>
        </div>
        <div class="clearfix nav-div">
            <div class="nav-cate">
                <div class="cate_title"><span class="ml30">原料分类</span><i class="iconfont icon-menu mr20 fr fs22"></i></div>
                <ul class="ass_menu">
                    @foreach(getCategoryTree() as $k=>$level1_item)
                        @if($k<=5)
                            <li><span class="ass_title" title="{{$level1_item['cat_name']}}">{{$level1_item['cat_name']}}</span>
                                <i class="iconfont icon-right fr mr20"></i>
                                <div class="ass_fn whitebg">
                                    <ul class="ass_fn_list">
                                        @if(isset($level1_item['_child']))
                                            @foreach($level1_item['_child'] as  $level2_item)
                                                <li>
                                                    <h1 class="fn_title fl"><i class="iconfont fr icon-right fr mr20"></i><a class="fr" href="/goodsList?cate_id={{$level2_item['id']}}&cat_name={{$level2_item['cat_name']}}" title="{{$level2_item['cat_name']}}">{{$level2_item['cat_name']}}</a></h1>
                                                    @if(isset($level2_item['_child']))
                                                        <div class="ass_fn_list_that ovh fl">
                                                            @foreach($level2_item['_child'] as $level3_item)
                                                                <span><a href="/goodsList?cate_id={{$level3_item['id']}}&cat_name={{$level3_item['cat_name']}}" title="{{$level3_item['cat_name']}}">{{$level3_item['cat_name']}}</a></span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="nav-menu">
                <ul>
                    <a href="/"><li>首页</li></a>

                    @foreach(getPositionNav('middle') as $item)
                        <a @if($item['is_nofollow']) rel="nofollow" @endif href="{{$item['url']}}"><li>{{$item['name']}}</li></a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {

    var _path_name = window.location.pathname+window.location.search;
    console.log(_path_name);
    //设置高亮
    $('.nav-menu ul a').each(function(){
        var _this_path_name = $(this).attr('href');
        if(_path_name == _this_path_name){
            $(this).addClass('green');
        }else{
            $(this).removeClass('green');
        }
    });


    Ajax.call('/cart/num', '', function (res) {
        $('#shopping-amount').text(res.data.cart_num);
    });

    $('.ass_menu li').hover(function () {
        $(this).find('.ass_fn').show();
    },function () {
        $(this).find('.ass_fn').hide();
    })
});
</script>

