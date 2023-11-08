/**
 * market orders DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_market_orders` (
  `order_id` int(10) unsigned NOT NULL auto_increment,
  `order_pid` int(11) NOT NULL,
  `order_userid` int(11) NOT NULL,
  `order_seller` int(11) NOT NULL,
  `order_date` int UNSIGNED NOT NULL DEFAULT '0',
  `order_paid` int UNSIGNED NOT NULL DEFAULT '0',
  `order_claim` int UNSIGNED NOT NULL DEFAULT '0',
  `order_cancel` int UNSIGNED NOT NULL DEFAULT '0',
  `order_done` int UNSIGNED NOT NULL DEFAULT '0',
  `order_count` int(11) NOT NULL,
  `order_cost` float(16,2) NOT NULL,
  `order_title` varchar(255) collate utf8_unicode_ci default NULL,
  `order_text` varchar(255) collate utf8_unicode_ci default NULL,
  `order_claimtext` TEXT  DEFAULT '',
  `order_email` varchar(255) DEFAULT '',
  `order_status` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;