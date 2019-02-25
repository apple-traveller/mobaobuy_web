<!doctype html>
<html lang="en">
<head>
    <title>会员中心 - @yield('title')</title>
    @include(themePath('.','web').'web.include.partials.base')
    @yield('css')
</head>
<body style="background-color: rgb(244, 244, 244);">
    @include(themePath('.','web').'web.include.partials.top')
    @component(themePath('.','web').'web.include.partials.top_title', ['title_name' => '会员中心'])@endcomponent
    <div class="clearfix mt25 mb25">
        <div class="w1200">
            <div class="member_left">
                @if(session('_curr_deputy_user')['is_self'] && session('_curr_deputy_user')['is_firm'])
                {{--只有企业管理员才能进行企业管理--}}
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-46"></i>{{trans('home.business_manage')}}</h1>
                    <ul class="member_left_list">
                        <li @if(request()->path() == 'createFirmUser') class="curr" @endif><a href="/createFirmUser">{{trans('home.staff_manage')}}</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif

                @if(session('_curr_deputy_user.is_firm') && (session('_curr_deputy_user.is_self') || session('_curr_deputy_user.can_stock_in') || session('_curr_deputy_user.can_stock_out') || session('_curr_deputy_user.can_stock_view')))
                {{--只有企业才能进行库存管理--}}
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-icons_goods"></i>{{trans('home.inventory_manage')}}</h1>
                    <ul class="member_left_list">
                        @if(session('_curr_deputy_user.is_self') || session('_curr_deputy_user.can_stock_in'))
                        <li @if(request()->path() == 'stockIn') class="curr" @endif><a href="/stockIn">{{trans('home.warehousing_manage')}}</a></li>
                        @endif
                        @if(session('_curr_deputy_user.is_self') || session('_curr_deputy_user.can_stock_out'))
                        <li @if(request()->path() == 'stockOut' || request()->path() == 'canStockOut' ) class="curr" @endif><a href="/stockOut">{{trans('home.outgoing_manage')}}</a></li>
                        @endif
                        @if(session('_curr_deputy_user.is_self') || session('_curr_deputy_user.can_stock_view'))
                        <li @if(request()->path() == 'stock/list') class="curr" @endif><a href="/stock/list">{{trans('home.stock_inquiry')}}</a></li>
                        @endif
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif

                @if(
                (session('_curr_deputy_user.is_self') && ((session('_curr_deputy_user.is_firm') && !getConfig('firm_trade_closed')) || (!session('_curr_deputy_user.is_firm') && !getConfig('individual_trade_closed'))))
                || (!session('_curr_deputy_user.is_self') && session('_curr_deputy_user.is_firm') && !getConfig('firm_trade_closed'))
                  )
                        {{--|| (!session('_curr_deputy_user.is_firm') && session('_curr_deputy_user.is_self') && !getConfig('individual_trade_closed'))--}}
                {{-- 代表自己，如果是企业且平台开启了企业交易 或 如果是个人且平台开启了个人交易
                     代表公司，如果用户有平台开启了企业交易
                  --}}
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-svgorder"></i>{{trans('home.order_manage')}}</h1>
                    <ul class="member_left_list">
                        @if(getRealNameBool(session('_web_user_id')))
                            <li @if(request()->path() == 'cart') class="curr" @endif><a href="/cart">{{trans('home.cart')}}</a></li>
                        @endif
                        <li @if(request()->path() == 'order/list') class="curr" @endif><a href="/order/list">{{trans('home.my_order')}}</a></li>

                        {{--<li @if(request()->path() == 'invoice') class="curr" @endif><a href="/invoice">开票申请</a></li>--}}
                            @if(session('_curr_deputy_user.is_self') == 0 && session('_curr_deputy_user.can_invoice') == 0)

                            @else
                                <li @if(request()->path() == 'invoice/myInvoice') class="curr" @endif><a href="/invoice/myInvoice">{{trans('home.my_invoice')}}</a></li>
                                <li @if(request()->path() == 'invoice') class="curr" @endif><a href="/invoice">{{trans('home.invoice_apply')}}</a></li>
                            @endif
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif

                @if(session('_curr_deputy_user.is_self'))
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-userset"></i>{{trans('home.account_management')}}</h1>
                    <ul class="member_left_list">
                        <li @if(request()->path() == 'account/userInfo') class="curr" @endif><a href="/account/userInfo">{{trans('home.user_info')}}</a></li>
                        <li @if(request()->path() == 'account/userRealInfo') class="curr" @endif><a href="/account/userRealInfo">{{trans('home.certification')}}</a></li>
                        <li @if(request()->path() == 'updatePwd') class="curr" @endif><a href="/updatePwd">{{trans('home.change_pwd')}}</a></li>
                        {{--<li @if(request()->path() == 'account/editPayPassword') class="curr" @endif><a href="/account/editPayPassword">支付密码</a></li>--}}
                        <li @if(request()->path() == 'collectGoodsList') class="curr" @endif><a href="/collectGoodsList">{{trans('home.my_collection')}}</a></li>
                        <li @if(request()->path() == 'addressList') class="curr" @endif><a href="/addressList">{{trans('home.shipping_address')}}</a></li>
                        <li @if(request()->path() == 'sale') class="curr" @endif><a href="/sale">{{trans('home.sell_goods')}}</a></li>
                        <li><div class="bottom"></div><div class="line"></div></li>
                    </ul>
                </div>
                @endif
                <div class="member_list_mode">
                    <h1 class=""><i class="iconfont icon-huodong"></i>{{trans('home.activity_center')}}</h1>
                    <ul class="member_left_list">
                        <li @if(request()->path() == 'buyLimit') class="curr" @endif><a href="/buyLimit">{{trans('home.buy_limit')}}</a></li>
                        <li></li>
                    </ul>
                </div>
            </div>

            <div class="member_right">
                <div><h1><i class="iconfont icon-align-left" style="margin-right: 5px;"></i>@yield('title')</h1></div>
                @yield('content')
            </div>
        </div>
    </div>
    @include(themePath('.','web').'web.include.partials.footer_service')
    @include(themePath('.','web').'web.include.partials.footer_new')
    @include(themePath('.','web').'web.include.partials.copyright')
    @yield('js')
</body>
</html>
