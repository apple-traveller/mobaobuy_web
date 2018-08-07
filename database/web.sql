

DROP TABLE IF EXISTS `sys_menu`;
CREATE TABLE `sys_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `is_active` int(1) DEFAULT '1' COMMENT '是否生效 1:生效 0:无效',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `created_by` int(10) NOT NULL DEFAULT '0' COMMENT '创建人',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `updated_by` int(10) NOT NULL DEFAULT '0' COMMENT '更新人',
  `menu_name` varchar(50) DEFAULT NULL COMMENT '名称',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `menu_icon` varchar(50) DEFAULT NULL COMMENT '菜单icon',
  `is_leaf` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否叶子结点',
  `page_id` int(10) NOT NULL DEFAULT '0' COMMENT '菜单页面ID',
  `sort_order` int(4) NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
	`id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`org_id` int(10) NOT NULL DEFAULT 0 COMMENT '组织机构ID',
	`is_active` int(1) DEFAULT '1' COMMENT '是否生效 1:生效 0:无效',
	`created_at` datetime NOT NULL COMMENT '创建时间',
	`created_by` int(10) NOT NULL DEFAULT '0' COMMENT '创建人',
	`updated_at` datetime DEFAULT NULL COMMENT '更新时间',
	`updated_by` int(10) NOT NULL DEFAULT '0' COMMENT '更新人',
	`login_name` varchar(32) NOT NULL COMMENT '账号',
	`password` varchar(60) DEFAULT NULL COMMENT '密码',
	`real_name` varchar(32) DEFAULT NULL COMMENT '真实姓名',
	`sex` char(1) DEFAULT '1' COMMENT '性别 1男　2女',
	`mobile` varchar(16) DEFAULT NULL COMMENT '手机号',
	`email` varchar(32) DEFAULT NULL COMMENT '邮件',
	`first_login_time` datetime DEFAULT NULL COMMENT '第一次登录时间',
	`last_login_time` datetime DEFAULT NULL COMMENT '最后一次登录时间',
	`is_super` tinyint(1) DEFAULT '0' COMMENT '是否为超级管理员',
	`sign` varchar(255) DEFAULT '' COMMENT '个性签名',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  `im_status` tinyint(1) DEFAULT '0' COMMENT '0 :下线  1:在线',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';
insert into cf_admin(created_at,updated_at,login_name,password,real_name,is_super)
value(now(),now(),'admin','$2y$10$3Jiq1ebcHWRzi5GjIFEgYutuQdRUZ0cUd67HhuuEkxKCgrsBAwUJm','超级管理员',1);

