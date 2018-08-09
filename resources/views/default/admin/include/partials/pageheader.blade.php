<div class="admin-header clearfix" style="min-width:1280px;">
    <div class="bgSelector"></div>
    <div class="admin-logo">
        <a href="javascript:void(0);" data-param="home" target="workspace">
            <img src="{{asset(themePath('/').'images/admin-logo.png')}}" />
        </a>
        <div class="foldsider"><i class="icon icon-indent-left"></i></div>
    </div>
    <div class="module-menu">
        <ul>
            <li data-param="menushopping"><a href="javascript:void(0);">商城</a></li>
            <li data-param="menuplatform"><a href="javascript:void(0);">平台</a></li>
            <li data-param="finance"><a href="javascript:void(0);">财务</a></li>
            <li data-param="third_party"><a href="javascript:void(0);">第三方服务</a></li>
            <li data-param="ectouch"><a href="javascript:void(0);">手机</a></li>
            <li data-param="menuinformation"><a href="javascript:void(0);">资源</a></li>
        </ul>
    </div>
    <div class="admin-header-right">
        <div class="manager">
            <dl>
                <dt class="name">习大大</dt>
                <dd class="group">超级管理员</dd>
            </dl>
            <span class="avatar">
				<form action="index.php" id="fileForm" method="post"  enctype="multipart/form-data"  runat="server">
					<input name="img" type="file" class="admin-avatar-file" id="_pic" title="设置管理员头像">
				</form>
				<img nctype="admin_avatar" src="{{asset(themePath('/').'images/admin.png')}}" />
			</span>
            <div id="admin-manager-btn" class="admin-manager-btn"><i class="arrow"></i></div>
            <div class="manager-menu">
                <div class="title">
                    <h4>最后登录</h4>
                    <a href="privilege.php?act=edit&id={$smarty.session.admin_id}" target="workspace" class="edit_pwd">修改密码</a>
                </div>
                <div class="login-date">
                    <strong>2018-08-08 17:44:09</strong>
                    <span>127.0.0.1</span>
                </div>
                <div class="title mt10">
                    <h4>常用操作</h4>
                    <a href="javascript:;" class="add_nav">添加菜单</a>
                </div>
                <div class="quick_link">
                    <ul>
                        <!-- 菜单列表-->
                        <li class="tl"><a href="1" target="workspace">菜单1</a></li>
                        <li class="tl"><a href="2" target="workspace">菜单2</a></li>
                        <li class="tl"><a href="3" target="workspace">菜单3</a></li>
                        <li class="tl"><a href="4" target="workspace">菜单4</a></li>
                        <li class="tl"><a href="5" target="workspace">菜单5</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="operate">
            <li style="position: relative;" ectype="oper_msg">
                <a href="javascript:void(0);" class="msg" title="查看消息">&nbsp;</a>
                <div id="msg_Container">
                    <div class="item">
                        <h3 class="order_msg" ectype="msg_tit">订单提示<em class="iconfont icon-up"></em></h3>
                        <div class="msg_content" ectype="orderMsg" style="display:block;"></div>
                    </div>

                    <div class="item">
                        <h3 class="goods_msg" ectype="msg_tit">商品提示<em class="iconfont icon-down"></em></h3>
                        <div class="msg_content" ectype="goodMsg"></div>
                    </div>

                    <div class="item">
                        <h3 class="shop_msg" ectype="msg_tit">商家审核提示<em class="iconfont icon-down"></em></h3>
                        <div class="msg_content" ectype="sellerMsg"></div>
                    </div>

                    <div class="item">
                        <h3 class="ad_msg" ectype="msg_tit">广告位提示<em class="iconfont icon-down"></em></h3>
                        <div class="msg_content" ectype="advMsg"></div>
                    </div>

                    <div class="item">
                        <h3 class="user_msg" ectype="msg_tit">会员提醒<em class="iconfont icon-down"></em></h3>
                        <div class="msg_content" ectype="userMsg"></div>
                    </div>

                    <div class="item">
                        <h3 class="campaign_msg" ectype="msg_tit">活动提醒<em class="iconfont icon-down"></em></h3>
                        <div class="msg_content" ectype="promotionMsg"></div>
                    </div>
                </div>
            </li>
            <i></i>
            <li><a href="../" target="_blank" class="home" title="新窗口打开商城首页">&nbsp;</a></li>
            <i></i>
            <li><a href="javascript:void(0);" class="sitemap" title="查看全部管理菜单">&nbsp;</a></li>
            <i></i>
            <li><a href="javascript:void(0);" id="trace_show" class="style-color" title="给管理中心换个颜色">&nbsp;</a></li>
            <i></i>
            <li><a href="index.php?act=clear_cache" class="clear" target="workspace" title="清除缓存">&nbsp;</a></li>
            <i></i>
            <li><a href="privilege.php?act=logout" class="prompt" title="安全退出管理中心">&nbsp;</a></li>
        </div>
    </div>
</div>

<div id="allMenu" style="display: none;">
    <div class="admincp-map ui-widget-content ui-draggable" nctype="map_nav" id="draggable">
        <div class="title ui-widget-header ui-draggable-handle" style="border:none; background:#fff;">
            <h3>管理中心全部菜单</h3>
            <h5>切换显示全部管理菜单，通过点击勾选可添加菜单为管理常用操作项，最多添加10个</h5>
            <span><a nctype="map_off" onclick="$('#allMenu').hide();" href="JavaScript:void(0);">X</a></span>
        </div>
        <div class="content">
            <ul class="admincp-map-nav">
                <li class=""><a href="javascript:void(0);" data-param="map-system">平台</a></li>
                <li class="selected"><a href="javascript:void(0);" data-param="map-shop">商城</a></li>
                <li class=""><a href="javascript:void(0);" data-param="map-mobile">手机端</a></li>
                <!--<li class=""><a href="javascript:void(0);" data-param="map-cms">APP</a></li>-->
                <li class=""><a href="javascript:void(0);" data-param="map-cms">资源</a></li>
            </ul>
            <div class="admincp-map-div" data-param="map-system" style="display: none;">

                <dl>
                    <dt>设置</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">支付方式</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">商店设置</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">地区&配送</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">计划任务</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">SEO设置</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>广告管理</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">广告列表</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">广告位置</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>文章管理</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">文章分类</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">文章列表</a><i class="fa fa-check-square-o"></i></dd>
                </dl>

            </div>
            <div class="admincp-map-div" data-param="map-shop" style="display: block;">

                <dl>
                    <dt>商品管理</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">商品列表</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">品牌管理</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">用户评论</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>商品管理</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">库存管理</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">库存入库</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">库存出库</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>商品管理</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">促销管理</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">拍卖活动</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">优惠活动</a><i class="fa fa-check-square-o"></i></dd>
                </dl>

            </div>
            <div class="admincp-map-div" data-param="map-mobile" style="display: none;">
                <dl>
                    <dt>手机端</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">授权登录</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">导航管理</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">广告管理</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>微信</dt>
                    <dd class="selected"><a href="#" data-param="" target="workspace">公众号设置</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">群发消息</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">自动回复</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
                <dl>
                    <dt>小程序</dt>

                    <dd class=""><a href="#" data-param="" target="workspace">小程序设置</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">消息提醒</a><i class="fa fa-check-square-o"></i></dd>
                </dl>
            </div>
            <div class="admincp-map-div" data-param="map-cms" style="display: none;">

                <dl>
                    <dt>云服务中心</dt>

                    <dd class="selected"><a href="#" data-param="" target="workspace">资源专区</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">平台推荐</a><i class="fa fa-check-square-o"></i></dd>
                    <dd class=""><a href="#" data-param="" target="workspace">好货推荐</a><i class="fa fa-check-square-o"></i></dd>

                </dl>



            </div>
        </div>
    </div>
</div>
