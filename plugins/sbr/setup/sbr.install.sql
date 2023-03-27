/**
 * sbr plugin DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_sbr` (
  `sbr_id` int(10) unsigned NOT NULL auto_increment,
  `sbr_pid` int(11) NOT NULL,
  `sbr_performer` int(11) NOT NULL,
  `sbr_employer` int(11) NOT NULL,
  `sbr_title` varchar(255) collate utf8_unicode_ci NOT NULL, 
  `sbr_cost` float(16,2) NOT NULL,
  `sbr_tax` float(16,2) NOT NULL,
  `sbr_create` int(11) NOT NULL,
  `sbr_update` int(11) NOT NULL,
  `sbr_begin` int(11) NOT NULL,
  `sbr_claim` int(11) NOT NULL,
  `sbr_done` int(11) NOT NULL,
  `sbr_status` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`sbr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `cot_sbr_stages` (
  `stage_id` int(10) unsigned NOT NULL auto_increment,
  `stage_sid` int(11) NOT NULL,
  `stage_num` int(11) NOT NULL,
  `stage_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `stage_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `stage_days` int(11) NOT NULL,
  `stage_begin` int(11) NOT NULL,
  `stage_expire` int(11) NOT NULL,
  `stage_claim` int(11) NOT NULL,
  `stage_done` int(11) NOT NULL,
  `stage_cost` float(16,2) NOT NULL,
  `stage_status` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`stage_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `cot_sbr_posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `post_sid` int(11) NOT NULL,
  `post_from` int(11) NOT NULL,
  `post_to` int(11) NOT NULL,
  `post_text` text collate utf8_unicode_ci NOT NULL,
  `post_type` varchar(50)  collate utf8_unicode_ci NOT NULL,
  `post_date` int(11) NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `cot_sbr_claims` (
  `claim_id` int(10) unsigned NOT NULL auto_increment,
  `claim_sid` int(11) NOT NULL,
  `claim_stage` int(11) NOT NULL,
  `claim_from` int(11) NOT NULL,
  `claim_text` text collate utf8_unicode_ci NOT NULL,
  `claim_date` int(11) NOT NULL,
  `claim_done` int(11) NOT NULL,
  `claim_decision` text collate utf8_unicode_ci NOT NULL,
  `claim_payemployer` float(16,2) NOT NULL,
  `claim_payperformer` float(16,2) NOT NULL,
  `claim_status` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`claim_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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