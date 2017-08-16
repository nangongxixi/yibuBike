CREATE TABLE `tb_system_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `account` varchar(18) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `is_default` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '默认账号',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_account` (`deleted`,`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统管理员';

INSERT INTO `tb_system_admin` (`name`, `account`, `password`, `is_default`, `created`)
VALUES ('admin', 'bicycle', 'e10adc3949ba59abbe56e057f20f883e', '1', NOW());

CREATE TABLE `tb_system_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(60) NOT NULL DEFAULT '' COMMENT '键',
  `val` varchar(120) NOT NULL DEFAULT '' COMMENT '值',
  `summary` varchar(120) NOT NULL DEFAULT '' COMMENT '描述',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_key` (`deleted`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';

INSERT INTO `tb_system_config` (`key`, `val`, `summary`, `created`)
VALUES ('price', '5.00', '骑行单价', NOW());

CREATE TABLE `tb_system_config_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_system_config` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联系统配置id',
  `id_admin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联管理员id',
  `val` varchar(120) NOT NULL DEFAULT '' COMMENT '值',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置日志';

CREATE TABLE `tb_system_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `all_user_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当前用户量',
  `day_user_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当日用户量',
  `liveness` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活跃度',
  `total_consume` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计消费',
  `day_consume` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '当日消费',
  `not_refund_deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '未退还押金',
  `refund_deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已退还押金',
  `day_deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '当日缴纳押金',
  `date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日期',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `k_date` (`deleted`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统统计';

CREATE TABLE `tb_system_admin_oplog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_admin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联管理员id',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联资源id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '3' COMMENT '操作类型(1:冻结用户;2:取消冻结用户;3:退还押金;4:实名认证;5:故障标记;6:系统参数修改;)',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统管理员操作日志';

CREATE TABLE `tb_user_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:已缴纳;2:申请退还;3:已退还;)',
  `apply_refund_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '申请退还时间',
  `id_user_recharge_log` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联充值记录id',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_user` (`deleted`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户押金信息';

CREATE TABLE `tb_user_recharge_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:余额;2:押金;)',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联资源id',
  `recharge_no` char(32) NOT NULL DEFAULT '' COMMENT '平台单号',
  `trade_no` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方单号',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:未支付;2:已支付;9:异常;)',
  `total_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总额',
  `total_tax` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '税',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '支付方式(1:微信;2:支付宝;)',
  `pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_recharge_no` (`recharge_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户充值记录';

CREATE TABLE `tb_user_bicycle_fdbk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `id_bicycle` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联单车id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:开不了锁;2:关不了锁;3:举报违停;4:车辆故障;5:违停申诉;6:其他;)',
  `summary` varchar(150) NOT NULL DEFAULT '' COMMENT '描述',
  `picture` varchar(220) NOT NULL DEFAULT '' COMMENT '照片',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:申请中;2:已忽略;3:已确定;)',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户单车故障反馈信息';

CREATE TABLE `tb_bicycle_trouble_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bicycle` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联单车id',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联资源id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:用户反馈;2:管理员标记;)',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单车故障记录';

CREATE TABLE `tb_user_credit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:注册;2:;3:;4:;5:;6:;)',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联资源id',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '得分',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信用记录';

CREATE TABLE `tb_bicycle_book_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bicycle` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联单车id',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `start_lon` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '开始单车经度',
  `start_lat` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '开始单车纬度',
  `unit_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单价-分钟',
  `unit_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价-费用',
  `end_lon` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结束单车经度',
  `end_lat` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结束单车纬度',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:预约中;2:已取消;3:已结束;4:已完成;)',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单车预约记录';

CREATE TABLE `tb_bicycle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(16) NOT NULL DEFAULT '' COMMENT '编号',
  `lon` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '经度',
  `lat` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '纬度',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1;正常;2:已预约;3:已故障;4:已报废;)',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_code` (`deleted`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单车信息';

CREATE TABLE `tb_user_trip_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_bicycle` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联单车id',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `start_lon` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '开始经度',
  `start_lat` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '开始纬度',
  `end_lon` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结束经度',
  `end_lat` decimal(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结束纬度',
  `unit_min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单价-分钟',
  `unit_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价-费用',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:行程开始;2:行程中;3:行程结束;4:已支付;)',
  `trip_dist` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '骑行距离(公里)',
  `carbon_emission` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '碳排量(千克)',
  `athletic_achievement` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运动成就(大卡)',
  `chargeable_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '扣款时间',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  `min` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑行时间',
  `code` char(255) NOT NULL DEFAULT '' COMMENT '单车编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户行程记录';

CREATE TABLE `tb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '手机号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `avatar` varchar(220) NOT NULL DEFAULT '' COMMENT '头像',
  `deposit_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '押金状态(0:未缴纳;1:已缴纳;2:申请退还;3:已退还;)',
  `realname_auth_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '实名认证状态(0:未认证;1:申请中;2:认证失败;3:已认证;)',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `trip_dist` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计骑行距离(公里)',
  `carbon_emission` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计碳排量(千克)',
  `athletic_achievement` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计运动成就(大卡)',
  `credit_score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '信用值',
  `platform_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '单车使用状态(1:未使用;2:预约中;3:行程中;4:未支付;)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:正常;2:已冻结;)',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_mobile` (`deleted`,`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息';

CREATE TABLE `tb_user_realname_auth_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `number` char(18) NOT NULL DEFAULT '' COMMENT '证件号',
  `picture` varchar(220) NOT NULL DEFAULT '' COMMENT '证件照',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:申请中;2:认证失败;3:已认证;)',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户实名认证记录';
