/**
 * support plugin DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_support_tickets` (
  `ticket_id` int(10) unsigned NOT NULL auto_increment,
  `ticket_userid` int(11) NOT NULL,
  `ticket_title` varchar(255) collate utf8_unicode_ci NOT NULL, 
  `ticket_date` int(11) NOT NULL,
  `ticket_update` int(11) NOT NULL,
  `ticket_close` int(11) NOT NULL,
  `ticket_count` int(11) NOT NULL,
  `ticket_name` varchar(255) collate utf8_unicode_ci NOT NULL, 
  `ticket_email` varchar(255) collate utf8_unicode_ci NOT NULL, 
  `ticket_status` varchar(20) collate utf8_unicode_ci NOT NULL, 
  PRIMARY KEY  (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `cot_support_messages` (
  `msg_id` int(10) unsigned NOT NULL auto_increment,
  `msg_tid` int(11) NOT NULL,
  `msg_userid` int(11) NOT NULL,
  `msg_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL, 
  `msg_date` int(11) NOT NULL,
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;