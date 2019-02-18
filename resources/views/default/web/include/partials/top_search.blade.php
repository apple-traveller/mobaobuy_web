
<div class="top-search-box clearfix">
    <div class="top-search-div">
        <div class="search-div">
            <div class="logo">
                <a href="/">
                    <img src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}" title="{{trans('home.header_logo_alt')}}" alt="{{trans('home.header_logo_alt')}}">
                </a>
            </div>
            <div class="search-box">
                <form action="/goodsList" method="get">
                    <input type="text" name="keyword" @if(isset($keyword)) value="{{$keyword}}" @endif class="search-input" placeholder="{{trans('home.header_search_placeholder')}}"/>
                    <input type="submit" class="opt-btn" value="{{trans('home.header_search')}}"/>
                </form>

                <a rel="nofollow" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin={{getConfig('service_qq')}}&site=qq&menu=yes');" class="contact_artificial tac br1 db fl ml10">{{trans('home.header_find_goods')}}</a>

                @if(!empty(getHotSearch()))
                    <div class="hot_search_m">{{trans('home.header_hot')}}：
                        @foreach(getHotSearch() as $item)
                            <a href="/goodsList?keyword={{$item['search_key']}}" target="_blank">{{$item['search_key']}}</a>
                        @endforeach
                    </div>
                @endif
            </div>
            <a rel="nofollow" class="shopping_cart mt40 tac" href="/cart"><span class="fl ml25"><i class="iconfont icon-gouwuche"></i>{{trans('home.header_cart')}}</span><span id="shopping-amount" class="pro_cart_num">0</span></a>
        </div>
        @include(themePath('.','web').'web.include.partials.top_nav')
    </div>
</div>
{{--<script>--}}
{{--$(function() {--}}

    {{--var _path_name = window.location.pathname+window.location.search;--}}
    {{--console.log(_path_name);--}}
    {{--//设置高亮--}}
    {{--$('.nav-menu ul a').each(function(){--}}
        {{--var _this_path_name = $(this).attr('href');--}}
        {{--if(_path_name == _this_path_name){--}}
            {{--$(this).addClass('green');--}}
        {{--}else{--}}
            {{--$(this).removeClass('green');--}}
        {{--}--}}
    {{--});--}}


    {{--Ajax.call('/cart/num', '', function (res) {--}}
        {{--$('#shopping-amount').text(res.data.cart_num);--}}
    {{--});--}}

    {{--$('.ass_menu li').hover(function () {--}}
        {{--$(this).find('.ass_fn').show();--}}
    {{--},function () {--}}
        {{--$(this).find('.ass_fn').hide();--}}
    {{--})--}}
{{--});--}}
{{--</script>--}}

