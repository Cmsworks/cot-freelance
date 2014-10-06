/**
 * Portfolio plugin DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_folio` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_userid` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_update` int(11) NOT NULL,
  `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `item_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_desc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `item_cost` float(16,2) NOT NULL,
  `item_count` int(11) NOT NULL,
  `item_sort` int(11) NOT NULL,
  `item_state` tinyint(4) NOT NULL,
  `item_country` varchar(3) collate utf8_unicode_ci NOT NULL,
  `item_region` INT( 11 ) NOT NULL DEFAULT '0',
  `item_city` INT( 11 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
