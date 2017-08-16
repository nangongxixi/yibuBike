CREATE TABLE `tb_user_captcha_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '����(1:ע��;)',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `mobile` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '�ֻ���',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `k_created` (`deleted`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�û�������֤���¼';

ALTER TABLE `tb_user`
CHANGE COLUMN `deposit_status` `deposit`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT 'Ѻ��' AFTER `avatar`;

ALTER TABLE tb_user_deposit RENAME tb_user_deposit_refund_log;

ALTER TABLE `tb_user_deposit_refund_log`
DROP COLUMN `apply_refund_time`,
MODIFY COLUMN `status`  tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '״̬(1:������;2:���˻�;)' AFTER `id_user`,
MODIFY COLUMN `price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT 'Ѻ����' AFTER `deleted`,
ADD COLUMN `refund_type`  tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '�˿ʽ(1:΢��;2:֧����;)' AFTER `price`,
DROP INDEX `u_user`,
COMMENT='�û�Ѻ���˿��¼';

ALTER TABLE `tb_user`
ADD COLUMN `had_recharge_deposit`  tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '�Ƿ�����ֵѺ��' AFTER `deposit`;

CREATE TABLE `tb_user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '�����û�id',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '��½ip',
  `token` char(32) NOT NULL DEFAULT '' COMMENT '��¼����',
  `app_version` varchar(16) NOT NULL DEFAULT '' COMMENT 'APP�汾',
  `device_model` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '�豸(1:iphone;2:android)',
  `device_uuid` varchar(64) NOT NULL DEFAULT '' COMMENT '�ͻ���UUID',
  `device_version` varchar(32) NOT NULL DEFAULT '' COMMENT '�ͻ��˰汾',
  `device_token` varchar(32) NOT NULL DEFAULT '' COMMENT '�ͻ���push token',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_token` (`deleted`,`token`),
  KEY `k_user` (`deleted`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='�û���¼��־';

ALTER TABLE `tb_bicycle_book_log`
ADD COLUMN `code`  char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '�������' AFTER `deleted`;

ALTER TABLE `tb_system_admin`
ADD COLUMN `auth`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Ĭ��ȫ��Ȩ��' AFTER `is_default`;

ALTER TABLE `tb_system_admin`
ADD COLUMN `mobile`  bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '�ֻ���' AFTER `account`;


