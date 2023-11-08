/* filterforuser schema */

CREATE TABLE IF NOT EXISTS `cot_filterforuser` (
  /*`fu_id` int(11) unsigned NOT NULL auto_increment,*/
  `fu_fieldname` varchar(255) collate utf8_unicode_ci NOT NULL,
  `fu_fieldstatus` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`fu_fieldname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;