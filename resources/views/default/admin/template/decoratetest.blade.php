<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/main.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/iconfont.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/font-awesome.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/purebox.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/layoutit.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/layer.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/dsc_visual.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'css/color.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'plugs/layui/css/layui.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/spectrum-master/spectrum.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset(themePath('/').'js/perfect-scrollbar/perfect-scrollbar.min.css')}}" />

<script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>

<script src="{{asset(themePath('/').'js/jquery.json.js')}}" ></script>
<script src="{{asset(themePath('/').'js/transport_jquery.js')}}" ></script>
<script src="{{asset(themePath('/').'js/perfect-scrollbar/perfect-scrollbar.min.js')}}" ></script>
<script src="{{asset(themePath('/').'js/plupload.full.min.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery.SuperSlide.2.1.1.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery.form.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery-1.9.1.min.js')}}" ></script>
<script src="{{asset(themePath('/').'js/lib_ecmobanFunc.js')}}" ></script>
<script src="{{asset(themePath('/').'js/visualization.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery.cookie.js')}}" ></script>
<script src="{{asset(themePath('/').'js/spectrum-master/spectrum.js')}}" ></script>
<script src="{{asset(themePath('/').'js/jquery-ui/jquery-ui.min.js')}}" ></script>
<script src="{{asset(themePath('/').'js/common.js')}}" ></script>
<script src="{{asset(themePath('/').'js/layer.js')}}" ></script>
<script src="{{asset(themePath('/').'plugs/layui/layui.js')}}" ></script>



<div class="main-wrapper ">
    <div class="dp_leftcolumn">
        <ul class="tab-bar">
            <li class="modules current">
                <div class="wrap">
                    <div class="left-line"></div>
                    <i class="iconfont icon-template"></i>
                    <span>模板</span>
                    <b class="b-small"></b>
                </div>
            </li>
            <li class="page-content">
                <div class="wrap">
                    <div class="left-line"></div>
                    <i class="iconfont icon-visual-con"></i>
                    <span>中间</span>
                    <b class="b-small"></b>
                </div>
            </li>
            <li class="page-head">
                <div class="wrap">
                    <div class="left-line"></div>
                    <i class="iconfont icon-store-alt"></i>
                    <span>弹窗广告</span>
                    <b class="b-small"></b>
                </div>
            </li>
        </ul>
        <ul class="toolbar">
            <!--模板-->
            <li class="li modules-slide current" ectype="toolbar_li">
                <b class="iconfont icon-cha" ectype="close"></b>
                <div class="inside">
                    <p class="red">选择所需模块，并拖动至相应位置</p>
                </div>
                <div class="modules-box">
                    <!--基础模块-->
                    <div class="modules-wrap modules-wrap-current">
                        <div class="head" ectype="head"><span>基础模块</span><i class="iconfont icon-xia"></i></div>
                        <div class="module-list clearfix">

                            <div class="visual-item lyrow lunbotu ui-draggable" data-mode="lunbo" data-purebox="adv" data-li="1" data-length="5" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_01.png"></span>
                                        <span class="txt">图片轮播</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="banner home-banner">
                                        <div class="bd">
                                            <ul data-type="range">
                                                <li><a href="#"><img src="/default/visualDefault/shop_banner_pic.jpg"></a></li>
                                            </ul>
                                        </div>
                                        <div class="hd"><ul></ul></div>
                                        <div class="vip-outcon">
                                            <div class="vip-con">
                                                <div class="insertVipEdit" data-mode="insertVipEdit">
                                                    <div class="userVip-info" ectype="user_info">
                                                        <div class="avatar">
                                                            <a href="user.php?act=profile"><img src="/default/images/avatar.png"></a>
                                                        </div>
                                                        <div class="login-info">
                                                            <span>Hi，欢迎来到大商创!</span>
                                                            <a href="user.php" class="login-button">请登录</a>
                                                            <a href="merchants.php" target="_blank" class="register_button">我要开店</a>
                                                        </div>
                                                    </div>
                                                    <div class="vip-item">
                                                        <div class="tit">
                                                            <a href="javascript:void(0);" class="tab_head_item on">网店信息</a>
                                                            <a href="javascript:void(0);" class="tab_head_item">网店帮助分类</a>
                                                        </div>
                                                        <div class="con">
                                                            <ul>
                                                                <li><a href="article.php?id=5" target="_blank">免责条款</a></li>
                                                                <li><a href="article.php?id=4" target="_blank">联系我们</a></li>
                                                                <li><a href="article.php?id=3" target="_blank">咨询热点</a></li>
                                                            </ul>
                                                            <ul style="display: none;">
                                                                <li><a href="article.php?id=61" target="_blank">堂主的一封信：大商创被同行抄袭 证明我们已获得初步成功！</a></li>
                                                                <li><a href="article.php?id=58" target="_blank">大商创多用户商城系统版本升级 1.2版正式发布</a></li>
                                                                <li><a href="article.php?id=64" target="_blank">模板堂问答系统“问答堂”正式上线，商品相关问答一搜全知道</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="vip-item">
                                                        <div class="tit">快捷入口</div>
                                                        <div class="kj_con">
                                                            <div class="item item_1">
                                                                <a href="history_list.php" target="_blank">
                                                                    <i class="iconfont icon-browse"></i>
                                                                    <span>我的浏览</span>
                                                                </a>
                                                            </div>
                                                            <div class="item item_2">
                                                                <a href="user.php?act=collection_list" target="_blank">
                                                                    <i class="iconfont icon-zan-alt"></i>
                                                                    <span>我的收藏</span>
                                                                </a>
                                                            </div>
                                                            <div class="item item_3">
                                                                <a href="user.php?act=order_list" target="_blank">
                                                                    <i class="iconfont icon-order"></i>
                                                                    <span>我的订单</span>
                                                                </a>
                                                            </div>
                                                            <div class="item item_4">
                                                                <a href="user.php?act=account_safe" target="_blank">
                                                                    <i class="iconfont icon-password-alt"></i>
                                                                    <span>账号安全</span>
                                                                </a>
                                                            </div>
                                                            <div class="item item_5">
                                                                <a href="user.php?act=affiliate" target="_blank">
                                                                    <i class="iconfont icon-share-alt"></i>
                                                                    <span>我要分享</span>
                                                                </a>
                                                            </div>
                                                            <div class="item item_6">
                                                                <a href="merchants.php" target="_blank">
                                                                    <i class="iconfont icon-settled"></i>
                                                                    <span>商家入驻</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="setup_box" data-html="not">
                                                    <div class="barbg"></div>
                                                    <a href="javascript:void(0);" class="move-edit" ectype="vipEdit"><i class="iconfont icon-edit1"></i>编辑</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-need" data-purebox="homeAdv" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/8.png"></span>
                                        <span class="txt">首页广告</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="need-channel clearfix" id="h-need" data-type="range" data-lift="">
                                        <div class="channel-column" style="background:url(/default/visualDefault/ad_03_pic_02.jpg) no-repeat;">
                                            <div class="column-title">
                                                <h3>主标题</h3>
                                                <p>副标题</p>
                                            </div>
                                            <div class="column-img"><img src="/default/visualDefault/homeIndex_008.png"></div>
                                            <a href="#" target="_blank" class="column-btn">去看看</a>
                                        </div>
                                        <div class="channel-column" style="background:url(/default/visualDefault/ad_03_pic_02.jpg) no-repeat;">
                                            <div class="column-title">
                                                <h3>主标题</h3>
                                                <p>副标题</p>
                                            </div>
                                            <div class="column-img"><img src="/default/visualDefault/homeIndex_008.png"></div>
                                            <a href="#" target="_blank" class="column-btn">去看看</a>
                                        </div>
                                        <div class="channel-column" style="background:url(/default/visualDefault/ad_03_pic_02.jpg) no-repeat;">
                                            <div class="column-title">
                                                <h3>主标题</h3>
                                                <p>副标题</p>
                                            </div>
                                            <div class="column-img"><img src="/default/visualDefault/homeIndex_008.png"></div>
                                            <a href="#" target="_blank" class="column-btn">去看看</a>
                                        </div>
                                        <div class="channel-column" style="background:url(/default/visualDefault/ad_03_pic_02.jpg) no-repeat;">
                                            <div class="column-title">
                                                <h3>主标题</h3>
                                                <p>副标题</p>
                                            </div>
                                            <div class="column-img"><img src="/default/visualDefault/homeIndex_008.png"></div>
                                            <a href="#" target="_blank" class="column-btn">去看看</a>
                                        </div>
                                        <div class="channel-column" style="background:url(/default/visualDefault/ad_03_pic_02.jpg) no-repeat;">
                                            <div class="column-title">
                                                <h3>主标题</h3>
                                                <p>副标题</p>
                                            </div>
                                            <div class="column-img"><img src="/default/visualDefault/homeIndex_008.png"></div>
                                            <a href="#" target="_blank" class="column-btn">去看看</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-promo" data-purebox="homeAdv" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/5.png"></span>
                                        <span class="txt">促销活动</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="promoWarp clearfix" id="h-promo" data-type="range" data-lift="">
                                        <div class="tit" style="background-color:#ed5f5f;">
                                            <h3>主标题</h3>
                                            <span>此标题</span>
                                            <i class="titIcon"></i>
                                        </div>
                                        <ul>
                                            <li class="opacity_img">
                                                <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                <div class="info">
                                                    <div class="price">￥370.50</div>
                                                    <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
                                                    <div class="time" ectype="time">
                                                        <span class="label">剩余时间：</span>
                                                        <span class="days">00</span>
                                                        <em>：</em>
                                                        <span class="hours">00</span>
                                                        <em>：</em>
                                                        <span class="minutes">00</span>
                                                        <em>：</em>
                                                        <span class="seconds">00</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="opacity_img">
                                                <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                <div class="info">
                                                    <div class="price">￥370.50</div>
                                                    <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
                                                    <div class="time" ectype="time">
                                                        <span class="label">剩余时间：</span>
                                                        <span class="days">00</span>
                                                        <em>：</em>
                                                        <span class="hours">00</span>
                                                        <em>：</em>
                                                        <span class="minutes">00</span>
                                                        <em>：</em>
                                                        <span class="seconds">00</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="opacity_img">
                                                <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                <div class="info">
                                                    <div class="price">￥370.50</div>
                                                    <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
                                                    <div class="time" ectype="time">
                                                        <span class="label">剩余时间：</span>
                                                        <span class="days">00</span>
                                                        <em>：</em>
                                                        <span class="hours">00</span>
                                                        <em>：</em>
                                                        <span class="minutes">00</span>
                                                        <em>：</em>
                                                        <span class="seconds">00</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="opacity_img">
                                                <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                <div class="info">
                                                    <div class="price">￥370.50</div>
                                                    <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
                                                    <div class="time" ectype="time">
                                                        <span class="label">剩余时间：</span>
                                                        <span class="days">00</span>
                                                        <em>：</em>
                                                        <span class="hours">00</span>
                                                        <em>：</em>
                                                        <span class="minutes">00</span>
                                                        <em>：</em>
                                                        <span class="seconds">00</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="opacity_img">
                                                <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                <div class="info">
                                                    <div class="price">￥370.50</div>
                                                    <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
                                                    <div class="time" ectype="time">
                                                        <span class="label">剩余时间：</span>
                                                        <span class="days">00</span>
                                                        <em>：</em>
                                                        <span class="hours">00</span>
                                                        <em>：</em>
                                                        <span class="minutes">00</span>
                                                        <em>：</em>
                                                        <span class="seconds">00</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-streamer" data-purebox="adv" ectype="visualItme" data-length="1">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/8.png"></span>
                                        <span class="txt">横幅广告</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="adv_module">
                                        <div class="hd"><ul></ul></div>
                                        <div class="bd">
                                            <ul data-type="range">
                                                <li><a href=""><img src="/default/visualDefault/ad_01_pic.jpg"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="custom" data-purebox="cust" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_04.png"></span>
                                        <span class="txt">自定义区</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="custom" data-type="range" data-lift=""><div class="default ui-draggable ui-box-display">自定义内容，可以用来展示店铺的特色区域。</div></div>
                                </div>
                            </div>

                            <div class="visual-item lyrow w1200  ui-draggable"  data-mode="custom" data-purebox="cust" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/icon/baby.png"></span>
                                        <span class="txt">测试区</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">

                                    <div class="adv_module">
                                        <div class="hd"><ul></ul></div>
                                        <div class="bd">
                                            <ul data-type="range">
                                                <li><a href=""><img src="/default/visualDefault/ad_01_pic.jpg"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!--楼层模块-->
                    <div class="modules-wrap modules-wrap-current mt20">
                        <div class="head" ectype="head"><span>楼层模块</span><i class="iconfont icon-xia"></i></div>
                        <div class="module-list clearfix">
                            <!--楼层模板一-->
                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloor" data-purebox="homeFloor" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                                        <span class="txt">楼层一</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="floor-content" data-type="range">
                                        <div class="floor-line-con floorOne floor-color-type-1" data-title="主分类名称" data-idx="1" id="floor_1" ectype="floorItem">
                                            <div class="floor-hd" ectype="floorTit">
                                                <i class="box_hd_arrow"></i>
                                                <i class="box_hd_dec"></i>
                                                <div class="hd-tit">主分类名称</div>
                                                <div class="hd-tags">
                                                    <ul>
                                                        <li class="first current">
                                                            <span>新品推荐</span>
                                                            <i class="arrowImg"></i>
                                                        </li>
                                                        <li ectype="floor_cat_content">
                                                            <span>次级分类</span>
                                                            <i class="arrowImg"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="floor-bd bd-mode-01">
                                                <div class="bd-left">
                                                    <div class="floor-left-slide">
                                                        <div class="bd">
                                                            <ul>
                                                                <li><a href="#"><img src="/default/visualDefault/homeIndex_002.jpg" width="232" height="570"></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="hd"><ul></ul></div>
                                                    </div>
                                                    <div class="floor-left-adv">
                                                        <a href="http://" class="mb10" target="_blank"><img src="/default/visualDefault/homeIndex_004.jpg" width="232" height="280"></a>
                                                        <a href="http://" target="_blank"><img src="/default/visualDefault/homeIndex_004.jpg" width="232" height="280"></a>
                                                    </div>
                                                </div>
                                                <div class="bd-right">
                                                    <div class="floor-tabs-content clearfix">
                                                        <div class="f-r-main f-r-m-adv">
                                                            <div class="f-r-m-item">
                                                                <a href="http://" target="_blank">
                                                                    <div class="title">
                                                                        <h3>主标题</h3>
                                                                        <span>次标题</span>
                                                                    </div>
                                                                    <img src="/default/visualDefault/homeIndex_004.jpg">
                                                                </a>
                                                            </div>
                                                            <div class="f-r-m-item">
                                                                <a href="http://" target="_blank">
                                                                    <div class="title">
                                                                        <h3>主标题</h3>
                                                                        <span>次标题</span>
                                                                    </div>
                                                                    <img src="/default/visualDefault/homeIndex_004.jpg">
                                                                </a>
                                                            </div>
                                                            <div class="f-r-m-item">
                                                                <a href="http://" target="_blank">
                                                                    <div class="title">
                                                                        <h3>主标题</h3>
                                                                        <span>次标题</span>
                                                                    </div>
                                                                    <img src="/default/visualDefault/homeIndex_004.jpg">
                                                                </a>
                                                            </div>
                                                            <div class="f-r-m-item">
                                                                <a href="http://" target="_blank">
                                                                    <div class="title">
                                                                        <h3>主标题</h3>
                                                                        <span>次标题</span>
                                                                    </div>
                                                                    <img src="/default/visualDefault/homeIndex_004.jpg">
                                                                </a>
                                                            </div>
                                                            <div class="f-r-m-item f-r-m-i-double">
                                                                <a href="http://" target="_blank">
                                                                    <div class="title">
                                                                        <h3>主标题</h3>
                                                                        <span>次标题</span>
                                                                    </div>
                                                                    <img src="/default/visualDefault/homeIndex_006.jpg">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="floor-fd">
                                                <div class="floor-fd-brand clearfix">
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--楼层模板二-->
                            <div class="visual-item lyrow w1200 not-draggable ui-draggable" data-mode="homeFloorModule" data-purebox="homeFloor" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                                        <span class="txt">楼层二</span>
                                    </div>
                                </div>
                                <div class="module floormodule mr8" ectype="module">
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                    <div class="view" data-hierarchy="1">
                                        <div class="floor-content" data-type="range">
                                            <div class="floor-line-con floorTwo floor-color-type-1" data-title="主分类名称" data-idx="1" id="floor_1" ectype="floorItem">
                                                <div class="floor-hd" ectype="floorTit">
                                                    <i class="box_hd_arrow"></i>
                                                    <i class="box_hd_dec"></i>
                                                    <div class="hd-tit">主分类名称</div>
                                                    <div class="hd-tags">
                                                        <ul>
                                                            <li class="first current">
                                                                <span>新品推荐</span>
                                                                <i class="arrowImg"></i>
                                                            </li>
                                                            <li ectype="floor_cat_content">
                                                                <span>次级分类</span>
                                                                <i class="arrowImg"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="floor-bd">
                                                    <div class="bd-left">
                                                        <div class="floor-left-slide">
                                                            <div class="bd">
                                                                <ul>
                                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/homeIndex_013.jpg"></a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="hd"><ul></ul></div>
                                                        </div>
                                                    </div>
                                                    <div class="bd-right">
                                                        <div class="floor-tabs-content clearfix">
                                                            <div class="f-r-main f-r-m-adv">
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="f-r-main">
                                                                <ul class="p-list">
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="floor-fd">
                                                    <div class="floor-fd-brand clearfix">
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="module floormodule" ectype="module">
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                    <div class="view" data-hierarchy="2">
                                        <div class="floor-content" data-type="range">
                                            <div class="floor-line-con floorTwo floor-color-type-1" data-title="主分类名称" data-idx="1" id="floor_1" ectype="floorItem">
                                                <div class="floor-hd" ectype="floorTit">
                                                    <div class="hd-tit">主分类名称</div>
                                                    <div class="hd-tags">
                                                        <ul>
                                                            <li class="first current">
                                                                <span>新品推荐</span>
                                                                <i class="arrowImg"></i>
                                                            </li>
                                                            <li ectype="floor_cat_content">
                                                                <span>次级分类</span>
                                                                <i class="arrowImg"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="floor-bd">
                                                    <div class="bd-left">
                                                        <div class="floor-left-slide">
                                                            <div class="bd">
                                                                <ul>
                                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/homeIndex_013.jpg"></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bd-right">
                                                        <div class="floor-tabs-content clearfix">
                                                            <div class="f-r-main f-r-m-adv">
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                                <div class="f-r-m-item">
                                                                    <a href="#" target="_blank">
                                                                        <div class="title">
                                                                            <h3>男童装</h3>
                                                                            <span>新款上市</span>
                                                                        </div>
                                                                        <img src="/default/visualDefault/homeIndex_012.jpg">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="f-r-main">
                                                                <ul class="p-list">
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="opacity_img">
                                                                        <a href="#" target="_blank">
                                                                            <div class="p-img"><img src="/default/visualDefault/zhanwei.png"></div>
                                                                            <div class="p-name">微琪思新款2016无袖牛仔连衣裙修身中短裙显瘦休闲背心裙</div>
                                                                            <div class="p-price"><em>¥</em>370.50</div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="floor-fd">
                                                    <div class="floor-fd-brand clearfix">
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                                <div class="link"></div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#" target="_blank">
                                                                <div class="link-l"></div>
                                                                <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--楼层模板三-->
                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloorThree" data-purebox="homeFloor" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                                        <span class="txt">楼层三</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="floor-content" data-type="range">
                                        <div class="floor-line-con floorThree floor-color-type-1" data-title="主分类名称" data-idx="1" id="floor_1" ectype="floorItem">
                                            <div class="floor-hd" ectype="floorTit">
                                                <div class="hd-tit">主分类名称</div>
                                                <div class="hd-tags">
                                                    <ul>
                                                        <li class="first current">新品推荐</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="floor-bd FT-bd-more-01">
                                                <ul>
                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/visual232x590.jpg"></a></li>
                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/visual232x590.jpg"></a></li>
                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/visual232x590.jpg"></a></li>
                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/visual232x590.jpg"></a></li>
                                                    <li><a href="#" target="_blank"><img src="/default/visualDefault/visual232x590.jpg"></a></li>
                                                </ul>
                                            </div>
                                            <div class="floor-fd">
                                                <div class="floor-fd-brand clearfix">
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                    <div class="item">
                                                        <a href="#" target="_blank">
                                                            <div class="link-l"></div>
                                                            <div class="img"><img src="/default/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                                                            <div class="link"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--楼层模板四-->
                            <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloorFour" data-purebox="homeFloor" data-li="1" ectype="visualItme">
                                <div class="drag" data-html="not">
                                    <div class="navLeft">
                                        <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                                        <span class="txt">楼层四</span>
                                    </div>
                                    <div class="setup_box">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                                        <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                                        <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                                    </div>
                                </div>
                                <div class="view">
                                    <div class="floor-content" data-type="range">
                                        <div class="floor-line-con floorFour floor-color-type-3" data-title="主分类名称" data-idx="1" id="floor_1" ectype="floorItem">
                                            <div class="floor-hd" ectype="floorTit">
                                                <div class="hd-tit">主分类名称</div>
                                                <div class="hd-tags">
                                                    <ul>
                                                        <li class="first current">新品推荐</li>
                                                        <li>连衣裙</li>
                                                        <li>毛衣外套</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="floor-bd FF-bd-more-01">
                                                <div class="bd-left">
                                                    <div class="floor-left-adv">
                                                        <a href="#" target="_blank"><img src="/default/visualDefault/visual200x520.jpg"></a>
                                                    </div>
                                                    <div class="p-list">
                                                        <ul>
                                                            <li class="left-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="right-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="left-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="right-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="bd-right">
                                                    <div class="floor-left-adv">
                                                        <a href="#" target="_blank"><img src="/default/visualDefault/visual200x520.jpg"></a>
                                                    </div>
                                                    <div class="p-list">
                                                        <ul>
                                                            <li class="left-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="left-child opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                            <li class="opacity_img">
                                                                <div class="product">
                                                                    <div class="p-img"><a href="#" target="_blank"><img src="/default/visualDefault/zhanwei.png"></a></div>
                                                                    <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                                                    <div class="p-price"><em>¥</em>370.50</div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </li>
            <!--中间-->
            <li class="li page-content-slide" data-style="content" ectype="toolbar_li">
                <b class="iconfont icon-cha" ectype="close"></b>
                <div class="page-head-bg-content">
                    <div class="page-head-bg-content-wrap" style="height: 300px;">
                        <div class="page-head-bg">
                            <label class="tit">中间背景色：</label>
                            <input class="tm-picker-trigger" value="" style="display: none;" type="hidden"><div class="sp-replacer sp-light"><div class="sp-preview"><div class="sp-preview-inner" style="background-color: rgb(255, 255, 255);"></div></div><div class="sp-dd">▼</div></div>
                            <input class="ui-checkbox" name="content_dis" value="1" id="content_dis" type="checkbox">
                            <label for="content_dis" class="ui-label">显示</label>
                        </div>
                        <div class="page-head-bgimg clearfix">
                            <form action="" id="bgfileForm" method="post" enctype="multipart/form-data" runat="server">
                                <div><label class="tit">中间背景图：</label></div>
                                <div class="bgimg"><input name="fileimg" value="/default/visualDefault/bgimg.gif" type="hidden"><img id="confilefile" src="/default/visualDefault/bgimg.gif" alt=""></div>
                                <div class="action">
                                    <div class="action-btn action-btn_bg">
                                        <a href="javascript:void(0);" class="ks-uploader-button">
                                            <span class="btn-text">更换图片</span>
                                            <div class="file-input-wrapper"><input name="confile" value="更换图片" class="file-input" type="file"></div>
                                        </a>
                                        <a href="javascript:void(0);" class="delete" ectype="delete_bg"></a>
                                    </div>
                                    <div class="content">
                                        <div>文件格式：GIF,JPG,PNG</div>
                                        <div>文件大小：2MB以内</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="bg-show clearfix" style="display:none;">
                            <div>背景显示：</div>
                            <div class="bg-show-nr">
                                <a href="javascript:void(0);" data-bg-show="repeat">平铺</a>
                                <a href="javascript:void(0);" data-bg-show="repeat-y">纵向平铺</a>
                                <a href="javascript:void(0);" data-bg-show="repeat-x">横向平铺</a>
                                <a href="javascript:void(0);" data-bg-show="no-repeat">不平铺</a>
                            </div>
                        </div>
                        <div class="bg-align clearfix" style="display:none;">
                            <div>背景对齐：</div>
                            <div class="bg-align-nr">
                                <a href="javascript:void(0);" data-bg-align="left">左对齐</a>
                                <a href="javascript:void(0);" data-bg-align="center">居中</a>
                                <a href="javascript:void(0);" data-bg-align="right">右对齐</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!--弹窗广告-->
            <li class="li page-content-slide" data-style="adv" ectype="toolbar_li">
                <div class="inside">
                    <p class="red ml0">此模块控制首页弹出广告，如不需要直接删除图片即可</p>
                </div>
                <b class="iconfont icon-cha" ectype="close"></b>
                <div class="page-head-bg-content pt0">
                    <div class="page-head-bg-content-wrap" style="height: 300px;">
                        <form action="" id="advfileForm" method="post" enctype="multipart/form-data" runat="server">
                            <div class="overflow">
                                <label class="tit">广告链接：</label>
                                <input value="" name="adv_url" class="text mt10" placeholder="http(s)://" type="text">
                            </div>
                            <div class="page-head-bgimg clearfix">
                                <div><label class="tit">广告背景图：</label></div>
                                <div class="bgimg"><img src="/default/visualDefault/bgimg.gif" alt="" id="bonusadvfile"></div>
                                <div class="action">
                                    <div class="action-btn">
                                        <a href="javascript:void(0);" class="ks-uploader-button">
                                            <span class="btn-text">更换图片</span>
                                            <div class="file-input-wrapper"><input name="advfile" value="更换图片" class="file-input" type="file"></div>
                                        </a>
                                        <a href="javascript:void(0);" class="delete" ectype="delete_adv"></a>
                                    </div>
                                    <div class="content">
                                        <div>文件格式：GIF,JPG,PNG</div>
                                        <div>文件尺寸：640*568</div>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow mt20">
                                <button type="button" ectype="adcSubmit" class="button">提交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="db_main">
        <div class="design-nav-wrap">
            <div class="btns">
                <a href="javascript:void(0);" class="btn btn_blue" ectype="downloadModal">确认发布</a>
                <a href="javascript:void(0);" class="btn"  ectype="back">还原</a>
                <a href="javascript:void(0);" class="btn" ectype="preview">预览</a>
                <a href="javascript:void(0);" class="btn" ectype="information">信息编辑</a>
            </div>
        </div>
        <!-- 整个页面 -->
        <div class="pc-page pc-home" ectype="visualShell" style="height: 269px; width: 1056px;">
            <input id="_token" type="hidden" name="_token" value="{{ csrf_token()}}"/>
            <div class="pageHome">
                <!--广告-->
                <div class="topBanner lyrow ui-draggable ui-box-display" data-purebox="banner" data-mode="topBanner" ectype="visualItme" data-diff="0" data-length="1" data-topbanner="1" data-homehtml="topBanner">
                    <div class="top-banner" style="background:#dbe0e4;">
                        <div class="module w1200" data-type="range">
                            <a href="#"><img src="/default/visualDefault/homeIndex_011.jpg" width="1200" height="80"></a>
                            <i class="iconfont icon-cha" ectype="close"></i>
                        </div>
                    </div>
                    <div class="setup_box" data-html="not">
                        <div class="barbg"></div>
                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                        <a href="javascript:void(0);" class="move-remove" ectype="model_delete"><i class="iconfont icon-remove-alt"></i>删除</a>
                    </div>
                </div>
                <!--顶部导航-->
                <div class="site-nav">
                    <div class="w w1200">
                        <div class="fl">
                            <div class="city-choice">
                                <div class="dsc-choie dsc-cm">
                                    <i class="iconfont icon-map-marker"></i>
                                    <span class="ui-areamini-text" data-id="1" title="上海">上海</span>
                                </div>
                            </div>
                            <div class="txt-info" id="ECS_MEMBERZONE">
                                <a href="#" class="link-login red">请登录</a>
                                <a href="#" class="link-regist">免费注册</a>
                            </div>
                        </div>
                        <div class="quick-menu fr">
                            <ul class="quick-menu fr">
                                <li><div class="dt"><a href="#">我的订单</a></div></li>
                                <li class="spacer"></li>
                                <li><div class="dt"><a href="#">我的浏览</a></div></li>
                                <li class="spacer"></li>
                                <li><div class="dt"><a href="#">我的收藏</a></div></li>
                                <li class="spacer"></li>
                                <li><div class="dt"><a href="#">客户服务</a></div></li>
                                <li class="spacer"></li>
                                <li class="li_dorpdown" data-ectype="dorpdown"><div class="dt dsc-cm">网站导航</div></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--头部-->
                <div class="header">
                    <div class="w w1200">
                        <div class="logo">
                            <div class="logoImg"><a href="#"><img src="/default/images/logo.gif"></a></div>
                            <div class="logoAdv"><a href="#"><img src="/default/images/ecsc-join.gif"></a></div>
                        </div>
                        <div class="dsc-search">
                            <div class="form">
                                <input autocomplete="off" name="keywords" id="keyword" value="手机" class="search-text" type="text">
                                <input name="store_search_cmt" value="0" type="hidden">
                                <button type="submit" class="button button-goods">搜商品</button>
                                <button type="submit" class="button button-store">搜店铺</button>
                                <ul class="keyword">
                                    <li><a href="#">周大福</a></li>
                                    <li><a href="#">内衣</a></li>
                                    <li><a href="#">Five Plus</a></li>
                                    <li><a href="#">手机</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="shopCart">
                            <div class="shopCart-con dsc-cm">
                                <a href="#">
                                    <i class="iconfont icon-carts"></i>
                                    <span>我的购物车</span>
                                    <em class="count cart_num">0</em>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav lyrow ui-draggable ui-box-display" data-mode="nav_mode" data-purebox="nav_mode">
                <div class="w w1200 nav_bg" ectype="nav" style="background-color:#fff;">
                    <div class="categorys"><div class="categorys-type"><a href="categoryall.php" target="_blank">全部商品分类</a></div></div>
                    <div class="nav-main" id="nav">
                        <ul class="navitems" data-type="range">
                            <li><a href="index.php" class="curr">首页</a></li>
                            <li><a href="brand.php" style="text-align:">品牌专区</a></li>
                            <li><a href="presale.php" style="text-align:">预售</a></li>
                            <li><a href="store_street.php" style="text-align:">店铺街</a></li>
                            <li><a href="exchange.php" style="text-align:">积分商城</a></li>
                            <li><a href="category.php?id=858" style="text-align:">大家电</a></li>
                            <li><a href="category.php?id=12" style="text-align:">食品特产</a></li>
                            <li><a href="category.php?id=6" style="text-align:">服装城</a></li>
                            <li><a href="category.php?id=8" style="text-align:">鞋靴箱包</a></li>
                        </ul>
                    </div>
                    <div class="setup_box" data-html="not">
                        <div class="barbg"></div>
                        <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                    </div>
                </div>
            </div>
            <div class="prompt" data-html="not">以上为页头区域</div>
            <div class="demo ui-sortable" style="min-height: 330px;">
                <!--图片轮播-->
                <div class="visual-item lyrow lunbotu ui-draggable" data-mode="lunbo" data-purebox="banner" data-li="1" data-length="5" ectype="visualItme" style="display: block;" data-diff="0">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_01.png"></span>
                            <span class="txt">图片轮播</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1 disabled"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="banner home-banner">
                            <div class="bd">
                                <ul data-type="range">

                                    <li style="background:url(/default/2/1494984992503176615.jpg) center center no-repeat;"><div class="banner-width"><a href="" style="height:500px;"></a></div></li>
                                    <li style="background:url(/default/2/1494984990506843460.jpg) center center no-repeat;"><div class="banner-width"><a href="" style="height:500px;"></a></div></li>
                                    <li style="background:url(/default/2//1494984991783527346.jpg) center center no-repeat;"><div class="banner-width"><a href="" style="height:500px;"></a></div></li>

                                </ul>
                                <div class="spec" data-spec="{&quot;picHeight&quot;:&quot;500&quot;,&quot;slide_type&quot;:&quot;shade&quot;,&quot;target&quot;:&quot;_blank&quot;,&quot;navColor&quot;:&quot;#dbe0e4&quot;,&quot;is_li&quot;:1,&quot;bg_color&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;pic_src&quot;:[&quot;data/gallery_album/2/original_img/1494984992503176615.jpg&quot;,&quot;data/gallery_album/2/original_img/1494984990506843460.jpg&quot;,&quot;data/gallery_album/2/original_img/1494984991783527346.jpg&quot;],&quot;link&quot;:&quot;,,&quot;,&quot;sort&quot;:[&quot;1&quot;,&quot;2&quot;,&quot;3&quot;]}"></div>
                            </div>
                            <div class="hd"><ul></ul></div>
                            <div class="vip-outcon">
                                <div class="vip-con">
                                    <div class="insertVipEdit" data-mode="insertVipEdit">

                                        <div ectype="user_info">
                                            <div class="avatar">
                                                <a href="user.php?act=profile"><img src="/default/images/avatar.png"></a>
                                            </div>
                                            <div class="login-info">
                                                <span>Hi，欢迎来到大商创</span>
                                                <a href="user.php" class="login-button">请登录</a>
                                                <a href="merchants.php" target="_blank" class="register_button">我要开店</a>
                                            </div>
                                        </div>
                                        <div class="vip-item">
                                            <div class="tit">
                                                <a href="javascript:void(0);" class="tab_head_item">公告</a>
                                                <a href="javascript:void(0);" class="tab_head_item">促销</a>
                                            </div>
                                            <div class="con">
                                                <ul>
                                                    <li><a href="article.php?id=63" target="_blank">服务店突破2000多家</a></li>
                                                    <li><a href="article.php?id=62" target="_blank">我们成为中国最大家电零售B2B2C系统</a></li>
                                                    <li><a href="article.php?id=61" target="_blank">三大国际腕表品牌签约</a></li>
                                                </ul>
                                                <ul style="display:none;">
                                                    <li><a href="article.php?id=60" target="_blank">春季家装季，家电买一送一</a></li>
                                                    <li><a href="article.php?id=59" target="_blank">抢百元优惠券，享4.22%活期</a></li>
                                                    <li><a href="article.php?id=58" target="_blank">Macbook最高返50000消费豆！</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="vip-item">
                                            <div class="tit">快捷入口</div>
                                            <div class="kj_con">
                                                <div class="item item_1">
                                                    <a href="history_list.php" target="_blank">
                                                        <i class="iconfont icon-browse"></i>
                                                        <span>我的浏览</span>
                                                    </a>
                                                </div>
                                                <div class="item item_2">
                                                    <a href="user.php?act=collection_list" target="_blank">
                                                        <i class="iconfont icon-zan-alt"></i>
                                                        <span>我的收藏</span>
                                                    </a>
                                                </div>
                                                <div class="item item_3">
                                                    <a href="user.php?act=order_list" target="_blank">
                                                        <i class="iconfont icon-order"></i>
                                                        <span>我的订单</span>
                                                    </a>
                                                </div>
                                                <div class="item item_4">
                                                    <a href="user.php?act=account_safe" target="_blank">
                                                        <i class="iconfont icon-password-alt"></i>
                                                        <span>账号安全</span>
                                                    </a>
                                                </div>
                                                <div class="item item_5">
                                                    <a href="user.php?act=affiliate" target="_blank">
                                                        <i class="iconfont icon-share-alt"></i>
                                                        <span>我要分享</span>
                                                    </a>
                                                </div>
                                                <div class="item item_6">
                                                    <a href="merchants.php" target="_blank">
                                                        <i class="iconfont icon-settled"></i>
                                                        <span>商家入驻</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><div class="spec" data-spec="{&quot;quick_name&quot;:[&quot;我的浏览&quot;,&quot;我的收藏&quot;,&quot;我的订单&quot;,&quot;账号安全&quot;,&quot;我要分享&quot;,&quot;商家入驻&quot;],&quot;quick_url&quot;:&quot;history_list.php,user.php?act=collection_list,user.php?act=order_list,user.php?act=account_safe,user.php?act=affiliate,merchants.php&quot;,&quot;index_article_cat&quot;:&quot;20,21&quot;,&quot;style_icon&quot;:[&quot;browse&quot;,&quot;zan&quot;,&quot;order&quot;,&quot;password&quot;,&quot;share&quot;,&quot;settled&quot;]}"></div>
                                    <div class="setup_box" data-html="not">
                                        <div class="barbg"></div>
                                        <a href="javascript:void(0);" class="move-edit" ectype="vipEdit"><i class="iconfont icon-edit1"></i>编辑</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--首页广告-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-need" data-purebox="homeAdv" data-li="1" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/8.png"></span>
                            <span class="txt">首页广告</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="need-channel clearfix" id="h-need_0" data-type="range" data-lift="推荐">

                            <div class="channel-column" style="background:url(/default/2//1494984987302153402.jpg) no-repeat;">
                                <div class="column-title">
                                    <h3>优质新品</h3>
                                    <p>专注生活美学</p>
                                </div>
                                <div class="column-img"><img src="/default/2//1494985002375136884.png"></div>
                                <a href="" target="_blank" class="column-btn">去看看</a>
                            </div>
                            <div class="channel-column" style="background:url(/default/2//1494984989930757668.jpg) no-repeat;">
                                <div class="column-title">
                                    <h3>潮流女装</h3>
                                    <p>春装流行款抢购</p>
                                </div>
                                <div class="column-img"><img src="/default/2//1494984989766362152.png"></div>
                                <a href="" target="_blank" class="column-btn">去看看</a>
                            </div>
                            <div class="channel-column" style="background:url(/default/2//1494984989391013089.jpg) no-repeat;">
                                <div class="column-title">
                                    <h3>人气美鞋</h3>
                                    <p>新外貌“鞋”会</p>
                                </div>
                                <div class="column-img"><img src="/default/2//1494984990383161028.png"></div>
                                <a href="" target="_blank" class="column-btn">去看看</a>
                            </div>
                            <div class="channel-column" style="background:url(/default/2//1494984987606903394.jpg) no-repeat;">
                                <div class="column-title">
                                    <h3>品牌精选</h3>
                                    <p>潮牌尖货 初春换新</p>
                                </div>
                                <div class="column-img"><img src="/default/2//1494984988032635434.png"></div>
                                <a href="" target="_blank" class="column-btn">去看看</a>
                            </div>
                            <div class="channel-column" style="background:url(/default/2//1494984990175755536.jpg) no-repeat;">
                                <div class="column-title">
                                    <h3>护肤彩妆</h3>
                                    <p>春妆必买清单 低至3折</p>
                                </div>
                                <div class="column-img"><img src="/default/2//1494984991251825734.png"></div>
                                <a href="" target="_blank" class="column-btn">去看看</a>
                            </div>
                            <div class="spec" data-spec="[{&quot;title&quot;:&quot;优质新品&quot;,&quot;subtitle&quot;:&quot;专注生活美学&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985002375136884.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494984987302153402.jpg&quot;},{&quot;title&quot;:&quot;潮流女装&quot;,&quot;subtitle&quot;:&quot;春装流行款抢购&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494984989766362152.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494984989930757668.jpg&quot;},{&quot;title&quot;:&quot;人气美鞋&quot;,&quot;subtitle&quot;:&quot;新外貌“鞋”会&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494984990383161028.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494984989391013089.jpg&quot;},{&quot;title&quot;:&quot;品牌精选&quot;,&quot;subtitle&quot;:&quot;潮牌尖货 初春换新&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494984988032635434.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494984987606903394.jpg&quot;},{&quot;title&quot;:&quot;护肤彩妆&quot;,&quot;subtitle&quot;:&quot;春妆必买清单 低至3折&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494984991251825734.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494984990175755536.jpg&quot;}]" data-title=""></div></div>
                    </div>
                </div>
                <!--首页品牌-->
                <div class="visual-item lyrow w1200 brandList ui-draggable" data-mode="h-brand" data-purebox="homeAdv" data-li="1" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/7.png"></span>
                            <span class="txt">首页品牌</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="brand-channel clearfix" id="h-brand_0" data-type="range" data-lift="品牌">

                            <div class="home-brand-adv slide_lr_info">
                                <a href="" target="_blank"><img src="/default/2//1494984992104112514.jpg" class="slide_lr_img"></a>
                            </div>
                            <div ectype="homeBrand">
                                <div class="brand-list" id="recommend_brands" data-value="204,93,110,113,116,195,79,95,76,126,73,122,98,82,101,85,105">
                                    <ul>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=204" target="_blank"><img src="/default/1/1490039286075654490.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="204" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=204" target="_blank">关注人数<br><div id="collect_count_204">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=195" target="_blank"><img src="/default/1/1490075385239594909.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="195" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=195" target="_blank">关注人数<br><div id="collect_count_195">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=73" target="_blank"><img src="/default/1/1490072329183966195.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="73" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=73" target="_blank">关注人数<br><div id="collect_count_73">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=76" target="_blank"><img src="/default/1/1490072373278367315.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="76" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=76" target="_blank">关注人数<br><div id="collect_count_76">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=79" target="_blank"><img src="/default/1/1490072677495061584.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="79" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=79" target="_blank">关注人数<br><div id="collect_count_79">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=82" target="_blank"><img src="/default/1/1490072694695600078.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="82" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=82" target="_blank">关注人数<br><div id="collect_count_82">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=85" target="_blank"><img src="/default/1/1490072756032175204.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="85" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=85" target="_blank">关注人数<br><div id="collect_count_85">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=110" target="_blank"><img src="/default/1/1490074043963552715.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="110" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=110" target="_blank">关注人数<br><div id="collect_count_110">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=113" target="_blank"><img src="/default/1/1490074030328949587.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="113" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=113" target="_blank">关注人数<br><div id="collect_count_113">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=116" target="_blank"><img src="/default/1/1490073109529817869.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="116" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=116" target="_blank">关注人数<br><div id="collect_count_116">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=122" target="_blank"><img src="/default/1/1490073982547710498.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="122" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=122" target="_blank">关注人数<br><div id="collect_count_122">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=126" target="_blank"><img src="/default/1/1490073943918274561.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="126" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=126" target="_blank">关注人数<br><div id="collect_count_126">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=95" target="_blank"><img src="/default/1/1490072870537181142.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="95" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=95" target="_blank">关注人数<br><div id="collect_count_95">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=98" target="_blank"><img src="/default/1/1490072898345358625.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="98" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=98" target="_blank">关注人数<br><div id="collect_count_98">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=101" target="_blank"><img src="/default/1/1490072931218635674.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="101" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=101" target="_blank">关注人数<br><div id="collect_count_101">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=105" target="_blank"><img src="/default/1/1490072971610241726.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="105" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=105" target="_blank">关注人数<br><div id="collect_count_105">0</div></a></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="brand-img"><a href="brandn.php?id=93" target="_blank"><img src="/default/1/1490072850306019115.jpg"></a></div>
                                            <div class="brand-mash">
                                                <div data-bid="93" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                                                <div class="coupon"><a href="brandn.php?id=93" target="_blank">关注人数<br><div id="collect_count_93">0</div></a></div>
                                            </div>
                                        </li>
                                    </ul>
                                    <a href="javascript:void(0);" ectype="changeBrand" class="refresh-btn"><i class="iconfont icon-rotate-alt"></i><span>换一批</span></a>
                                </div>
                            </div>
                            <div class="spec" data-spec="{&quot;content&quot;:&quot;&quot;,&quot;moded&quot;:&quot;h-brand&quot;,&quot;barndAdv&quot;:[&quot;data/gallery_album/2/original_img/1494984992104112514.jpg&quot;],&quot;brand_ids&quot;:&quot;204,93,110,113,116,195,79,95,76,126,73,122,98,82,101,85,105&quot;,&quot;barndAdvLink&quot;:[&quot;&quot;],&quot;barndAdvSort&quot;:[&quot;1&quot;]}" data-title="undefined"></div></div>
                    </div>
                </div>
                <!--首页楼层-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloor" data-purebox="homeFloor" data-li="1" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                            <span class="txt">首页楼层</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="floor-content" data-type="range" id="homeFloor_0" data-lift="女装">

                            <div class="floor-line-con floor-color-type-1" data-title="男装女装" data-idx="1" id="floor_1" ectype="floorItem">
                                <div class="floor-hd" ectype="floorTit">
                                    <div class="hd-tit">男装、女装、内衣</div>
                                    <div class="hd-tags">
                                        <ul>
                                            <li class="first current">
                                                <span>新品推荐</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="347">
                                                <span>女装</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="630">
                                                <span>服饰配件</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="547">
                                                <span>内衣</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="463">
                                                <span>男装</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="floor-bd bd-mode-01">
                                    <div class="bd-left">
                                        <div class="floor-left-slide">
                                            <div class="bd">
                                                <ul>
                                                    <li><a href=""><img src="/default/2//1494985255003388359.jpg"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985255671031591.jpg"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985255859372374.jpg"></a></li>
                                                </ul>
                                            </div>
                                            <div class="hd"><ul></ul></div>
                                        </div>

                                        <div class="floor-left-adv">
                                            <a href="" target="_blank"><img src="/default/2//1494984993812175408.jpg"></a>
                                            <a href="" target="_blank"><img src="/default/2//1494984993892207941.jpg"></a>
                                        </div>

                                    </div>
                                    <div class="bd-right">
                                        <div class="floor-tabs-content clearfix">
                                            <div class="f-r-main f-r-m-adv">
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>毛衣</h3>
                                                            <span>满100减100</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494984997173604814.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>随意搭</h3>
                                                            <span>来潮我看</span>
                                                        </div>
                                                        <img src="/default/2//1494985255611006354.png                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>外套</h3>
                                                            <span>大牌好货抢</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985257076782520.png                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>连衣裙</h3>
                                                            <span>春季流行款抢购</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985261416235695.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	 f-r-m-i-double                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>女式套装</h3>
                                                            <span>新品低至五折</span>
                                                        </div>
                                                        <img src="
                            	                                	                            			/default/2//1494984998972685382.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_347">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_630">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_547">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_463">
                                                <ul class="p-list"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="floor-fd">
                                    <div class="floor-fd-brand clearfix">
                                        <div class="item">
                                            <a href="brandn.php?id=72" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072313895957648.jpg" title="ELLE HOME"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=76" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072373278367315.jpg" title="金利来"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=79" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072677495061584.jpg" title="justyle"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=82" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072694695600078.jpg" title="李宁"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=86" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072765604121481.jpg" title="康比特"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=106" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072981305868823.jpg" title="开普特"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=122" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073982547710498.jpg" title="Five Plus"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=149" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073591535005714.jpg" title="鸿星尔克"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=152" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490228100138579787.jpg" title="杰克琼斯"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=154" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073529881448780.jpg" title="匡威"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spec" data-spec="{&quot;content&quot;:&quot;&quot;,&quot;cat_goods&quot;:&quot;&quot;,&quot;moded&quot;:&quot;homeFloor&quot;,&quot;cat_id&quot;:6,&quot;cateValue&quot;:[&quot;347&quot;,&quot;630&quot;,&quot;547&quot;,&quot;463&quot;],&quot;typeColor&quot;:&quot;floor-color-type-1&quot;,&quot;floorMode&quot;:1,&quot;brand_ids&quot;:&quot;86,82,79,76,72,106,122,152,149,154&quot;,&quot;leftBanner&quot;:[&quot;data/gallery_album/2/original_img/1494985255671031591.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985255859372374.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985255003388359.jpg&quot;],&quot;leftBannerLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;leftBannerSort&quot;:[&quot;1&quot;,&quot;1&quot;,&quot;1&quot;],&quot;leftAdv&quot;:[&quot;data/gallery_album/2/original_img/1494984993892207941.jpg&quot;,&quot;data/gallery_album/2/original_img/1494984993812175408.jpg&quot;],&quot;leftAdvLink&quot;:[&quot;&quot;,&quot;&quot;],&quot;leftAdvSort&quot;:[&quot;1&quot;,&quot;1&quot;],&quot;rightAdv&quot;:[&quot;data/gallery_album/2/original_img/1494984998972685382.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985261416235695.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985257076782520.png&quot;,&quot;data/gallery_album/2/original_img/1494985255611006354.png&quot;,&quot;data/gallery_album/2/original_img/1494984997173604814.jpg&quot;],&quot;rightAdvLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;rightAdvSort&quot;:[&quot;5&quot;,&quot;1&quot;,&quot;1&quot;,&quot;1&quot;,&quot;1&quot;],&quot;rightAdvTitle&quot;:[&quot;女式套装&quot;,&quot;连衣裙&quot;,&quot;外套&quot;,&quot;随意搭&quot;,&quot;毛衣&quot;],&quot;rightAdvSubtitle&quot;:[&quot;新品低至五折&quot;,&quot;春季流行款抢购&quot;,&quot;大牌好货抢&quot;,&quot;来潮我看&quot;,&quot;满100减100&quot;],&quot;lift&quot;:&quot;女装&quot;}" data-title="undefined"></div></div>
                    </div>
                </div>
                <!--首页楼层-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloor" data-purebox="homeFloor" data-li="1" ectype="visualItme" data-diff="1" style="display: block; position: relative; opacity: 1; z-index: 0; left: 0px; top: 0px;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                            <span class="txt">首页楼层</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="floor-content" data-type="range" id="homeFloor_1" data-lift="鞋靴">

                            <div class="floor-line-con floor-color-type-2" data-title="鞋靴箱包" data-idx="1" id="floor_2" ectype="floorItem">
                                <div class="floor-hd" ectype="floorTit">
                                    <div class="hd-tit">鞋靴、箱包、钟表、奢侈品</div>
                                    <div class="hd-tags">
                                        <ul>
                                            <li class="first current">
                                                <span>新品推荐</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="360">
                                                <span>功能箱包</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="355">
                                                <span>流行男鞋</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="362">
                                                <span>奢侈品</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="353">
                                                <span>时尚女鞋</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="floor-bd bd-mode-02">
                                    <div class="bd-left">
                                        <div class="floor-left-slide">
                                            <div class="bd">
                                                <ul>
                                                    <li><a href=""><img src="/default/2//1494984993525657918.jpg"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985258163076122.jpg"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985258841930385.jpg"></a></li>
                                                </ul>
                                            </div>
                                            <div class="hd"><ul></ul></div>
                                        </div>

                                        <div class="floor-left-adv">
                                            <a href="" target="_blank"><img src="/default/2//1494984994714366758.jpg"></a>
                                            <a href="" target="_blank"><img src="/default/2//1494984994759822929.jpg"></a>
                                        </div>

                                    </div>
                                    <div class="bd-right">
                                        <div class="floor-tabs-content clearfix">
                                            <div class="f-r-main f-r-m-adv">
                                                <div class="f-r-m-item
                                        	 f-r-m-i-double                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>商务出差必备</h3>
                                                            <span>磨砂登机箱</span>
                                                        </div>
                                                        <img src="
                            	                                	                            			/default/2//1494985264048620039.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>防水斜挎包</h3>
                                                            <span>商城自营，闪电发货</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985259325736762.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>欧时纳女包</h3>
                                                            <span>跨万店三免一</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985254984045600.png                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>大牌精选</h3>
                                                            <span>满199减100</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985261810426955.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>纪梵希</h3>
                                                            <span>大牌上新</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1495042209788792159.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_360">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_355">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_362">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_353">
                                                <ul class="p-list"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="floor-fd">
                                    <div class="floor-fd-brand clearfix">
                                        <div class="item">
                                            <a href="brandn.php?id=93" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072850306019115.jpg" title="同庆和堂"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=115" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074006660107941.jpg" title="西门子"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=130" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074180745676140.jpg" title="TP-LINL"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=131" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073919711003101.jpg" title="ZIPPO"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=132" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073900838296364.jpg" title="阿玛尼"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=138" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073717776504773.jpg" title="迪士尼"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=139" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073705755280994.jpg" title="飞科"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=154" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073529881448780.jpg" title="匡威"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=178" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073253749057076.jpg" title="文轩网"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=186" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074308773778697.jpg" title="新百伦"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spec" data-spec="{&quot;content&quot;:&quot;&quot;,&quot;cat_goods&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;moded&quot;:&quot;homeFloor&quot;,&quot;cat_id&quot;:8,&quot;cateValue&quot;:[&quot;360&quot;,&quot;355&quot;,&quot;362&quot;,&quot;353&quot;],&quot;typeColor&quot;:&quot;floor-color-type-2&quot;,&quot;floorMode&quot;:2,&quot;brand_ids&quot;:&quot;154,139,93,130,131,132,186,178,138,115&quot;,&quot;leftBanner&quot;:[&quot;data/gallery_album/2/original_img/1494984993525657918.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985258163076122.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985258841930385.jpg&quot;],&quot;leftBannerLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;leftBannerSort&quot;:[&quot;1&quot;,&quot;1&quot;,&quot;1&quot;],&quot;leftAdv&quot;:[&quot;data/gallery_album/2/original_img/1494984994714366758.jpg&quot;,&quot;data/gallery_album/2/original_img/1494984994759822929.jpg&quot;],&quot;leftAdvLink&quot;:[&quot;&quot;,&quot;&quot;],&quot;leftAdvSort&quot;:[&quot;1&quot;,&quot;1&quot;],&quot;rightAdv&quot;:[&quot;data/gallery_album/2/original_img/1495042209788792159.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985261810426955.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985259325736762.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985254984045600.png&quot;,&quot;data/gallery_album/2/original_img/1494985264048620039.jpg&quot;],&quot;rightAdvLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;rightAdvSort&quot;:[&quot;6&quot;,&quot;5&quot;,&quot;3&quot;,&quot;4&quot;,&quot;1&quot;],&quot;rightAdvTitle&quot;:[&quot;纪梵希&quot;,&quot;大牌精选&quot;,&quot;防水斜挎包&quot;,&quot;欧时纳女包&quot;,&quot;商务出差必备&quot;],&quot;rightAdvSubtitle&quot;:[&quot;大牌上新&quot;,&quot;满199减100&quot;,&quot;商城自营，闪电发货&quot;,&quot;跨万店三免一&quot;,&quot;磨砂登机箱&quot;],&quot;lift&quot;:&quot;鞋靴&quot;}" data-title="undefined"></div></div>
                    </div>
                </div>
                <!--首页楼层-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloor" data-purebox="homeFloor" data-li="1" ectype="visualItme" data-diff="2" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                            <span class="txt">首页楼层</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="floor-content" data-type="range" id="homeFloor_2" data-lift="食品">

                            <div class="floor-line-con floor-color-type-3" data-title="食品酒水" data-idx="1" id="floor_3" ectype="floorItem">
                                <div class="floor-hd" ectype="floorTit">
                                    <div class="hd-tit">食品、酒类、生鲜、特产</div>
                                    <div class="hd-tags">
                                        <ul>
                                            <li class="first current">
                                                <span>新品推荐</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="616">
                                                <span>进口食品</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="623">
                                                <span>生鲜食品</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="615">
                                                <span>中外名酒</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="622">
                                                <span>粮油调味</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="617">
                                                <span>休闲食品</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="floor-bd bd-mode-03">
                                    <div class="bd-left">

                                        <div class="floor-left-adv">
                                            <a href="" target="_blank"><img src="/default/2//1494984995376315298.jpg"></a>
                                            <a href="" target="_blank"><img src="/default/2//1494984995451465490.jpg"></a>
                                        </div>

                                    </div>
                                    <div class="bd-right">
                                        <div class="floor-tabs-content clearfix">
                                            <div class="f-r-main f-r-m-adv">
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>李锦记</h3>
                                                            <span>商城自营好物低价</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985253313357913.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	 f-r-m-i-double                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>金锣火腿肠</h3>
                                                            <span>方便食品</span>
                                                        </div>
                                                        <img src="
                            	                                	                            			/default/2//1494985009349965302.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>酸辣牛肉味五连包</h3>
                                                            <span>五件包39.9选14</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985008433437711.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>香茉莉香米</h3>
                                                            <span>满76香米1KG</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985262035088187.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>魔力紫</h3>
                                                            <span>尽享休闲时光</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985264023870581.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_616">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_623">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_615">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_622">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_617">
                                                <ul class="p-list"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="floor-fd">
                                    <div class="floor-fd-brand clearfix">
                                        <div class="item">
                                            <a href="brandn.php?id=73" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072329183966195.jpg" title="她他/tata"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=81" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072685002270742.jpg" title="宝姿"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=83" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072728394097278.jpg" title="白兰氏"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=102" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072941526335126.jpg" title="欧亚马"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=107" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072993409028193.jpg" title="三星"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=117" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073123533047769.jpg" title="阿尔卡特"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=130" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074180745676140.jpg" title="TP-LINL"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=136" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490227517695746097.jpg" title="博时基金"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=137" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073731822160672.jpg" title="达利园"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=141" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074990110164877.jpg" title="钙尔奇"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spec" data-spec="{&quot;content&quot;:&quot;&quot;,&quot;cat_goods&quot;:&quot;&quot;,&quot;moded&quot;:&quot;homeFloor&quot;,&quot;cat_id&quot;:12,&quot;cateValue&quot;:[&quot;616&quot;,&quot;623&quot;,&quot;615&quot;,&quot;622&quot;,&quot;617&quot;],&quot;typeColor&quot;:&quot;floor-color-type-3&quot;,&quot;floorMode&quot;:3,&quot;brand_ids&quot;:&quot;137,141,136,102,107,73,81,83,117,130&quot;,&quot;leftBanner&quot;:[&quot;&quot;],&quot;leftBannerLink&quot;:[&quot;&quot;],&quot;leftBannerSort&quot;:[&quot;&quot;],&quot;leftAdv&quot;:[&quot;data/gallery_album/2/original_img/1494984995376315298.jpg&quot;,&quot;data/gallery_album/2/original_img/1494984995451465490.jpg&quot;],&quot;leftAdvLink&quot;:[&quot;&quot;,&quot;&quot;],&quot;leftAdvSort&quot;:[&quot;1&quot;,&quot;1&quot;],&quot;rightAdv&quot;:[&quot;data/gallery_album/2/original_img/1494985264023870581.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985262035088187.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985008433437711.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985009349965302.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985253313357913.jpg&quot;],&quot;rightAdvLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;rightAdvSort&quot;:[&quot;5&quot;,&quot;4&quot;,&quot;3&quot;,&quot;2&quot;,&quot;1&quot;],&quot;rightAdvTitle&quot;:[&quot;魔力紫&quot;,&quot;香茉莉香米&quot;,&quot;酸辣牛肉味五连包&quot;,&quot;金锣火腿肠&quot;,&quot;李锦记&quot;],&quot;rightAdvSubtitle&quot;:[&quot;尽享休闲时光&quot;,&quot;满76香米1KG&quot;,&quot;五件包39.9选14&quot;,&quot;方便食品&quot;,&quot;商城自营好物低价&quot;],&quot;lift&quot;:&quot;食品&quot;}" data-title="undefined"></div></div>
                    </div>
                </div>
                <!--首页楼层-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="homeFloor" data-purebox="homeFloor" data-li="1" ectype="visualItme" data-diff="3" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                            <span class="txt">首页楼层</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="floor-content" data-type="range" id="homeFloor_3" data-lift="家用">

                            <div class="floor-line-con floor-color-type-4" data-title="家用电器" data-idx="1" id="floor_4" ectype="floorItem">
                                <div class="floor-hd" ectype="floorTit">
                                    <div class="hd-tit">家用电器</div>
                                    <div class="hd-tags">
                                        <ul>
                                            <li class="first current">
                                                <span>新品推荐</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="1115">
                                                <span>生活电器</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="1129">
                                                <span>厨房电器</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="1145">
                                                <span>个护健康</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                            <li data-catgoods="" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="1160">
                                                <span>五金家装</span>
                                                <i class="arrowImg"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="floor-bd bd-mode-04">
                                    <div class="bd-left">

                                        <div class="floor-left-adv">
                                            <a href="" target="_blank"><img src="/default/2//1494985252213529452.jpg"></a>
                                            <a href="" target="_blank"><img src="/default/2//1494985263907218565.jpg"></a>
                                        </div>

                                        <div class="floor-left-slide">
                                            <div class="bd">
                                                <ul>
                                                    <li><a href=""><img src="/default/2//1494985258768732496.jpg"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985266144681478.png"></a></li>
                                                    <li><a href=""><img src="/default/2//1494985266980557091.png"></a></li>
                                                </ul>
                                            </div>
                                            <div class="hd"><ul></ul></div>
                                        </div>
                                    </div>
                                    <div class="bd-right">
                                        <div class="floor-tabs-content clearfix">
                                            <div class="f-r-main f-r-m-adv">
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>海信55英寸</h3>
                                                            <span>买既得无线鼠标一个</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985010017482916.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>欧景除湿器</h3>
                                                            <span>洗化干衣一体</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985252050215807.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>智能音箱</h3>
                                                            <span>满100减19</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985253347581677.JPG                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	 f-r-m-i-double                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>美的电饭煲</h3>
                                                            <span>给力“实”惠</span>
                                                        </div>
                                                        <img src="
                            	                                	                            			/default/2//1494985267962226313.JPG                                                                                                ">
                                                    </a>
                                                </div>
                                                <div class="f-r-m-item
                                        	                    ">
                                                    <a href="" target="_blank">
                                                        <div class="title">
                                                            <h3>极客系列</h3>
                                                            <span>定金100减300</span>
                                                        </div>
                                                        <img src="
                            	                                	                                        /default/2//1494985260469428998.jpg                                                                                                ">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_1115">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_1129">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_1145">
                                                <ul class="p-list"></ul>
                                            </div>
                                            <div class="f-r-main" ectype="floor_cat_1160">
                                                <ul class="p-list"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="floor-fd">
                                    <div class="floor-fd-brand clearfix">
                                        <div class="item">
                                            <a href="brandn.php?id=72" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072313895957648.jpg" title="ELLE HOME"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=73" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490072329183966195.jpg" title="她他/tata"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=109" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074056964147533.jpg" title="诺基亚"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=110" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074043963552715.jpg" title="松下电器"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=115" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074006660107941.jpg" title="西门子"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=125" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073960166035363.jpg" title="华为"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=130" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490074180745676140.jpg" title="TP-LINL"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=139" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073705755280994.jpg" title="飞科"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=148" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073603108687350.jpg" title="宏基"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="brandn.php?id=150" target="_blank">
                                                <div class="link-l"></div>
                                                <div class="img"><img src="/default/1/1490073577683159021.jpg" title="华帝"></div>
                                                <div class="link"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spec" data-spec="{&quot;content&quot;:&quot;&quot;,&quot;cat_goods&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;moded&quot;:&quot;homeFloor&quot;,&quot;cat_id&quot;:858,&quot;cateValue&quot;:[&quot;1115&quot;,&quot;1129&quot;,&quot;1145&quot;,&quot;1160&quot;],&quot;typeColor&quot;:&quot;floor-color-type-4&quot;,&quot;floorMode&quot;:4,&quot;brand_ids&quot;:&quot;109,72,73,139,150,148,130,110,115,125&quot;,&quot;leftBanner&quot;:[&quot;data/gallery_album/2/original_img/1494985266144681478.png&quot;,&quot;data/gallery_album/2/original_img/1494985258768732496.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985266980557091.png&quot;],&quot;leftBannerLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;leftBannerSort&quot;:[&quot;1&quot;,&quot;1&quot;,&quot;1&quot;],&quot;leftAdv&quot;:[&quot;data/gallery_album/2/original_img/1494985252213529452.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985263907218565.jpg&quot;],&quot;leftAdvLink&quot;:[&quot;&quot;,&quot;&quot;],&quot;leftAdvSort&quot;:[&quot;1&quot;,&quot;1&quot;],&quot;rightAdv&quot;:[&quot;data/gallery_album/2/original_img/1494985010017482916.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985252050215807.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985253347581677.JPG&quot;,&quot;data/gallery_album/2/original_img/1494985260469428998.jpg&quot;,&quot;data/gallery_album/2/original_img/1494985267962226313.JPG&quot;],&quot;rightAdvLink&quot;:[&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;,&quot;&quot;],&quot;rightAdvSort&quot;:[&quot;1&quot;,&quot;2&quot;,&quot;3&quot;,&quot;5&quot;,&quot;4&quot;],&quot;rightAdvTitle&quot;:[&quot;海信55英寸&quot;,&quot;欧景除湿器&quot;,&quot;智能音箱&quot;,&quot;极客系列&quot;,&quot;美的电饭煲&quot;],&quot;rightAdvSubtitle&quot;:[&quot;买既得无线鼠标一个&quot;,&quot;洗化干衣一体&quot;,&quot;满100减19&quot;,&quot;定金100减300&quot;,&quot;给力“实”惠&quot;],&quot;lift&quot;:&quot;家用&quot;}" data-title="undefined"></div></div>
                    </div>
                </div>
                <!--达人专区-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-master" data-purebox="homeAdv" data-li="1" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/9.png"></span>
                            <span class="txt">达人专区</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="master-channel" id="h-master_0" data-type="range" data-lift="达人">

                            <div class="ftit"><h3>达人</h3></div>
                            <div class="master-con">
                                <div class="m-c-item m-c-i-1" style="background:url(/default/2//1494985006295599886.jpg) center center no-repeat;">
                                    <div class="m-c-main">
                                        <div class="title">
                                            <h3>纯棉质品</h3>
                                            <span>把好货带回家</span>
                                        </div>
                                        <a href="" class="m-c-btn" target="_blank">去见识</a>
                                    </div>
                                    <div class="img"><a href="" target="_blank"><img src="/default/2//1494985002918483191.png"></a></div>
                                </div>
                                <div class="m-c-item m-c-i-2" style="background:url(/default/2//1494985006392060862.jpg) center center no-repeat;">
                                    <div class="m-c-main">
                                        <div class="title">
                                            <h3>团购热卖</h3>
                                            <span>每一款都是好货</span>
                                        </div>
                                        <a href="" class="m-c-btn" target="_blank">去见识</a>
                                    </div>
                                    <div class="img"><a href="" target="_blank"><img src="/default/2//1494985002435254172.png"></a></div>
                                </div>
                                <div class="m-c-item m-c-i-3" style="background:url(/default/2//1494985006452127966.jpg) center center no-repeat;">
                                    <div class="m-c-main">
                                        <div class="title">
                                            <h3>团购热卖</h3>
                                            <span>都是好货</span>
                                        </div>
                                        <a href="" class="m-c-btn" target="_blank">去见识</a>
                                    </div>
                                    <div class="img"><a href="" target="_blank"><img src="/default/2//1494985003577610926.png"></a></div>
                                </div>
                                <div class="m-c-item m-c-i-4" style="background:url(/default/2//1494985006427221958.jpg) center center no-repeat;">
                                    <div class="m-c-main">
                                        <div class="title">
                                            <h3>舒适童鞋</h3>
                                            <span>帮宝宝学走路</span>
                                        </div>
                                        <a href="" class="m-c-btn" target="_blank">去见识</a>
                                    </div>
                                    <div class="img"><a href="" target="_blank"><img src="/default/2//1494985003958834850.png"></a></div>
                                </div>
                                <div class="m-c-item m-c-i-5" style="background:url(/default/2//1494985005357290375.jpg) center center no-repeat;">
                                    <div class="m-c-main">
                                        <div class="title">
                                            <h3>双十二运动鞋</h3>
                                            <span>品牌直降</span>
                                        </div>
                                        <a href="" class="m-c-btn" target="_blank">去见识</a>
                                    </div>
                                    <div class="img"><a href="" target="_blank"><img src="/default/2//1494985004056329811.png"></a></div>
                                </div>
                            </div>
                            <div class="spec" data-spec="[{&quot;title&quot;:&quot;纯棉质品&quot;,&quot;subtitle&quot;:&quot;把好货带回家&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985002918483191.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985006295599886.jpg&quot;},{&quot;title&quot;:&quot;团购热卖&quot;,&quot;subtitle&quot;:&quot;每一款都是好货&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985002435254172.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985006392060862.jpg&quot;},{&quot;title&quot;:&quot;团购热卖&quot;,&quot;subtitle&quot;:&quot;都是好货&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985003577610926.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985006452127966.jpg&quot;},{&quot;title&quot;:&quot;舒适童鞋&quot;,&quot;subtitle&quot;:&quot;帮宝宝学走路&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985003958834850.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985006427221958.jpg&quot;},{&quot;title&quot;:&quot;双十二运动鞋&quot;,&quot;subtitle&quot;:&quot;品牌直降&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985004056329811.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985005357290375.jpg&quot;}]" data-title="达人"></div></div>
                    </div>
                </div>
                <!--店铺-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="h-storeRec" data-purebox="homeAdv" data-li="1" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/10.png"></span>
                            <span class="txt">推荐店铺</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="store-channel" id="h-storeRec_0" data-type="range" data-lift="店铺">

                            <div class="ftit"><h3>店铺</h3></div>
                            <div class="rec-store-list">
                                <div class="rec-store-item opacity_img">
                                    <a href="" target="_blank">
                                        <div class="p-img"><img src="/default/2//1494985261279846913.png"></div>
                                        <div class="info">
                                            <div class="s-logo"><div class="img"><img src="/default/2//1494985267980096546.png"></div></div>
                                            <div class="s-title">
                                                <div class="tit">美宝莲</div>
                                                <div class="ui-tit">纽约高潮街装次标题</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="rec-store-item opacity_img">
                                    <a href="" target="_blank">
                                        <div class="p-img"><img src="/default/2//1494985257347489575.png"></div>
                                        <div class="info">
                                            <div class="s-logo"><div class="img"><img src="/default/2//1494985265619204005.png"></div></div>
                                            <div class="s-title">
                                                <div class="tit">三只松鼠</div>
                                                <div class="ui-tit">就是这个味次标题</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="rec-store-item opacity_img">
                                    <a href="" target="_blank">
                                        <div class="p-img"><img src="/default/2//1494985254811159847.png"></div>
                                        <div class="info">
                                            <div class="s-logo"><div class="img"><img src="/default/2//1494985265516324065.png"></div></div>
                                            <div class="s-title">
                                                <div class="tit">绿联旗舰店</div>
                                                <div class="ui-tit">给生活多点色彩次标题</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="rec-store-item opacity_img">
                                    <a href="" target="_blank">
                                        <div class="p-img"><img src="/default/2//1494985263326444094.png"></div>
                                        <div class="info">
                                            <div class="s-logo"><div class="img"><img src="/default/2//1494985267537609679.jpg"></div></div>
                                            <div class="s-title">
                                                <div class="tit">韩都衣舍</div>
                                                <div class="ui-tit">满249减50次标题</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="spec" data-spec="[{&quot;title&quot;:&quot;美宝莲&quot;,&quot;subtitle&quot;:&quot;纽约高潮街装&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985261279846913.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985267980096546.png&quot;},{&quot;title&quot;:&quot;三只松鼠&quot;,&quot;subtitle&quot;:&quot;就是这个味&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985257347489575.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985265619204005.png&quot;},{&quot;title&quot;:&quot;绿联旗舰店&quot;,&quot;subtitle&quot;:&quot;给生活多点色彩&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985254811159847.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985265516324065.png&quot;},{&quot;title&quot;:&quot;韩都衣舍&quot;,&quot;subtitle&quot;:&quot;满249减50&quot;,&quot;url&quot;:&quot;&quot;,&quot;original_img&quot;:&quot;data/gallery_album/2/original_img/1494985263326444094.png&quot;,&quot;homeAdvBg&quot;:&quot;data/gallery_album/2/original_img/1494985267537609679.jpg&quot;}]" data-title="店铺"></div></div>
                    </div>
                </div>
                <!--还没逛够-->
                <div class="visual-item lyrow w1200 ui-draggable" data-mode="guessYouLike" data-purebox="goods" ectype="visualItme" data-diff="0" style="display: block;">
                    <div class="drag ui-draggable-handle ui-sortable-handle" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/images/visual/navLeft_03.png"></span>
                            <span class="txt">还没逛够</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1 disabled"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">
                        <div class="lift-channel clearfix" id="guessYouLike" data-type="range" data-lift="商品">
                            <div data-goodstitle="title"><div class="ftit"><h3>还没逛够</h3></div></div>
                            <ul>

                                <li class="opacity_img">
                                    <a href="goods.php?id=620">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489098265067.jpg"></div>
                                        <div class="p-name" title="新品HYC 2k显示器32寸电脑显示器无边框HDMI液晶显示器IPS显示屏 2K高清屏IPS 超薄 厚6mm 无边框">新品HYC 2k显示器32寸电脑显示器无边框HDMI液晶显示器IPS显示屏 2K高清屏IPS 超薄 厚6mm 无边框</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>1500.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=621">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489098360804.jpg"></div>
                                        <div class="p-name" title="三星C24F396FH曲面显示器23.5英寸电脑显示器24液晶显示屏幕超22">三星C24F396FH曲面显示器23.5英寸电脑显示器24液晶显示屏幕超22</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>2200.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=622">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489098597912.jpg"></div>
                                        <div class="p-name" title="Apple/苹果 27” Retina 5K显示屏 iMac:3.3GHz处理器2TB存储">Apple/苹果 27” Retina 5K显示屏 iMac:3.3GHz处理器2TB存储</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>8999.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=624">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489099128797.jpg"></div>
                                        <div class="p-name" title="名龙堂i7 6700升7700 GTX1060 6G台式电脑主机DIY游戏组装整机 升6GB独显 送正版WIN10 一年上门">名龙堂i7 6700升7700 GTX1060 6G台式电脑主机DIY游戏组装整机 升6GB独显 送正版WIN10 一年上门</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>4300.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=625">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489099437211.jpg"></div>
                                        <div class="p-name" title="秋季新款男士套头卫衣印花外套韩版简约百搭潮流男生上衣服">秋季新款男士套头卫衣印花外套韩版简约百搭潮流男生上衣服</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>120.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=627">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489099773629.jpg"></div>
                                        <div class="p-name" title="2017春装新款男士卫衣套头圆领韩版潮流时尚男生休闲外套">2017春装新款男士卫衣套头圆领韩版潮流时尚男生休闲外套</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>200.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=633">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489102299856.jpg"></div>
                                        <div class="p-name" title="新款学院风韩版时尚太空棉宽松长袖印花圆领卫衣女">新款学院风韩版时尚太空棉宽松长袖印花圆领卫衣女</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>233.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=634">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489102753231.jpg"></div>
                                        <div class="p-name" title="新款韩版chic学生宽松短款外套上衣字母长袖连帽套头卫衣女潮">新款韩版chic学生宽松短款外套上衣字母长袖连帽套头卫衣女潮</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>300.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=635">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489102950633.jpg"></div>
                                        <div class="p-name" title="韩都衣舍2017韩版女装新款黑白拼接插肩棒球服春季短外套HH5597妠 朴信惠同款 黑白拼接 插肩袖 棒球服">韩都衣舍2017韩版女装新款黑白拼接插肩棒球服春季短外套HH5597妠 朴信惠同款 黑白拼接 插肩袖 棒球服</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>450.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=636">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489103412794.jpg"></div>
                                        <div class="p-name" title="The Face Shop 水光无瑕气垫CC霜 裸妆隔离保湿补水持久遮瑕强 韩式裸妆 打造水嫩遮瑕 光润亮彩">The Face Shop 水光无瑕气垫CC霜 裸妆隔离保湿补水持久遮瑕强 韩式裸妆 打造水嫩遮瑕 光润亮彩</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>222.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=637">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489103674623.jpg"></div>
                                        <div class="p-name" title="一叶子补水面膜女保湿控油深层清洁收毛孔护肤面膜贴套装专柜正品 补水保湿 清洁控油">一叶子补水面膜女保湿控油深层清洁收毛孔护肤面膜贴套装专柜正品 补水保湿 清洁控油</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>330.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=638">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489104168209.jpg"></div>
                                        <div class="p-name" title="美宝莲绝色持久唇膏 粉红警报 魅惑炫亮润泽 唇彩口红">美宝莲绝色持久唇膏 粉红警报 魅惑炫亮润泽 唇彩口红</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>520.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=639">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489104534699.jpg"></div>
                                        <div class="p-name" title="美宝莲绝色持久唇膏 粉红警报 魅惑炫亮润泽 唇彩口红">美宝莲绝色持久唇膏 粉红警报 魅惑炫亮润泽 唇彩口红</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>300.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=640">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489104621775.jpg"></div>
                                        <div class="p-name" title="花美时三合一自动旋转双头眉笔眉粉染眉膏画眉持久防水防汗不脱色 防水防汗 持久不晕染 正品包邮">花美时三合一自动旋转双头眉笔眉粉染眉膏画眉持久防水防汗不脱色 防水防汗 持久不晕染 正品包邮</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>200.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=642">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489104935834.jpg"></div>
                                        <div class="p-name" title="一叶子面膜女补水保湿收缩毛孔控油玻尿酸面膜专柜正品 共28片">一叶子面膜女补水保湿收缩毛孔控油玻尿酸面膜专柜正品 共28片</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>80.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=644">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489105021484.jpg"></div>
                                        <div class="p-name" title="欧莱雅男士水能保湿化妆护肤品套装深层补水滋润洗面奶爽肤水乳液">欧莱雅男士水能保湿化妆护肤品套装深层补水滋润洗面奶爽肤水乳液</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>60.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=645">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489105083498.jpg"></div>
                                        <div class="p-name" title="杰威尔发胶定型喷雾男士干胶头发持久定型造型啫喱水发蜡蓬松清香 快速定型，蓬松清香，不起白屑，买2送1">杰威尔发胶定型喷雾男士干胶头发持久定型造型啫喱水发蜡蓬松清香 快速定型，蓬松清香，不起白屑，买2送1</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>110.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=646">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489105134405.jpg"></div>
                                        <div class="p-name" title="美的电磁炉Midea/美的 WK2102电磁炉特价家用触摸屏电池炉灶正品 已爆售百万多台 防滑触摸屏 一键爆炒">美的电磁炉Midea/美的 WK2102电磁炉特价家用触摸屏电池炉灶正品 已爆售百万多台 防滑触摸屏 一键爆炒</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>455.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=647">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489105175252.jpg"></div>
                                        <div class="p-name" title="志高嵌入式电陶炉家用双头双灶镶嵌式电磁炉双眼光波炉特价正品 不挑锅可烧烤 三环猛火 嵌入式双灶">志高嵌入式电陶炉家用双头双灶镶嵌式电磁炉双眼光波炉特价正品 不挑锅可烧烤 三环猛火 嵌入式双灶</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>488.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                                <li class="opacity_img">
                                    <a href="goods.php?id=648">
                                        <div class="p-img"><img src="http://localhost/new_source/images/201703/thumb_img/0_thumb_G_1489105257655.jpg"></div>
                                        <div class="p-name" title="Midea/美的 MB-WFS5017TM电饭煲5L智能正品电饭锅家用3-4-6-7-8人 下单立减20 精研柴火饭 涡轮防溢">Midea/美的 MB-WFS5017TM电饭煲5L智能正品电饭锅家用3-4-6-7-8人 下单立减20 精研柴火饭 涡轮防溢</div>
                                        <div class="p-price">
                                            <div class="shop-price">
                                                <em>¥</em>300.00                            </div>
                                            <div class="original-price"></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="spec" data-spec="{&quot;goods_ids&quot;:&quot;620,621,622,624,625,627,633,634,635,638,639,640,637,636,642,644,645,646,647,648&quot;,&quot;cat_name&quot;:&quot;还没逛够&quot;,&quot;is_title&quot;:&quot;1&quot;}"></div></div>
                    </div>
                </div>
                <!--测试区-->
                <div class="visual-item lyrow w1200  ui-draggable" data-mode="cust" data-purebox="cust" ectype="visualItme" style="display: block;">
                    <div class="drag" data-html="not">
                        <div class="navLeft">
                            <span class="pic"><img src="/default/icon/baby.png"></span>
                            <span class="txt">测试区</span>
                        </div>
                        <div class="setup_box">
                            <div class="barbg"></div>
                            <a href="javascript:void(0);" class="move-up iconfont icon-up1"></a>
                            <a href="javascript:void(0);" class="move-down iconfont icon-down1 disabled"></a>
                            <a href="javascript:void(0);" class="move-edit" ectype="model_edit"><i class="iconfont icon-edit1"></i>编辑</a>
                            <a href="javascript:void(0);" class="move-remove"><i class="iconfont icon-remove-alt"></i>删除</a>
                        </div>
                    </div>
                    <div class="view">

                        <div class="adv_module">
                            <div class="hd"><ul></ul></div>
                            <div class="bd">
                                <ul data-type="range">
                                    <li><a href=""><img class="advPictures" src="/default/visualDefault/ad_01_pic.jpg"></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>                                                                                                                                                                        </div>
    </div>

    <div class="df_hidden">
        <input name="suffix" value="backup_tpl_1" data-section="vis_home" type="hidden">
        <div id="preview-layout"></div>
        <div id="head-layout"></div>
        <div id="topBanner-layout"></div>
    </div>
</div>

<div id="layer"></div>