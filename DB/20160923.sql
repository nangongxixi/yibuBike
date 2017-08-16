CREATE TABLE `tb_user_wallet_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '����(1:��ֵ;2:�˿�;)',
  `id_resource` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '������Դid',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '���',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '֧����ʽ(1:΢��;2:֧����;)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�û�Ǯ����ϸ';