<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
    <style>
        .member_left_list li:last-child {margin-top: 10px}
    </style>
</head>
<body style="background-color: rgb(244, 244, 244);">
@include(themePath('.','web').'web.include.partials.top')
@component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '会员中心'])@endcomponent
<div class="clearfix mt25 mb25">
    <div class="w1200">
        <div class="member_left">
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-46"></i>帮助中心</h1>
                    <ul class="member_left_list">

                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
        </div>

        <div class="member_right">
            <div><h1><i class="iconfont icon-align-left" style="margin-right: 5px;"></i>@yield('title')</h1></div>
            @yield('content')
        </div>

</div>

</div>

<div class="clearfix whitebg ovh mt40" style="font-size: 0;">
</div>
@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
@yield('js')
<script>
    $(function () {
        $.ajax({
            'url': '/helpCenter/sidebar',
            'type':'post',
            success:function (res) {
                if (res.code==1){
                    let cat = '';
                    res.data.map(function (item,index) {
                        if (Object.keys(item).length>0){
                            cat +='<li><a href="/helpCenter.html?id='+item.id+'">'+item.cat_name+'</a></li>';
                        }
                    });
                    $('.member_left_list').append(cat);
                }

            }
        });
    });
</script>
</body>
</html>
