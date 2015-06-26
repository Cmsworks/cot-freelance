/**
 * Projects module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_projects` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_state` tinyint(2) NOT NULL,
  `item_realized` tinyint(4) NOT NULL,
  `item_userid` int(11) NOT NULL,
  `item_performer` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_update` int(11) NOT NULL,
  `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `item_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_type` int(11) NOT NULL,
  `item_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_desc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `item_cost` float(16,2) default NULL,
  `item_count` int(11) NOT NULL,
  `item_offerscount` int(11) NOT NULL,
  `item_country` varchar(3) collate utf8_unicode_ci NOT NULL,
  `item_region` INT( 11 ) NOT NULL DEFAULT '0',
  `item_city` INT( 11 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_offers` (
  `offer_id` int(10) unsigned NOT NULL auto_increment,
  `offer_pid` int(11) NOT NULL,
  `offer_date` int(11) NOT NULL,
  `offer_userid` int(11) NOT NULL,
  `offer_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `offer_cost_min` float NOT NULL,
  `offer_cost_max` float NOT NULL,
  `offer_time_min` int(11) NOT NULL,
  `offer_time_max` int(11) NOT NULL,
  `offer_time_type` tinyint(4) NOT NULL,
  `offer_choise` varchar(20) collate utf8_unicode_ci NOT NULL,
  `offer_choise_date` int(11) NOT NULL,
  `offer_hidden` tinyint(4) NOT NULL,
  PRIMARY KEY  (`offer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `post_pid` int(11) NOT NULL,
  `post_oid` int(11) NOT NULL,
  `post_userid` int(11) NOT NULL,
  `post_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `post_date` int(11) NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_types` (
  `type_id` int(10) unsigned NOT NULL auto_increment,
  `type_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
