@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">管理中心</div>
        <div class="content start_content">
           {{-- <div class="contentWarp">
                <div class="explanation" id="explanation">
                    <div class="ex_tit"><h4>系统检测到您有影响商城运营的基本配置信息尚未配置：</h4></div>
                    <div class="ex_con">
                        <span>短信配置尚未配置，<a href="sms_setting.php?act=step_up">前往配置</a></span>
                        <span>邮件配置尚未配置，<a href="shop_config.php?act=mail_settings">前往配置</a></span>
                        <span>阿里OSS尚未配置，<a href="oss_configure.php?act=list">前往配置</a></span>
                    </div>
                </div>
            </div>--}}
            <div class="contentWarp">
                <div class="contentWarp_item clearfix">
                    <div class="section_select">
                        <div class="item item_price">
                            <i class="icon"><img src="/default/images/1.png" width="71" height="74"></i>
                            <div class="desc">
                                <div class="tit"><!----><em>¥</em>{{$totalAccount}}<!----></div>
                                <span>今日销售总额</span>
                            </div>
                        </div>
                        <div class="item item_order">
                            <i class="icon"><img src="/default/images/2.png"></i>
                            <div class="desc">
                                <div class="tit">{{$orderCount}}</div>
                                <span>今日订单总数</span>
                            </div>
                            <i class="icon"></i>
                        </div>
                        <div class="item item_comment">
                            <i class="icon"><img src="/default/images/3.png" width="90" height="86"></i>
                            <div class="desc">
                                <div class="tit">{{$quoteCount}}</div>
                                <span>今日报价条数</span>
                            </div>
                        </div>
                        <div class="item item_flow">
                            <i class="icon"><img src="/default/images/4.png" width="86"></i>
                            <div class="desc">
                                <div class="tit">{{$shopCount}}</div>
                                <span>店铺数量</span>
                            </div>
                            <i class="icon"></i>
                        </div>
                    </div>
                    <div class="section user_section">
                        <div class="sc_title">
                            <i class="sc_icon"></i>
                            <h3>个人会员信息</h3>
                            <cite>（单位：个）</cite>
                        </div>
                        <div class="sc_warp">
                            <div class="user_item user_today_new">
                                <div class="num">{{$users['is_personal']}}</div>
                                <span class="tit">个人会员</span>
                            </div>
                            <div class="user_item user_yest_new">
                                <div class="num">{{$users['is_firm']}}</div>
                                <span class="tit">企业会员</span>
                            </div>
                            <div class="user_item user_month_new">
                                <div class="num">{{$users['no_verify']}}</div>
                                <span class="tit">待审核</span>
                            </div>
                            <div class="user_item user_total">
                                <div class="num">{{$users['total']}}</div>
                                <span class="tit">会员总数</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="contentWarp_item clearfix">
                    <div class="section_order_select">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;seller_list=0&amp;serch_type=0" data-param="menushopping|02_order_list" ectype="iframeHref">
                                    <i class="ice ice_w"></i>
                                    <div class="t">未确认订单</div>
                                    <span class="number">{{$orders['weiqueren']}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;seller_list=0&amp;serch_type=1" data-param="menushopping|02_order_list" ectype="iframeHref">
                                    <i class="ice ice_d"></i>
                                    <div class="t">待支付订单</div>
                                    <span class="number">{{$orders['daizhifu']}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;seller_list=0&amp;serch_type=8" data-param="menushopping|02_order_list" ectype="iframeHref">
                                    <i class="ice ice_n"></i>
                                    <div class="t">待发货订单</div>
                                    <span class="number">{{$orders['daifahuo']}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;seller_list=0&amp;serch_type=3" data-param="menushopping|02_order_list" ectype="iframeHref">
                                    <i class="ice ice_f"></i>
                                    <div class="t">已成交订单数</div>
                                    <span class="number">{{$orders['yichengjiao']}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;composite_status=6&amp;source=start" data-param="menushopping|02_order_list" ectype="iframeHref">
                                    <i class="ice ice_q"></i>
                                    <div class="t">部分发货订单</div>
                                    <span class="number">{{$orders['bufenfahuo']}}</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div class="section section_order_count">
                        <div class="sc_title">
                            <i class="sc_icon"></i>
                            <h3>订单统计</h3>
                            <div class="filter_date">
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'order', 'week')" class="active">七天</a>
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'order', 'month')">一月</a>
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'order', 'year')">半年</a>
                            </div>
                        </div>
                        <div class="sc_warp">
                            <div id="order_main" style="height: 274px; -webkit-tap-highlight-color: transparent; user-select: none; background-color: rgba(0, 0, 0, 0);" _echarts_instance_="1541561098082"><div style="position: relative; overflow: hidden; width: 1212px; height: 274px;"><div data-zr-dom-id="bg" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none;"></div><canvas width="1212" height="274" data-zr-dom-id="0" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="1212" height="274" data-zr-dom-id="1" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="1212" height="274" data-zr-dom-id="_zrender_hover_" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas></div></div>
                        </div>
                    </div>
                    <div class="section section_total_count">
                        <div class="sc_title">
                            <i class="sc_icon"></i>
                            <h3>销售统计</h3>
                            <div class="filter_date">
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'sale', 'week')" class="active">七天</a>
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'sale', 'month')">一月</a>
                                <a href="javascript:;" onclick="set_statistical_chart(this, 'sale', 'year')">半年</a>
                            </div>
                        </div>
                        <div class="sc_warp">
                            <div id="total_main" style="height: 274px; -webkit-tap-highlight-color: transparent; user-select: none; background-color: rgba(0, 0, 0, 0);" _echarts_instance_="1541561098083"><div style="position: relative; overflow: hidden; width: 1212px; height: 274px;"><div data-zr-dom-id="bg" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none;"></div><canvas width="1212" height="274" data-zr-dom-id="0" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="1212" height="274" data-zr-dom-id="1" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas><canvas width="1212" height="274" data-zr-dom-id="_zrender_hover_" class="zr-element" style="position: absolute; left: 0px; top: 0px; width: 1212px; height: 274px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contentWarp bf100">
                <div class="section col_section">
                    <div class="sc_title">
                        <i class="sc_icon"></i>
                        <h3>控制面板</h3>
                    </div>
                    <div class="sc_warp">
                        <div class="item_section item_section_frist">
                            <div class="section_header">商城管理</div>
                            <div class="section_body">
                                <dl>
                                    <dt>商城首页：</dt>
                                    <dd><a href="http://192.168.40.14:3731/" target="_blank">http://192.168.40.14:3731/</a></dd>
                                </dl>
                                <dl>
                                    <dt>平台后台：</dt>
                                    <dd><a href="http://192.168.40.14:3731/admin" target="_blank">http://192.168.40.14:3731/admin</a></dd>
                                </dl>
                                <dl>
                                    <dt>商家后台：</dt>
                                    <dd><a href="http://192.168.40.14:3731/seller" target="_blank">http://192.168.40.14:3731/seller</a></dd>
                                </dl>
                                <dl>
                                    <dt>门店后台：</dt>
                                    <dd><a href="http://192.168.40.14:3731/stores" target="_blank">http://192.168.40.14:3731/stores</a></dd>
                                </dl>
                                <dl>
                                    <dt>WAP首页：</dt>
                                    <dd><a href="http://192.168.40.14:3731/mobile" target="_blank">http://192.168.40.14:3731/mobile</a></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="item_section">
                            <div class="section_header">客户服务</div>
                            <div class="section_body">
                                <dl>
                                    <dt>客服电话：</dt>
                                    <dd>4001-021-758</dd>
                                </dl>
                                <dl>
                                    <dt>客服QQ号码：</dt>
                                    <dd><a href="http://crm2.qq.com/page/portalpage/wpa.php?uin=800007167&amp;aty=0&amp;a=0&amp;curl=&amp;ty=1" target="_blank">800007167</a></dd>
                                </dl>
                                <dl>
                                    <dt>问答社区：</dt>
                                    <dd><a href="http://wenda.ecmoban.com" target="_blank">http://wenda.ecmoban.com</a></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contentWarp">
                <div class="section system_section w190">
                    <div class="system_section_con">
                        <div class="sc_title">
                            <h3>系统信息</h3>
                        </div>
                        <div class="sc_warp" style="display: block;width: 1100px;">
                            <table cellpadding="0" cellspacing="0" class="system_table">
                                <tbody><tr>
                                    <td class="gray_bg">服务器操作系统:</td>
                                    <td>Linux (192.168.40.14)</td>
                                    <td class="gray_bg">Web 服务器:</td>
                                    <td>nginx/1.9.1</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">PHP 版本:</td>
                                    <td>5.6.33</td>
                                    <td class="gray_bg">MySQL 版本:</td>
                                    <td>5.6.24-log</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">安全模式:</td>
                                    <td>否</td>
                                    <td class="gray_bg">安全模式GID:</td>
                                    <td>否</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">Socket 支持:</td>
                                    <td>是</td>
                                    <td class="gray_bg">时区设置:</td>
                                    <td>Asia/Shanghai</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">GD 版本:</td>
                                    <td>GD2 ( JPEG GIF PNG)</td>
                                    <td class="gray_bg">Zlib 支持:</td>
                                    <td>是</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">IP 库版本:</td>
                                    <td>20071024</td>
                                    <td class="gray_bg">文件上传的最大大小:</td>
                                    <td>50M</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">程序版本:</td>
                                    <td>v2.7.1 RELEASE 20180712 <a href="upgrade.php?act=index">[在线升级]</a></td>
                                    <td class="gray_bg">安装日期:</td>
                                    <td>2018-08-05</td>
                                </tr>
                                <tr>
                                    <td class="gray_bg">编码:</td>
                                    <td>UTF-8</td>
                                    <td class="gray_bg"></td>
                                    <td></td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop