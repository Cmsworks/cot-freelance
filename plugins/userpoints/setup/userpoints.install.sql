/**
 * Userpoints module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_userpoints` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_userid` int(11) DEFAULT '0',
  `item_date` int(11) DEFAULT '0',
  `item_type` varchar(20) collate utf8_unicode_ci DEFAULT '',
  `item_point` float DEFAULT '0',
  `item_itemid` int(11) DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;