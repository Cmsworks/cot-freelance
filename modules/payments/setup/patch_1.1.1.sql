CREATE TABLE IF NOT EXISTS `cot_payments_services` (
  `service_id` int(10) unsigned NOT NULL auto_increment,
  `service_area` varchar(20) NOT NULL,
  `service_userid` int(11) NOT NULL,
  `service_expire` int(11) NOT NULL,
  PRIMARY KEY  (`service_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1