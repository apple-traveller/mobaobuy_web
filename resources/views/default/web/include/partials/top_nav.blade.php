<style>
    .ass_menu li a{color:#fff; display: block;}.ass_menu li:hover a{color:#333;}
</style>
        <div class="clearfix nav-div">
            <div class="nav-cate">
                <div class="cate_title"><span class="ml30">{{trans('home.header_material_cate')}}</span><i class="iconfont icon-menu mr20 fr fs22"></i></div>
                <ul class="ass_menu">
                    @foreach(getCategoryTree() as $k=>$level1_item)
                        @if($k<=5)
                            <li>
                                <a href="/goodsList?cate_id={{$level1_item['id']}}&cat_name={{$level1_item['cat_name']}}" >
                                    <span class="ass_title" title="{{getLangData($level1_item,'cat_name')}}">{{getLangData($level1_item,'cat_name')}}</span>
                                    <i class="iconfont icon-right fr mr20"></i>
                                </a>

                                <div class="ass_fn whitebg">
                                    <ul class="ass_fn_list">
                                        @if(isset($level1_item['_child']))
                                            @foreach($level1_item['_child'] as  $level2_item)
                                                <li>
                                                    <h1 class="fn_title fl"><i class="iconfont fr icon-right fr mr20"></i><a class="fr" href="/goodsList?cate_id={{$level2_item['id']}}&cat_name={{$level2_item['cat_name']}}" title="{{getLangData($level2_item,'cat_name')}}">{{getLangData($level2_item,'cat_name')}}</a></h1>
                                                    @if(isset($level2_item['_child']))
                                                        <div class="ass_fn_list_that ovh fl">
                                                            @foreach($level2_item['_child'] as $level3_item)
                                                                <span><a href="/goodsList?cate_id={{$level3_item['id']}}&cat_name={{$level3_item['cat_name']}}" title="{{getLangData($level3_item,'cat_name')}}">{{getLangData($level3_item,'cat_name')}}</a></span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(isset(getSpecialGoods()[$level1_item['id']]['goods']) && !empty(getSpecialGoods()[$level1_item['id']]['goods']))
                                            <li>
                                                <h1 class="fn_title fl">
                                                    <i class="iconfont fr icon-right fr mr20"></i>
                                                    <a class="fr" href="#" title="特殊规格">特殊规格</a>
                                                </h1>
                                                <div class="ass_fn_list_that ovh fl">
                                                    @foreach(getSpecialGoods()[$level1_item['id']]['goods']??[] as $v)
                                                        <span><a href="/goods/special/detail/{{$v['id']}}" title="{{$v['goods_name']}}">{{$v['goods_name']}}</a></span>
                                                    @endforeach
                                                </div>
                                            </li>
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
                    <a href="/"><li>{{trans('home.home')}}</li></a>

                    @foreach(getPositionNav('middle') as $item)
                        <a @if($item['is_nofollow']) rel="nofollow" @endif href="{{$item['url']}}"><li>{{getLangData($item, 'name')}}</li></a>
                    @endforeach
                </ul>
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

