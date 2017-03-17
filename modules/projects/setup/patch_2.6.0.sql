ALTER TABLE `cot_projects`
CHANGE `item_id` `item_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `item_state` `item_state` tinyint(2) DEFAULT '0',
CHANGE `item_realized` `item_realized` tinyint(4) DEFAULT '0',
CHANGE `item_userid` `item_userid` int(11) DEFAULT '0',
CHANGE `item_performer` `item_performer` int(11) DEFAULT '0',
CHANGE `item_date` `item_date` int(11) DEFAULT '0',
CHANGE `item_update` `item_update` int(11) DEFAULT '0',
CHANGE `item_parser` `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
CHANGE `item_cat` `item_cat` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_type` `item_type` int(11) DEFAULT '0',
CHANGE `item_title` `item_title` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_alias` `item_alias` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_desc` `item_desc` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_keywords` `item_keywords` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_metatitle` `item_metatitle` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_metadesc` `item_metadesc` varchar(255) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_text` `item_text` MEDIUMTEXT collate utf8_unicode_ci,
CHANGE `item_cost` `item_cost` float(16,2) DEFAULT '0',
CHANGE `item_count` `item_count` int(11) DEFAULT '0',
CHANGE `item_offerscount` `item_offerscount` int(11) DEFAULT '0',
CHANGE `item_country` `item_country` varchar(3) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_region` `item_region` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `item_city` `item_city` INT( 11 ) NOT NULL DEFAULT '0';

ALTER TABLE `cot_projects_offers`
CHANGE `offer_id` `offer_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `offer_pid` `offer_pid` int(11) DEFAULT '0',
CHANGE `offer_date` `offer_date` int(11) DEFAULT '0',
CHANGE `offer_userid` `offer_userid` int(11) DEFAULT '0',
CHANGE `offer_text` `offer_text` MEDIUMTEXT collate utf8_unicode_ci,
CHANGE `offer_cost_min` `offer_cost_min` float DEFAULT '0',
CHANGE `offer_cost_max` `offer_cost_max` float DEFAULT '0',
CHANGE `offer_time_min` `offer_time_min` int(11) DEFAULT '0',
CHANGE `offer_time_max` `offer_time_max` int(11) DEFAULT '0',
CHANGE `offer_time_type` `offer_time_type` tinyint(4) DEFAULT '0',
CHANGE `offer_choise` `offer_choise` varchar(20) collate utf8_unicode_ci DEFAULT '',
CHANGE `offer_choise_date` `offer_choise_date` int(11) DEFAULT '0',
CHANGE `offer_hidden` `offer_hidden` tinyint(4) DEFAULT '0';

ALTER TABLE `cot_projects_posts`
CHANGE `post_id` `post_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `post_pid` `post_pid` int(11) DEFAULT '0',
CHANGE `post_oid` `post_oid` int(11) DEFAULT '0',
CHANGE `post_userid` `post_userid` int(11) DEFAULT '0',
CHANGE `post_text` `post_text` MEDIUMTEXT collate utf8_unicode_ci,
CHANGE `post_date` `post_date` int(11) DEFAULT '0';

ALTER TABLE `cot_projects_types`
CHANGE `type_id` `type_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `type_title` `type_title` varchar(255) collate utf8_unicode_ci DEFAULT '';
