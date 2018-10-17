<!doctype html>
<html lang="en">
<head>
    <title>{{getConfig('shop_name')}}-首页</title>
    @include(themePath('.','web').'web.include.partials.base')
</head>
<body>
@include(themePath('.','web').'web.include.partials.top')
<div>
<ul>
    <li><a href="/member">会员中心</a></li>
        <li><a href="/goodsQuote">报价列表</a></li>
        <li><a href="/goodsList">商品列表</a></li>
</ul>
</div>

@include(themePath('.','web').'web.include.partials.footer_service')
@include(themePath('.','web').'web.include.partials.footer_new')
@include(themePath('.','web').'web.include.partials.copyright')
</body>
</html>