<div class="admin-header clearfix" style="min-width:1280px;">
    <div class="bgSelector"></div>
    <div class="admin-logo">
        <a href="/admin/home"  data-param="home" target="workspace">
            <img style="max-height: 40px" src="{{getFileUrl(getConfig('shop_logo', asset('images/logo.png')))}}">
        </a>
        <div class="foldsider"><i class="icon icon-indent-right"></i></div>
    </div>
    <div class="module-menu">
        <ul>
            <li data-param="menuplatform"><a href="javascript:void(0);">平台</a></li>
            <li data-param="menushopping"><a href="javascript:void(0);">商城</a></li>
        {{--    <li data-param="finance"><a href="javascript:void(0);">财务</a></li>
            <li data-param="third_party"><a href="javascript:void(0);">第三方服务</a></li>--}}
        </ul>
    </div>
    <div class="admin-header-right">
        <div class="manager">
            <dl>
                <dt class="name">{{session('_admin_user_info')['user_name']}}</dt>
                <dd class="group">{{session('_admin_user_info')['real_name']}}</dd>
            </dl>
            <span class="avatar">
				<form action="index.php" id="fileForm" method="post" enctype="multipart/form-data">
					<input name="img" type="file" class="admin-avatar-file" id="_pic" title="设置管理员头像">
				</form>
				<img nctype="admin_avatar" src="{{getFileUrl(getNotEmptyValue(session('_admin_user_info'),'avatar',asset('images/admin.png')))}}">
			</span>
            <div id="admin-manager-btn" class="admin-manager-btn"><i class="arrow"></i></div>
            <div class="manager-menu">
                <div class="title">
                    <h4>最后登录</h4>
                    <a href="privilege.php?act=edit&amp;id=60" target="workspace" class="edit_pwd">修改密码</a>
                </div>
                <div class="login-date">
                    <strong>{{session('_admin_user_info')['last_time']}}</strong>
                    <span>(IP:{{getNotEmptyValue(session('_admin_user_info'),'last_ip','0.0.0.0')}})</span>
                </div>
                <div class="title mt10">
                    <h4>常用操作</h4>
                    <a href="javascript:;" class="add_nav">添加菜单</a>
                </div>
                <div class="quick_link">
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        <div class="operate">
            <li style="position: relative;" ectype="oper_msg">
                <a href="javascript:void(0);" class="msg" title="查看消息">&nbsp;</a><s id="total">17</s>
                <div id="msg_Container">
                    <div class="item">
                        <h3 class="order_msg" ectype="msg_tit">订单提示<em class="iconfont icon-up"></em></h3><s id="total">0</s>
                        <div class="msg_content" ectype="orderMsg" style="display:block;">
                            <p>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;composite_status=106" data-param="menushopping|02_order_list" target="workspace" class="message">您有新订单</a>
                                <span class="tiptool">（<em id="new_orders">0</em>）</span>
                            </p>
                            <p>
                                <a href="javascript:void(0);" data-url="order.php?act=list&amp;composite_status=101&amp;source=start" data-param="menushopping|02_order_list" target="workspace" class="message">待发货订单</a>
                                <span class="tiptool">（<em id="no_paid">0</em>）</span>
                            </p>

                        </div>
                    </div>



                    <div class="item">
                        <h3 class="shop_msg" ectype="msg_tit">商家审核提示<em class="iconfont icon-down"></em></h3><s id="total">15</s>
                        <div class="msg_content" ectype="sellerMsg"><p><a href="javascript:void(0);" data-url="merchants_users_list.php?act=list&amp;check=1" data-param="menushopping|02_merchants_users_list" target="workspace" class="message">未审核商家</a> <span class="tiptool">（<em id="shop_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="merchants_users_list.php?act=list&amp;shopinfo_check=1" data-param="menushopping|02_merchants_users_list" target="workspace" class="message">未审核店铺信息</a> <span class="tiptool">（<em id="shopinfo_account">15</em>）</span></p><p><a href="javascript:void(0);" data-url="merchants_account.php?act=list&amp;act_type=account_log&amp;handler=2&amp;rawals=1" data-param="menushopping|12_seller_account" target="workspace" class="message">待审核商家提现</a> <span class="tiptool">（<em id="wait_cash">0</em>）</span></p><p><a href="javascript:void(0);" data-url="user_real.php?act=list&amp;review_status=0&amp;user_type=1" data-param="menushopping|16_users_real" target="workspace" class="message">待审核商家实名认证</a> <span class="tiptool">（<em id="seller_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="merchants_account.php?act=list&amp;act_type=detail&amp;log_type=2" data-param="menushopping|12_seller_account" target="workspace" class="message">待审核商家结算</a> <span class="tiptool">（<em id="seller_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="merchants_account.php?act=list&amp;act_type=detail&amp;log_type=3" data-param="menushopping|12_seller_account" target="workspace" class="message">待审核商家充值</a> <span class="tiptool">（<em id="seller_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="seller_apply.php?act=list" data-param="menushopping|02_merchants_users_list" target="workspace" class="message">待审核店铺等级</a> <span class="tiptool">（<em id="seller_account">0</em>）</span></p></div>
                    </div>

                    <div class="item">
                        <h3 class="ad_msg" ectype="msg_tit">广告位提示<em class="iconfont icon-down"></em></h3><s id="total">0</s>
                        <div class="msg_content" ectype="advMsg"><p><a href="javascript:void(0);" data-url="ads.php?act=list&amp;advance_date=1" data-param="menuplatform|ad_list" target="workspace" class="message">广告位即将到期</a> <span class="tiptool">（<em id="advance_date">0</em>）</span></p></div>
                    </div>

                    <div class="item">
                        <h3 class="user_msg" ectype="msg_tit">会员提醒<em class="iconfont icon-down"></em></h3><s id="total">0</s>
                        <div class="msg_content" ectype="userMsg"><p><a href="javascript:void(0);" data-url="user_real.php?act=list&amp;review_status=0&amp;user_type=0" data-param="menuplatform|03_users_list" target="workspace" class="message">会员实名认证</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="user_account.php?act=list&amp;process_type=0&amp;is_paid=0" data-param="menuplatform|09_user_account" target="workspace" class="message">会员充值申请</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="user_account.php?act=list&amp;process_type=1&amp;is_paid=0" data-param="menuplatform|09_user_account" target="workspace" class="message">会员提现申请</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="user_vat.php?act=list&amp;audit_status=0" data-param="menuplatform|15_user_vat_info" target="workspace" class="message">会员增票资质审核</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p></div>
                    </div>

                    <div class="item">
                        <h3 class="campaign_msg" ectype="msg_tit">活动提醒<em class="iconfont icon-down"></em></h3><s id="total">0</s>
                        <div class="msg_content" ectype="promotionMsg"><p><a href="javascript:void(0);" data-url="snatch.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|02_snatch_list" target="workspace" class="message">夺宝奇兵</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="bonus.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|04_bonustype_list" target="workspace" class="message">红包类型</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="group_buy.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|08_group_buy" target="workspace" class="message">团购活动</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="topic.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|09_topic" target="workspace" class="message">专题</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="auction.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|10_auction" target="workspace" class="message">拍卖活动</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="favourable.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|12_favourable" target="workspace" class="message">优惠活动</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="presale.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|16_presale" target="workspace" class="message">预售活动</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="package.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|14_package_list" target="workspace" class="message">超值礼包</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="exchange_goods.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|15_exchange_goods" target="workspace" class="message">积分商品</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="coupons.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|17_coupons" target="workspace" class="message">优惠券</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="gift_gard.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|gift_gard_list" target="workspace" class="message">礼品卡</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p><p><a href="javascript:void(0);" data-url="wholesale.php?act=list&amp;seller_list=1&amp;review_status=1" data-param="menushopping|13_wholesale" target="workspace" class="message">批发</a> <span class="tiptool">（<em id="user_account">0</em>）</span></p></div>
                    </div>
                </div>
            </li>
            <i></i>
            <li><a href="{{asset('')}}" target="_blank" class="home" title="新窗口打开商城首页">&nbsp;</a></li>
            <i></i>
            <li><a href="{{asset('admin/clear')}}" class="clear" target="workspace" title="清除缓存">&nbsp;</a></li>
            <i></i>
            <li><a href="javascript:void(0);" class="prompt" id="out"  title="安全退出管理中心">&nbsp;</a></li>
        </div>
    </div>
</div>
<script>
    $("#out").click(function(){
        window.location.href="/admin/logout";
    });

    window.onload=function(){
        let order_waitAffirm = 0; //待商家确认
        let order_waitSend = 0;//待发货
        //获取各订单状态的数量
        $.ajax({
            url: "/admin/orderinfo/delivery/getOrderStatusCount",
            dataType: "json",
            data:{},
            type:"POST",
            success:function(res){
                if(res.code==200){
                    order_waitAffirm = res.data.waitAffirm;
                    order_waitSend = res.data.waitSend;
                    $("#new_orders").text(order_waitAffirm);
                    $("#no_paid").text(order_waitSend);
                }else{

                }
            }
        });
        //获取待审核商家的数量
        $.ajax({
            url: "/admin/orderinfo/delivery/getOrderStatusCount",
            dataType: "json",
            data:{},
            type:"POST",
            success:function(res){
                if(res.code==200){
                    order_waitAffirm = res.data.waitAffirm;
                    order_waitSend = res.data.waitSend;
                    $("#new_orders").text(order_waitAffirm);
                    $("#no_paid").text(order_waitSend);
                }else{

                }
            }
        });
    }
</script>