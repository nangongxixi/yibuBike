CREATE TABLE `tb_user_captcha_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:注册;)',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `mobile` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '手机号',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '数字',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `k_created` (`deleted`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户发送验证码记录';

ALTER TABLE `tb_user`
CHANGE COLUMN `deposit_status` `deposit`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '押金' AFTER `avatar`;

ALTER TABLE tb_user_deposit RENAME tb_user_deposit_refund_log;

ALTER TABLE `tb_user_deposit_refund_log`
DROP COLUMN `apply_refund_time`,
MODIFY COLUMN `status`  tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态(1:申请中;2:已退还;)' AFTER `id_user`,
MODIFY COLUMN `price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '押金金额' AFTER `deleted`,
ADD COLUMN `refund_type`  tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '退款方式(1:微信;2:支付宝;)' AFTER `price`,
DROP INDEX `u_user`,
COMMENT='用户押金退款记录';

ALTER TABLE `tb_user`
ADD COLUMN `had_recharge_deposit`  tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否曾充值押金' AFTER `deposit`;

CREATE TABLE `tb_user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登陆ip',
  `token` char(32) NOT NULL DEFAULT '' COMMENT '登录令牌',
  `app_version` varchar(16) NOT NULL DEFAULT '' COMMENT 'APP版本',
  `device_model` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '设备(1:iphone;2:android)',
  `device_uuid` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端UUID',
  `device_version` varchar(32) NOT NULL DEFAULT '' COMMENT '客户端版本',
  `device_token` varchar(32) NOT NULL DEFAULT '' COMMENT '客户端push token',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_token` (`deleted`,`token`),
  KEY `k_user` (`deleted`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志';

ALTER TABLE `tb_bicycle_book_log`
ADD COLUMN `code`  char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '单车编号' AFTER `deleted`;

ALTER TABLE `tb_system_admin`
ADD COLUMN `auth`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '默认全部权限' AFTER `is_default`;

ALTER TABLE `tb_system_admin`
ADD COLUMN `mobile`  bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '手机号' AFTER `account`;


