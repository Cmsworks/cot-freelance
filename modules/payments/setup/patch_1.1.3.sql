CREATE TABLE IF NOT EXISTS `cot_payments_outs` (
  `out_id` int(10) unsigned NOT NULL auto_increment,
  `out_userid` int(11) NOT NULL,
  `out_summ` float(16,2) NOT NULL,
  `out_status` varchar(50) NOT NULL,
  `out_date` int(11) NOT NULL,
  `out_details` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`out_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;