CREATE TABLE `tb_user_wallet_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型(1:充值;2:退款;)',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联资源id',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '支付方式(1:微信;2:支付宝;)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户钱包明细';