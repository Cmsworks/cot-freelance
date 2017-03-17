/**
 * market module DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_market` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_userid` int(11) DEFAULT '0',
  `item_date` int(11) DEFAULT '0',
  `item_update` int(11) DEFAULT '0',
  `item_parser` VARCHAR(64) DEFAULT '',
  `item_cat` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_title` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_alias` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_desc` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_keywords` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_metatitle` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_metadesc` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_text` MEDIUMTEXT collate utf8_unicode_ci,
  `item_cost` float(16,2) DEFAULT '0',
  `item_count` int(11) DEFAULT '0',
  `item_sort` int(11) DEFAULT '0',
  `item_state` tinyint(4) DEFAULT '0',
  `item_country` varchar(3) collate utf8_unicode_ci DEFAULT '',
  `item_region` INT( 11 ) DEFAULT '0',
  `item_city` INT( 11 ) DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;