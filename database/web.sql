DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`is_freeze` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0-否 1-是',
	`created_at` datetime NOT NULL COMMENT '创建时间',
	`created_by` int(10) NOT NULL DEFAULT '0' COMMENT '创建人',
	`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
	`updated_by` int(10) NOT NULL DEFAULT '0' COMMENT '更新人',
	`user_name` varchar(32) NOT NULL COMMENT '账号',
	`password` varchar(60) DEFAULT NULL COMMENT '密码',
	`real_name` varchar(32) DEFAULT NULL COMMENT '真实姓名',
	`sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0-保密 1-男 2-女',
	`mobile` varchar(16) DEFAULT NULL COMMENT '手机号',
	`email` varchar(32) DEFAULT NULL COMMENT '邮件',
	`last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
	`is_super` tinyint(1) DEFAULT '0' COMMENT '是否为超级管理员',
  `avatar` varchar(500) DEFAULT '' COMMENT '头像',
	PRIMARY KEY (`id`)
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
	`password` varchar(60) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0-保密 1-男 2-女',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ号',
  `avatar` varchar(500) NOT NULL DEFAULT '' COMMENT '用户头像',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '邀请人',
  `is_validated` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否通过审核 0-否 1-是',
  `is_freeze` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0-否 1-是',
  `real_name` varchar(60) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `id_card` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证号',
  `front_of_id_card` varchar(60) NOT NULL COMMENT '身份证正面',
  `reverse_of_id_card` varchar(60) NOT NULL COMMENT '身份证反面',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='个人会员表';

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_login_log` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`user_id` int(10) NOT NULL COMMENT '会员ID',
	`user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `log_time` datetime NOT NULL COMMENT '日志时间',
  `ip_address` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='个人会员日志表';

DROP TABLE IF EXISTS `firm`;
CREATE TABLE `firm` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_name` varchar(60) NOT NULL DEFAULT '' COMMENT '企业全称',
	`user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登录用户名(邮箱)',
	`password` varchar(60) NOT NULL DEFAULT '' COMMENT '密码',
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
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业会员表';

DROP TABLE IF EXISTS `firm_log`;
CREATE TABLE `firm_log` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`firm_id` int(10) NOT NULL COMMENT '会员ID',
	`firm_name` varchar(60) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `log_time` datetime NOT NULL COMMENT '日志时间',
  `ip_address` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `log_info` varchar(255) NOT NULL DEFAULT '' COMMENT '日志信息',
  PRIMARY KEY (`id`),
  KEY `firm_id` (`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业会员日志表';