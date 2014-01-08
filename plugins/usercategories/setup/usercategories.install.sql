/**
 * Market module DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_usercategories` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `cat_desc` varchar(255) collate utf8_unicode_ci NOT NULL,
  `cat_path` varchar(255) collate utf8_unicode_ci NOT NULL,
  `cat_code` varchar(64) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `cot_usercategories_users` (
  `ucat_id` int(10) unsigned NOT NULL auto_increment,
  `ucat_userid` int(10) NOT NULL,
  `ucat_cat` varchar(64) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ucat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
