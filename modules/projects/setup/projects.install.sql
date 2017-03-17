/**
 * Projects module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_projects` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_state` tinyint(2) DEFAULT '0',
  `item_realized` tinyint(4) DEFAULT '0',
  `item_userid` int(11) DEFAULT '0',
  `item_performer` int(11) DEFAULT '0',
  `item_date` int(11) DEFAULT '0',
  `item_update` int(11) DEFAULT '0',
  `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `item_cat` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_type` int(11) DEFAULT '0',
  `item_title` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_alias` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_desc` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_keywords` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_metatitle` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_metadesc` varchar(255) collate utf8_unicode_ci DEFAULT '',
  `item_text` MEDIUMTEXT collate utf8_unicode_ci,
  `item_cost` float(16,2) DEFAULT '0',
  `item_count` int(11) DEFAULT '0',
  `item_offerscount` int(11) DEFAULT '0',
  `item_country` varchar(3) collate utf8_unicode_ci DEFAULT '',
  `item_region` INT( 11 ) NOT NULL DEFAULT '0',
  `item_city` INT( 11 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_offers` (
  `offer_id` int(10) unsigned NOT NULL auto_increment,
  `offer_pid` int(11) DEFAULT '0',
  `offer_date` int(11) DEFAULT '0',
  `offer_userid` int(11) DEFAULT '0',
  `offer_text` MEDIUMTEXT collate utf8_unicode_ci,
  `offer_cost_min` float DEFAULT '0',
  `offer_cost_max` float DEFAULT '0',
  `offer_time_min` int(11) DEFAULT '0',
  `offer_time_max` int(11) DEFAULT '0',
  `offer_time_type` tinyint(4) DEFAULT '0',
  `offer_choise` varchar(20) collate utf8_unicode_ci DEFAULT '',
  `offer_choise_date` int(11) DEFAULT '0',
  `offer_hidden` tinyint(4) DEFAULT '0',
  PRIMARY KEY  (`offer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `post_pid` int(11) DEFAULT '0',
  `post_oid` int(11) DEFAULT '0',
  `post_userid` int(11) DEFAULT '0',
  `post_text` MEDIUMTEXT collate utf8_unicode_ci,
  `post_date` int(11) DEFAULT '0',
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_types` (
  `type_id` int(10) unsigned NOT NULL auto_increment,
  `type_title` varchar(255) collate utf8_unicode_ci DEFAULT '',
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
