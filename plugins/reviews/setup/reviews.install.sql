/**
 * Reviews plugin DB installation
 */

CREATE TABLE IF NOT EXISTS  `cot_reviews` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_userid` int(11) NOT NULL,
  `item_touserid` int(11) NOT NULL,
  `item_area` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `item_code` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `item_text` text collate utf8_unicode_ci,
  `item_score` int(11) default NULL,
  `item_date` int(11) default NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
