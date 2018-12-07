<li class="layui-nav-item">
    <a href="javascript:;" data-url="/seller/goods/list" s_id="S010">商品</a>
    <dl class="layui-nav-child">
        <dd  name="/seller/goods/list"> <a href="javascript:;" data-url="/seller/goods/list" s_id="S010">商品列表</a></dd>
    </dl>
</li>
<li class="layui-nav-item">
    <a href="javascript:;" data-url="/seller/order/list" s_id="S020">订单</a>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/order/list" s_id="S020">订单列表</a></dd>
    </dl>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/delivery/list" s_id="S021">发货列表</a></dd>
    </dl>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/invoice/list" s_id="S022">发票管理</a></dd>
    </dl>
</li>
<li class="layui-nav-item">
    <a href="javascript:;" data-url="/seller/quote/list" s_id="S030">报价</a>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/quote/list" s_id="S030">报价列表</a></dd>
    </dl>
</li>
<li class="layui-nav-item">
    <a href="javascript:;" data-url="/seller/detail" s_id="S040">店铺</a>
    <dl class="layui-nav-child">
        <dd><a href="javascript:void(0);" data-url="/seller/detail" s_id="S040">商户资料</a></dd>
        @if($data['is_self_run']==1)
        <dd><a href="javascript:void(0);" data-url="/seller/store" s_id="S041">店铺列表</a></dd>
        @endif
        <dd><a href="javascript:void(0);" data-url="/seller/salesman/list" s_id="S042">业务员</a></dd>
        {{--<dd><a href="javascript:void(0);" data-url="/seller/shopUser" s_id="S042">职员列表</a></dd>--}}
    </dl>
</li>
<li class="layui-nav-item">
    <a href="javascript:;" data-url="/seller/activity/promoter" s_id="S050">活动</a>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/activity/promote" s_id="S050">促销活动</a></dd>
    </dl>
    <dl class="layui-nav-child">
        {{--<dd><a href="javascript:;" data-url="/seller/seckill/list" s_id="S051">秒杀</a></dd>--}}
    </dl>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/activity/wholesale" s_id="S052">集采拼团</a></dd>
    </dl>
    <dl class="layui-nav-child">
        <dd><a href="javascript:;" data-url="/seller/activity/consign" s_id="S053">清仓特卖</a></dd>
    </dl>
</li>
