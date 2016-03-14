CREATE TABLE IF NOT EXISTS `cot_payments_transfers` (
  `trn_id` int(10) unsigned NOT NULL auto_increment,
  `trn_from` int(11) NOT NULL,
  `trn_to` int(11) NOT NULL,
  `trn_summ` float(16,2) NOT NULL,
  `trn_status` varchar(50) NOT NULL,
  `trn_date` int(11) NOT NULL,
  `trn_comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`trn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;