DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`is_freeze` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0-否 1-是',
	`created_at` datetime NOT NULL COMMENT '创建时间',
	`created_by` int(10) NOT NULL DEFAULT '0' COMMENT '创建人',
	`updated_at` datetime NOT NULL COMMENT '更新时间',
	`updated_by` int(10) NOT NULL DEFAULT '0' COMMENT '更新人',
	`user_name` varchar(32) NOT NULL COMMENT '账号',
	`password` varchar(100) DEFAULT NULL COMMENT '密码',
	`real_name` varchar(32) DEFAULT NULL COMMENT '真实姓名',
	`sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0-保密 1-男 2-女',
	`mobile` varchar(16) DEFAULT NULL COMMENT '手机号',
	`email` varchar(32) DEFAULT NULL COMMENT '邮件',
	`last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
	`is_super` tinyint(1) DEFAULT '0' COMMENT '是否为超级管理员',
  `avatar` varchar(500) DEFAULT '' COMMENT '头像',
	PRIMARY KEY (`id`),
	UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';
insert into admin_user(created_at,updated_at,user_name,password,real_name,is_super)
value(now(),now(),'admin','$2y$10$3Jiq1ebcHWRzi5GjIFEgYutuQdRUZ0cUd67HhuuEkxKCgrsBAwUJm','超级管理员',1);

DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`admin_id` int(10) NOT NULL COMMENT '会员ID',
	`real_name` varchar(60) NOT NULL DEFAULT '' COMMENT '真实名',
  `log_time` datetime NOT NULL COMMENT '日志时间',
  `ip_address` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志表';

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登录用户名(手机)',
	`nick_name` varchar(60) NOT NULL DEFAULT '' COMMENT '昵称',
	`password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `avatar` varchar(500) NOT NULL DEFAULT '' COMMENT '用户头像',

  `contactName` varchar(255) NOT NULL DEFAULT '' COMMENT '负责人姓名',
  `contactPhone` varchar(255) NOT NULL DEFAULT '' COMMENT '负责人手机',
  `attorney_letter_fileImg` varchar(255) NOT NULL DEFAULT '' COMMENT '授权委托书电子版',

  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员可用金额',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员冻结金额',
  `points` int(10) NOT NULL DEFAULT '0' COMMENT '会员积分',
  `address_id` int(10) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `is_validated` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否通过审核 0-否 1-是',
  `is_firm` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否企业用户 0-否 1-是',
  `is_freeze` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0-否 1-是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_log` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`user_id` int(10) NOT NULL COMMENT '会员ID',
	`admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `log_time` datetime NOT NULL COMMENT '日志时间',
  `ip_address` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员日志表';

DROP TABLE IF EXISTS `user_paypwd`;
CREATE TABLE `user_paypwd` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `pay_password` varchar(100) NOT NULL DEFAULT '' COMMENT '支付密码',
  `pay_online` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '在线支付',
  `user_surplus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '余额支付',
  `user_point` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '积分支付',
  `baitiao` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '白条支付',
  `gift_card` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '礼品卡支付',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员支付密码';

DROP TABLE IF EXISTS `user_real`;
CREATE TABLE `user_real` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `real_name` varchar(60) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0-保密 1-男 2-女',
  `birthday` varchar(10) NOT NULL DEFAULT '' COMMENT '生日',
  `front_of_id_card` varchar(60) NOT NULL DEFAULT '' COMMENT '身份证正面',
  `reverse_of_id_card` varchar(60) NOT NULL DEFAULT '' COMMENT '身份证反面',

  `business_license_id` varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照注册号',
  `license_fileImg` varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照副本电子版',
  `taxpayer_id` varchar(255) NOT NULL DEFAULT '' COMMENT '纳税人识别号',

  `add_time` datetime NOT NULL COMMENT '添加时间',
  `review_content` varchar(200) NOT NULL DEFAULT '' COMMENT '审核意见',
  `review_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0-待审核 1-已审核 2-审核不通过',
  `review_time` datetime DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员实名';

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `address_name` varchar(50) NOT NULL DEFAULT '' COMMENT '地址别名',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `country` smallint(5) NOT NULL DEFAULT '0' COMMENT '国家',
  `province` smallint(5) NOT NULL DEFAULT '0' COMMENT '省',
  `city` smallint(5) NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(5) NOT NULL DEFAULT '0' COMMENT '县',
  `street` smallint(5) NOT NULL DEFAULT '0' COMMENT '街道',
  `address` varchar(120) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zipcode` varchar(60) NOT NULL DEFAULT '' COMMENT '邮编',
  `mobile_phone` varchar(60) NOT NULL DEFAULT '' COMMENT '电话或手机',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址表';

DROP TABLE IF EXISTS `user_invoices`;
CREATE TABLE `user_invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `company_name` varchar(60) NOT NULL DEFAULT '' COMMENT '公司抬头',
  `tax_id` varchar(20) NOT NULL DEFAULT '' COMMENT '税号',
  `bank_of_deposit` varchar(20) NOT NULL DEFAULT '' COMMENT '开户银行',
  `bank_account` varchar(30) NOT NULL DEFAULT '' COMMENT '银行账号',
  `company_address` varchar(255) NOT NULL DEFAULT '' COMMENT '开票地址',
  `company_telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '开票电话',
  `consignee_name` varchar(20) NOT NULL DEFAULT '' COMMENT '收票人',
  `consignee_mobile_phone` varchar(15) NOT NULL DEFAULT '' COMMENT '收票人电话',
  `country` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收票地址-国家',
  `province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收票地址-省',
  `city` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收票地址-市',
  `district` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收票地址-县',
  `street` smallint(5) NOT NULL DEFAULT '0' COMMENT '收票地址-街道',
  `consignee_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收票地址-详细地址',
  `audit_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0-待审核 1-已审核',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `audit_status` (`audit_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员发票';

DROP TABLE IF EXISTS `user_account_log`;
CREATE TABLE `user_account_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户ID',
  `deposit_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更可用余额',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更冻结金额',
  `points` int(10) NOT NULL DEFAULT '0' COMMENT '变更积分',
  `change_time` datetime NOT NULL COMMENT '变更时间',
  `change_desc` varchar(255) NOT NULL COMMENT '描述',
  `change_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '改变类型 0-充值 1-提现 2-冻结 99-增加积分 ',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员资金日志表';

DROP TABLE IF EXISTS `firm_blacklist`;
CREATE TABLE `firm_blacklist` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_name` varchar(60) NOT NULL DEFAULT '' COMMENT '企业名称',
	`taxpayer_id` varchar(255) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业黑名单表';

DROP TABLE IF EXISTS `firm_stock`;
CREATE TABLE `firm_stock` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_id` int(10) NOT NULL COMMENT '会员ID',
	`goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
	`goods_name` varchar(100) NOT NULL COMMENT '商品名称',
	`number` int(10) NOT NULL DEFAULT 0 COMMENT '库存数',
  PRIMARY KEY (`id`),
  KEY `firm_id` (`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业库存表';

DROP TABLE IF EXISTS `firm_stock_flow`;
CREATE TABLE `firm_stock_flow` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_id` int(10) NOT NULL COMMENT '企业会员ID',
	`partner_name` varchar(50) NOT NULL DEFAULT '' COMMENT '业务伙伴名称',
	`flow_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '流水类型 1-平台购物入库 2-其它入库 3-库存出库',
	`goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
	`goods_name` varchar(100) NOT NULL COMMENT '商品名称',
	`number` int(10) NOT NULL COMMENT '出入库数量',
  `flow_desc` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `flow_time` datetime NOT NULL COMMENT '流水时间',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `created_by` int(10) NOT NULL DEFAULT 0 COMMENT '创建人ID',
  PRIMARY KEY (`id`),
  KEY `firm_id` (`firm_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业库存流水表';

DROP TABLE IF EXISTS `firm_user`;
CREATE TABLE `firm_user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_id` int(10) NOT NULL COMMENT '企业会员ID',
	`user_id` int(10) NOT NULL COMMENT '个人会员ID',
	`real_name` varchar(20) NOT NULL DEFAULT '' COMMENT '员工真实姓名',
	`can_po` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能采购 0-否 1-是',
	`can_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能付款 0-否 1-是',
	`can_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能确认收货 0-否 1-是',
	`can_stock_in` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能其他入库 0-否 1-是',
	`can_stock_out` tinyint(1) NOT NULL DEFAULT '0' COMMENT '能库存出库 0-否 1-是',
  PRIMARY KEY (`id`),
  KEY `firm_id` (`firm_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业用户表';

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `region_name` varchar(120) NOT NULL DEFAULT '' COMMENT '名称',
  `region_type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '层级 0为国家级',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`),
  KEY `region_name` (`region_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='省市区数据表';

DROP TABLE IF EXISTS `user_collect_goods`;
CREATE TABLE `user_collect_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) NOT NULL COMMENT '会员ID',
  `goods_id` int(10) NOT NULL COMMENT '商品ID',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `is_attention` (`is_attention`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收藏表';


DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '编码',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '输入类型',
  `store_range` varchar(255) NOT NULL DEFAULT '' COMMENT '存储值范围',
  `store_dir` varchar(255) NOT NULL DEFAULT '' COMMENT '存储路径',
  `name` varchar(50) NOT NULL COMMENT '展示名称',
  `value` text NOT NULL COMMENT '值',
  `config_desc` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `config_group` varchar(250) NOT NULL DEFAULT '' COMMENT '配置组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统设置表';
insert into sys_config(parent_id,code,type,store_range,store_dir,name,value,config_desc,config_group) VALUES
(0, 'shop_info', 'group','','','平台信息','','',''),
(0, 'basic', 'group','','','基本信息','','',''),
(0, 'display', 'group','','','显示设置','','',''),
(0, 'shopping_flow', 'group','','','购物设置','','',''),
(0, 'path', 'group','','','路径设置','','',''),
(1, 'shop_name', 'text','','','平台名称','','',''),
(1, 'shop_title', 'text','','','商店标题','','商店的标题将显示在浏览器的标题栏',''),
(1, 'shop_desc', 'text','','','商店描述','','',''),
(1, 'shop_keywords', 'text','','','商店关键字','','',''),
(1, 'service_phone', 'text','','','客服电话','4000-000-000','',''),
(1, 'service_email', 'text','','','客服邮箱','kefu@company.com','',''),
(1, 'shop_closed', 'select','0|否,1|是','','暂时关闭网站','0','',''),
(1, 'close_comment', 'textarea','','','关闭的原因','','',''),
(1, 'shop_logo', 'file','','../logo/images/','商店 Logo','../logo/images/logo.gif','',''),
(1, 'individual_reg_closed', 'select','0|否,1|是','','是否关闭个人注册','0','',''),
(1, 'individual_reg_check', 'select','0|否,1|是','','个人注册是否需要审核','0','',''),
(1, 'individual_trade_closed', 'select','0|否,1|是','','是否关闭个人交易','1','',''),
(1, 'firm_reg_closed', 'select','0|否,1|是','','是否关闭企业注册','0','',''),
(1, 'firm_reg_check', 'select','0|否,1|是','','企业注册是否需要审核','1','',''),
(1, 'firm_trade_closed', 'select','0|否,1|是','','是否关闭企业交易','0','关闭企业交易，则企业用户只能查看产品',''),
(1, 'firm_stock_closed', 'select','0|否,1|是','','是否关闭企业库存管理','0','',''),
(1, 'shop_must_firm', 'select','0|否,1|是','','开店必须是企业会员','0','',''),
(1, 'shop_reg_closed', 'select','0|否,1|是','','是否关闭店铺入驻','0','',''),
(1, 'shop_reg_check', 'select','0|否,1|是','','店铺入驻是否需要审核','1','',''),
(1, 'copyright', 'text','','','版权','© 2018-2019 塑创电商 版权所有','',''),
(1, 'powered_by ', 'text','','','技术支持','塑创电商','',''),
(1, 'admin_template', 'select','default|默认','','管理后台模板','default','',''),
(1, 'template', 'select','default|默认','','会员模板','default','',''),
(1, 'shop_template', 'select','default|默认','','商户后台模板','default','',''),
(2, 'icp_number', 'text','','','ICP证书或ICP备案证书号','ICP00000123','',''),
(2, 'icp_file', 'file','','../cert/','ICP 备案证书文件','','',''),
(2, 'stats_code', 'textarea','','','统计代码','','您可以将其他访问统计服务商提供的代码添加到每一个页面。',''),
(2, 'individual_register_points', 'text','','','个人注册赠送积分','0','',''),
(2, 'firm_register_points', 'text','','','企业注册赠送积分','0','',''),
(2, 'upload_size_limit', 'select','0|不限,64|64KB,128|128KB,256|256KB,512|512KB,1024|1M,2048|2M,4096|4M','','附件上传大小','64','',''),
(2, 'visit_stats', 'select','0|关闭,1|开启','','站点访问统计','1','',''),
(2, 'goods_sn_prefix', 'text','','','产品编码前缀','P','',''),
(3, 'search_keywords', 'text','','','首页搜索的关键字','周大福,内衣,Five Plus,手机','首页显示的搜索关键字,请用半角逗号(,)分隔多个关键字',''),
(3, 'date_format', 'text','','','日期格式','Y-m-d','',''),
(3, 'time_format', 'text','','','时间格式','Y-m-d H:i:s','',''),
(3, 'currency_format', 'text','','','货币格式','<em>¥</em>%s','',''),
(4, 'stock_dec_time', 'select','1|加入购物车,2|下单时,3|付款时,4|发货时','','减库存时机','2','',''),
(5, 'site_domain', 'text','','','网站域名','','请输入您当前网站的域名，避免资源找不到（如：http://www.xxxx.com/）',''),
(5, 'article_path', 'text','','','文章资源路径','../article','',''),
(5, 'friend_link_path', 'text','','','友情链接路径','../friend_link','',''),
(5, 'firm_path', 'text','','','企业资质路径','../firm','','');

CREATE TABLE `friend_link` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `link_name` varchar(255) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接URL',
  `link_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '链接logo',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接';
insert into friend_link(link_name,link_url,link_logo)
VALUE('塑米城','http://www.sumibuy.com','');

CREATE TABLE `nav` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `is_show` tinyint(1) NOT NULL COMMENT '是否显示 0-否 1-是',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `opennew` tinyint(1) NOT NULL COMMENT '是否新窗口 0-否 1-是',
  `url` varchar(255) NOT NULL COMMENT '链接地址',
  `type` varchar(10) NOT NULL COMMENT '显示位置 top-顶部 middle-中间 bottom-底部',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `is_show` (`is_show`),
  KEY `sort_order` (`sort_order`),
  KEY `opennew` (`opennew`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='导航栏设置表';

CREATE TABLE `seo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL COMMENT '关键词',
  `description` text NOT NULL COMMENT '描述',
  `type` varchar(20) NOT NULL COMMENT '类型',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='SEO设置表';
insert into seo(title,keywords,description,type) VALUES
('首页', '首页','首页','index'),
('文章分类列表', '文章分类列表','文章分类列表','article'),
('文章内容', '文章内容','文章内容','article_content'),
('商品', '商品','商品','goods'),
('品牌', '品牌','品牌','brand_list'),
('品牌商品列表', '品牌商品列表','品牌商品列表','brand'),
('分类', '分类','分类','category'),
('搜索', '搜索','搜索','search');

CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cat_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '文章分类ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `content` longtext NOT NULL COMMENT '正文',
  `author` varchar(30) NOT NULL DEFAULT '' COMMENT '作者',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示 0-否 1-是',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '外部链接',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `sort_order` smallint(8) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `is_show` (`is_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';
insert into article(cat_id,title,content,author,keywords,add_time,file_url) VALUES
(4,'订购方式','','','', now(), 'http://'),
(4,'购物流程','','','', now(), 'http://'),
(4,'售后流程','','','', now(), 'http://'),
(5,'上门自提','','','', now(), 'http://'),
(5,'支付方式说明','','','', now(), 'http://'),
(5,'配送支持','','','', now(), 'http://'),
(6,'联系方式','','','', now(), 'http://'),
(6,'网站故障报告','','','', now(), 'http://'),
(6,'投诉与建议','','','', now(), 'http://'),
(6,'我的订单','','','', now(), 'http://'),
(6,'我的收藏','','','', now(), 'http://'),
(7,'产品质量保障','','','', now(), 'http://'),
(7,'售后服务保障','','','', now(), 'http://'),
(7,'退换货原则','','','', now(), 'http://');

CREATE TABLE `article_cat` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cat_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `parent_id` (`parent_id`),
  KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类表';
insert into article_cat(cat_name,sort_order,parent_id) VALUES
('帮助中心', '1','0'),
('新闻中心', '1','0'),
('系统分类', '1','1'),
('新手上路', '1','3'),
('配送与支付', '2','3'),
('联系我们', '3','3'),
('会员中心', '4','3'),
('服务保证', '5','3'),
('发票问题', '1','1');




DROP TABLE IF EXISTS `goods_category`;
CREATE TABLE `goods_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cat_name` varchar(90) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类ID',
  `sort_order` smallint(8) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_nav_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示在导航条 0-否 1-是',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示 0-否 1-是',
  `cat_icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `is_top_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否在顶级分类页显示 0-否 1-是',
  `category_links` varchar(200) NOT NULL DEFAULT '' COMMENT '分类链接',
  `cat_alias_name` varchar(90) NOT NULL DEFAULT '' COMMENT '分类别名，多个之间用|分隔',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `is_show` (`is_show`),
  KEY `cat_name` (`cat_name`),
  KEY `is_nav_show` (`is_nav_show`),
  KEY `is_top_show` (`is_top_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品分类表';
INSERT INTO goods_category(id, cat_name, parent_id) VALUES
(1, '维生素', 0),
(2, '微量元素', 0),
(3, '氨基酸', 0),
(4, '饲料添加剂', 0),
(5, '复合维生素', 1),
(6, '维生素A', 1),
(7, '维生素B1', 1),
(8, '维生素C', 1),
(9, '维生素D3', 1),
(10, '维生素E', 1),
(11, '维生素K3', 1),
(12, '氯化胆碱', 1),
(13, '氧化镁', 2),
(14, '氧化锌', 2),
(15, '赖氨基', 3),
(16, '蛋氨基', 3),
(17, '苏氨基', 3),
(18, '催情剂', 4),
(19, '代乳剂', 4);

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `brand_first_char` char(1) NOT NULL COMMENT '品牌首字母',
  `brand_logo` varchar(80) NOT NULL DEFAULT '' COMMENT '品牌logo',
  `brand_desc` text NOT NULL COMMENT '品牌简介',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `brand_name` (`brand_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品品牌表';
INSERT INTO brand(id, brand_name, brand_first_char, brand_desc, add_time) VALUES
(1, '新和成', 'X', '', now()),
(2, '花园', 'H', '', now()),
(3, '天力兴农', 'T', '', now()),
(4, '优利宝', 'Y', '', now()),
(5, '天新', '', '', now());

DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `unit_name` varchar(60) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单位表';
INSERT INTO unit(id, unit_name, add_time) value(1, 'KG', now());

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `attr_name` varchar(60) NOT NULL DEFAULT '' COMMENT '属性名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `attr_name` (`attr_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性表';
INSERT INTO attribute(id, attr_name) VALUES
(1, '含量'),
(2, '保质期');

DROP TABLE IF EXISTS `attribute_value`;
CREATE TABLE `attribute_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` varchar(60) NOT NULL DEFAULT '' COMMENT '属性值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性值表';
INSERT INTO attribute_value(id, attr_id, attr_value) VALUES
(1, 1, '100%'),
(2, 1, '50万 IU/g'),
(3, 1, '100万 IU/g'),
(4, 2, '12个月'),
(5, 2, '18个月'),
(6, 1, '99%');

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `goods_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '产品编码',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '产品名称',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词，多个用|分隔',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `brand_name` varchar(60) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `unit_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '单位ID',
  `unit_name` varchar(15) NOT NULL DEFAULT 'KG' COMMENT '单位名称',
  `goods_model` varchar(50) NOT NULL DEFAULT '' COMMENT '产品型号',
  `packing_spec` int NOT NULL DEFAULT 1 COMMENT '包装规格',
  `packing_unit` varchar(20) NOT NULL DEFAULT '包' COMMENT '包装单位',
  `goods_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '产品小图',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '产品大图',
  `original_img` varchar(255) NOT NULL DEFAULT '' COMMENT '产品原图',
  `goods_attr_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '产品属性id值 属性名_属性值，多个之间用;分隔 如:1_12',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '产品属性,中文，颜色:红， 多个之间用;分隔',
  `goods_desc` text NOT NULL COMMENT 'PC商品详情',
  `desc_mobile` text NOT NULL COMMENT '移动端商品详情',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `goods_weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '产品重量',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 0-否 1-是',
  `last_update` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `goods_sn` (`goods_sn`),
  KEY `cat_id` (`cat_id`),
  KEY `brand_id` (`brand_id`),
  KEY `is_delete` (`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表';
INSERT INTO goods(id, cat_id, goods_sn, goods_name, brand_id, brand_name, unit_id, unit_name, goods_model, packing_spec, packing_unit, goods_attr_ids, goods_attr, goods_desc, desc_mobile, market_price, add_time, last_update) VALUES
(1, 5, 'P000001', '蛋鸡维生素', 4, '优利保', 1, 'KG', '', '10', '桶', ';1_1;', '含量:100%', 'PC详情', '移动端详情','1500', now(), now()),
(2, 6, 'P000002', '饲料级维生素A', 1, '新和成', 1, 'KG', '', '25', '箱', ';1_2;', '含量:50万 IU/g', 'PC详情', '移动端详情','800', now(), now()),
(3, 7, 'P000003', '饲料级维生素B1', 5, '天新', 1, 'KG', '', '25', '箱', ';1_6;', '含量:99%', 'PC详情', '移动端详情','600', now(), now()),
(4, 8, 'P000001', '饲料级维生素C', 3, '天力兴农', 1, 'KG', '', '25', '桶', ';1_1;', '含量:100%', 'PC详情', '移动端详情','1500', now(), now());

DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`user_id` int(10) NOT NULL DEFAULT '0' COMMENT '会员ID',
	`shop_name` varchar(60) NOT NULL DEFAULT '' COMMENT '店铺名称',
	`company_name` varchar(60) NOT NULL DEFAULT '' COMMENT '企业全称',
  `contactName` varchar(255) NOT NULL DEFAULT '' COMMENT '负责人姓名',
  `contactPhone` varchar(255) NOT NULL DEFAULT '' COMMENT '负责人手机',
  `attorney_letter_fileImg` varchar(255) NOT NULL DEFAULT '' COMMENT '授权委托书电子版',
  `business_license_id` varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照注册号',
  `license_fileImg` varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照副本电子版',
  `taxpayer_id` varchar(255) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `is_validated` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否通过审核 0-否 1-是',
  `is_freeze` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0-否 1-是',
  `is_self_run` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否自营 0-否 1-是',
	PRIMARY KEY (`id`),
	UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='入驻店铺表';
INSERT INTO shop(id, shop_name, company_name, reg_time, is_validated, is_self_run)
VALUE(1, '塑创电商', '上海塑创电子商务有限公司', now(), 1, 1);

DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE `shop_user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',
	`user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登录用户名',
	`password` varchar(60) NOT NULL DEFAULT '' COMMENT '密码',
  `add_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `is_super` tinyint(1) DEFAULT '0' COMMENT '是否为店铺管理员',
	PRIMARY KEY (`id`),
	UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺职员表';
INSERT INTO shop_user(id, shop_id, user_name, password, add_time, is_super)
VALUE(1, 1, 'suchuang', '$2y$10$3Jiq1ebcHWRzi5GjIFEgYutuQdRUZ0cUd67HhuuEkxKCgrsBAwUJm', now(), 1);

DROP TABLE IF EXISTS `shop_log`;
CREATE TABLE `shop_log` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`shop_id` int(10) NOT NULL COMMENT '店铺ID',
	`shop_user_id` int(10) NOT NULL DEFAULT 0 COMMENT '店铺职员ID',
	`admin_id` int(10) NOT NULL DEFAULT 0 COMMENT '管理员ID',
  `log_time` datetime NOT NULL COMMENT '日志时间',
  `ip_address` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `shop_user_id` (`shop_user_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺日志表';

DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`shop_id` int(10) NOT NULL COMMENT '店铺ID',
	`shop_name` varchar(60) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `goods_id` int(10) NOT NULL COMMENT '产品ID',
  `goods_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '产品编码',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '产品名称',
  `goods_number` int(10) NOT NULL DEFAULT 0 COMMENT '库存数量',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0' COMMENT '店铺售价',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否在售 0-否 1-是',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺产品表';

DROP TABLE IF EXISTS `shop_goods_quote`;
CREATE TABLE `shop_goods_quote` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`shop_id` int(10) NOT NULL COMMENT '店铺ID',
	`shop_name` varchar(60) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `goods_id` int(10) NOT NULL COMMENT '产品ID',
  `goods_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '产品编码',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '产品名称',
  `delivery_place` varchar(50) NOT NULL DEFAULT '' COMMENT '交货地',
  `goods_number` int(10) NOT NULL DEFAULT 0 COMMENT '库存数量',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0' COMMENT '店铺售价',
  `shop_user_id` int(10) NOT NULL DEFAULT 0 COMMENT '店铺职员ID',
  `outer_user_id` varchar(10) NOT NULL DEFAULT '' COMMENT '外部职员ID',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `expiry_time` datetime NOT NULL COMMENT '截止时间',
  `outer_id` int(10) NOT NULL COMMENT '外部ID',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='店铺产品报价表';

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `shop_name` varchar(60) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `shop_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺产品ID',
  `shop_goods_quote_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺产品报价ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '平台商品ID',
  `goods_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '平台商品编码',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '产品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '产品价格',
  `goods_number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `is_checked` tinyint(1) NOT NULL DEFAULT '1' COMMENT '选中状态，0未选中，1选中',
  `is_invalid` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '购物车商品是否无效',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  KEY `shop_goods_id` (`shop_goods_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

DROP TABLE IF EXISTS `order_info`;
CREATE TABLE `order_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '订单编码',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '个人会员ID',
  `firm_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '企业会员ID',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 0-已作废 1-待企业审核 2-待商家确认',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态 0-待发货 1-已发货 2-部分发货',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态 0-待付款 1-已付款 2-部分付款',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `country` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '国家',
  `province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `district` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '县',
  `street` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '街道',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zipcode` varchar(60) NOT NULL DEFAULT '' COMMENT '邮编',
  `mobile_phone` varchar(60) NOT NULL DEFAULT '' COMMENT '联系电话',
  `postscript` varchar(255) NOT NULL DEFAULT '' COMMENT '买家留言',
  `shipping_id` text NOT NULL,
  `shipping_name` text NOT NULL,
  `shipping_code` text NOT NULL,
  `shipping_type` text NOT NULL,
  `pay_id` tinyint(3) NOT NULL DEFAULT '0',
  `pay_name` varchar(120) NOT NULL DEFAULT '',
  `how_oos` varchar(120) NOT NULL DEFAULT '',
  `how_surplus` varchar(120) NOT NULL DEFAULT '',
  `pack_name` varchar(120) NOT NULL DEFAULT '',
  `card_name` varchar(120) NOT NULL DEFAULT '',
  `card_message` varchar(255) NOT NULL DEFAULT '',
  `inv_payee` varchar(120) NOT NULL DEFAULT '',
  `inv_content` varchar(120) NOT NULL DEFAULT '',
  `goods_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `cost_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单成本',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `insure_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `pay_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `pack_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `card_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `money_paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `surplus` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `integral_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `return_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单整站退款金额',
  `from_ad` smallint(5) NOT NULL DEFAULT '0',
  `referer` varchar(255) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `shipping_time` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm_take_time` int(10) unsigned NOT NULL DEFAULT '0',
  `auto_delivery_time` int(11) unsigned NOT NULL DEFAULT '15',
  `pack_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `card_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bonus_id` int(10) unsigned NOT NULL DEFAULT '0',
  `invoice_no` varchar(255) NOT NULL DEFAULT '',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `extension_id` int(10) unsigned NOT NULL DEFAULT '0',
  `to_buyer` varchar(255) NOT NULL DEFAULT '',
  `pay_note` varchar(255) NOT NULL DEFAULT '',
  `agency_id` int(10) unsigned NOT NULL,
  `inv_type` varchar(60) NOT NULL,
  `tax` decimal(10,2) unsigned NOT NULL,
  `is_separate` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` decimal(10,2) unsigned NOT NULL,
  `discount_all` decimal(10,2) unsigned NOT NULL,
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_settlement` tinyint(1) NOT NULL DEFAULT '0',
  `sign_time` int(30) DEFAULT NULL,
  `is_single` tinyint(1) DEFAULT '0',
  `point_id` varchar(255) NOT NULL DEFAULT '',
  `shipping_dateStr` varchar(255) NOT NULL,
  `supplier_id` int(10) NOT NULL DEFAULT '0',
  `froms` char(10) NOT NULL DEFAULT 'pc',
  `coupons` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `uc_id` int(10) unsigned NOT NULL DEFAULT '0',
  `is_zc_order` int(10) DEFAULT '0',
  `zc_goods_id` int(10) NOT NULL,
  `is_frozen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `chargeoff_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `invoice_type` tinyint(1) NOT NULL DEFAULT '0',
  `vat_id` int(10) NOT NULL DEFAULT '0' COMMENT '增值税发票信息ID 关联 users_vat_invoices_info表自增ID',
  `tax_id` varchar(255) NOT NULL DEFAULT '',
  `is_update_sale` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `user_id` (`user_id`),
  KEY `order_status` (`order_status`),
  KEY `shipping_status` (`shipping_status`),
  KEY `pay_status` (`pay_status`),
  KEY `shipping_id` (`shipping_id`(333)),
  KEY `pay_id` (`pay_id`),
  KEY `extension_code` (`extension_code`,`extension_id`),
  KEY `agency_id` (`agency_id`),
  KEY `main_order_id` (`main_order_id`),
  KEY `uc_id` (`uc_id`),
  KEY `parent_id` (`parent_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `is_zc_order` (`is_zc_order`),
  KEY `zc_goods_id` (`zc_goods_id`),
  KEY `chargeoff_status` (`chargeoff_status`),
  KEY `country` (`country`),
  KEY `province` (`province`),
  KEY `city` (`city`),
  KEY `district` (`district`),
  KEY `street` (`street`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sms_supplier`;
CREATE TABLE `sms_supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `supplier_code` varchar(10) NOT NULL COMMENT '服务商编码',
  `supplier_name` varchar(50) NOT NULL COMMENT '服务商名称',
  `supplier_config` varchar(500) NOT NULL COMMENT '服务商配置',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选中状态，0未选中，1选中',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信服务商';
INSERT INTO sms_supplier(id, supplier_name,supplier_code, supplier_config,is_checked) VALUES
(1, '阿里大于', 'ALiDaYu', '{"AccessKeyID":"***","AccessKeySecret":"secret"}', 1),
(2, '点集', 'DianJi', '{"account":"sumao106","password":"123456"}', 0),
(3, '建周', 'JianZhou', '{"account":"sdk_shsumi","password":"897799"}', 0);

DROP TABLE IF EXISTS `sms_send_type`;
CREATE TABLE `sms_send_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_code` varchar(20) NOT NULL COMMENT '类型编码',
  `type_name` varchar(50) NOT NULL COMMENT '类型名称',
  `params_var` varchar(50) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送短信类型';
INSERT INTO sms_send_type(type_code, type_name, params_var) VALUES
('sms_signup', '会员注册', 'code:验证码'),
('sms_signin', '会员登录', 'code:验证码'),
('sms_find_signin', '找回密码', 'code:验证码'),
('sms_seller_signup', '商家注册', 'code:验证码;company_name:公司名称'),
('sms_seller_signin', '商家登录', 'code:验证码;company_name:公司名称');

DROP TABLE IF EXISTS `sms_temp`;
CREATE TABLE `sms_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `supplier_id` int(10) unsigned NOT NULL COMMENT '服务商ID',
  `temp_id` varchar(255) NOT NULL COMMENT '模板ID',
  `temp_content` varchar(255) NOT NULL COMMENT '模板内容',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `set_sign` varchar(20) NOT NULL COMMENT '签名',
  `type_code` varchar(20) NOT NULL COMMENT '短信类型',
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `temp_id` (`temp_id`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信模板';
INSERT INTO sms_temp(supplier_id, temp_id, temp_content, add_time, set_sign, type_code) VALUES
(2, '0', '您的验证码是：${code}，请不要把验证码泄露给其他人，如非本人操作，可不用理会',now(), '塑米城', 'sms_signup'),
(3, '0', '您的验证码是：${code}，请不要把验证码泄露给其他人，如非本人操作，可不用理会',now(), '塑米城', 'sms_signup');

DROP TABLE IF EXISTS `sms_send_log`;
CREATE TABLE `sms_send_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `template_id` int(10) NOT NULL COMMENT '模板ID',
  `phone_numbers` text NOT NULL COMMENT '短信接收号码,支持以逗号分隔的形式进行批量调用',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '短信参数',
  `sms_rs` varchar(255) NOT NULL DEFAULT '' COMMENT '短信应答',
  `sent_time` datetime COMMENT '发送时间',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送短信日志';


DROP TABLE IF EXISTS `gsxx_supplier`;
CREATE TABLE `gsxx_supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `supplier_code` varchar(10) NOT NULL COMMENT '服务商编码',
  `supplier_name` varchar(50) NOT NULL COMMENT '服务商名称',
  `supplier_config` varchar(500) NOT NULL COMMENT '服务商配置',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选中状态，0未选中，1选中',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工商信息服务商';
INSERT INTO gsxx_supplier(id, supplier_name,supplier_code, supplier_config,is_checked) VALUES
(1, '企查查', 'QiChaCha', '{"AccessID":"536ae9caf75542fbb3ca2dbc9cfa98de"}', 1);

DROP TABLE IF EXISTS `gsxx_send_log`;
CREATE TABLE `gsxx_send_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `supplier_id` int(10) NOT NULL COMMENT '服务商ID',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '查询参数',
  `supplier_rs` varchar(2000) NOT NULL DEFAULT '' COMMENT '应答返回',
  `sent_time` datetime COMMENT '发送时间',
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送企业查询日志';

CREATE TABLE `gsxx_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `KeyNo` varchar(255) DEFAULT '' COMMENT '关联主键',
  `Name` varchar(255) DEFAULT '' COMMENT '公司名称',
  `No` varchar(255) DEFAULT '' COMMENT '注册号',
  `BelongOrg` varchar(255) DEFAULT '' COMMENT '登记机关',
  `OperName` varchar(255) DEFAULT '' COMMENT '法定代表人',
  `StartDate` varchar(255) DEFAULT '' COMMENT '成立日期',
  `EndDate` varchar(255) DEFAULT '' COMMENT '注销/吊销日期',
  `Status` varchar(255) DEFAULT '' COMMENT '登记状态(存续、在业、注销、迁入、吊销、迁出、停业、清算)',
  `Province` varchar(255) DEFAULT '' COMMENT '所在省份缩写',
  `UpdatedDate` varchar(255) DEFAULT '' COMMENT '记录更新时间',
  `CreditCode` varchar(255) DEFAULT '' COMMENT '统一社会信用代码',
  `RegistCapi` varchar(255) DEFAULT '' COMMENT '注册资本',
  `EconKind` varchar(255) DEFAULT '' COMMENT '类型',
  `Address` varchar(255) DEFAULT '' COMMENT '住所',
  `Scope` varchar(2000) DEFAULT '' COMMENT '经营范围',
  `TermStart` varchar(255) DEFAULT '' COMMENT '营业期限自',
  `TeamEnd` varchar(255) DEFAULT '' COMMENT '营业期限至',
  `CheckDate` varchar(255) DEFAULT '' COMMENT '核准日期',
  `OpException` varchar(2000) DEFAULT '' COMMENT '经营异常',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工商信息企业表';
