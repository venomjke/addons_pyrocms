CREATE TABLE IF NOT EXISTS `{DATABASE_NAME}` (
  `id` varchar(10) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_status` INT( 11 ) NULL,
  `nsp_customer` varchar(100) NOT NULL COMMENT 'name surname patricity customer',
  `phone_customer` varchar(30) NOT NULL,
  `email_customer` varchar(64) NOT NULL,
  `address_customer` VARCHAR( 256 ) NOT NULL,
  `note_customer` mediumtext NOT NULL,
  `investment_customer` VARCHAR( 512 ) NOT NULL,
  `nsp_shipping` varchar(100) NOT NULL,
  `phone_shipping` varchar(30) NOT NULL,
  `price_shipping` varchar(16) NOT NULL,
  `address_shipping` VARCHAR( 256 ) NOT NULL,
  `note_status` VARCHAR( 512 ) NOT NULL,
  `cost_shipping` VARCHAR( 10 ) NOT NULL DEFAULT  '0' 

  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;