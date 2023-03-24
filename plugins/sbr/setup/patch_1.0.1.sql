
CREATE TABLE IF NOT EXISTS `cot_sbr_files` (
  `file_id` int(10) unsigned NOT NULL auto_increment,
  `file_sid` int(11) NOT NULL,
  `file_area` varchar(50) collate utf8_unicode_ci default NULL,
  `file_code` varchar(50) collate utf8_unicode_ci default NULL,
  `file_url` varchar(255) collate utf8_unicode_ci default NULL,
  `file_title` varchar(255) collate utf8_unicode_ci default NULL,
  `file_ext` varchar(4) collate utf8_unicode_ci default NULL,
  `file_size` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;