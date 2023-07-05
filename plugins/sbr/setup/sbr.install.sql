/**
 * sbr plugin DB installation
 */

CREATE TABLE IF NOT EXISTS `cot_sbr` (
  `sbr_id` int unsigned NOT NULL auto_increment,
  `sbr_pid` int unsigned NOT NULL default 0,
  `sbr_performer` int unsigned NOT NULL,
  `sbr_employer` int unsigned NOT NULL,
  `sbr_title` varchar(255) NOT NULL,
  `sbr_cost` decimal(16,2) NOT NULL,
  `sbr_tax` decimal(16,2) NOT NULL,
  `sbr_create` int unsigned NOT NULL,
  `sbr_update` int unsigned NOT NULL default 0,
  `sbr_begin` int unsigned NOT NULL default 0,
  `sbr_claim` int NOT NULL default 0,
  `sbr_done` int unsigned NOT NULL default 0,
  `sbr_status` varchar(50) default NULL,
  PRIMARY KEY  (`sbr_id`)
);


CREATE TABLE IF NOT EXISTS `cot_sbr_stages` (
  `stage_id` int unsigned NOT NULL auto_increment,
  `stage_sid` int unsigned NOT NULL,
  `stage_num` SMALLINT unsigned NOT NULL,
  `stage_title` varchar(255) NOT NULL default '',
  `stage_text` MEDIUMTEXT NOT NULL,
  `stage_days` SMALLINT NOT NULL,
  `stage_begin` int unsigned NOT NULL default 0,
  `stage_expire` int unsigned NOT NULL default 0,
  `stage_claim` int NOT NULL default 0,
  `stage_done` int unsigned NOT NULL default 0,
  `stage_cost` decimal(16,2) NOT NULL,
  `stage_status` varchar(50) default NULL,
  PRIMARY KEY  (`stage_id`)
);


CREATE TABLE IF NOT EXISTS `cot_sbr_posts` (
  `post_id` int unsigned NOT NULL auto_increment,
  `post_sid` int unsigned NOT NULL,
  `post_from` int unsigned NOT NULL,
  `post_to` int unsigned NOT NULL,
  `post_text` text NOT NULL,
  `post_type` varchar(50) NOT NULL default '',
  `post_date` int NOT NULL,
  PRIMARY KEY  (`post_id`)
);


CREATE TABLE IF NOT EXISTS `cot_sbr_claims` (
  `claim_id` int unsigned NOT NULL auto_increment,
  `claim_sid` int unsigned NOT NULL,
  `claim_stage` int unsigned NOT NULL,
  `claim_from` int unsigned NOT NULL,
  `claim_text` text NOT NULL,
  `claim_date` int unsigned NOT NULL,
  `claim_done` int unsigned NOT NULL,
  `claim_decision` text NOT NULL,
  `claim_payemployer` decimal(16,2) NOT NULL,
  `claim_payperformer` decimal(16,2) NOT NULL,
  `claim_status` varchar(50) default NULL,
  PRIMARY KEY  (`claim_id`)
);

CREATE TABLE IF NOT EXISTS `cot_sbr_files` (
  `file_id` int unsigned NOT NULL auto_increment,
  `file_sid` int unsigned NOT NULL,
  `file_area` varchar(50) default NULL,
  `file_code` varchar(50) default NULL,
  `file_url` varchar(255) default NULL,
  `file_title` varchar(255) default NULL,
  `file_ext` varchar(4) default NULL,
  `file_size` int unsigned NOT NULL default 0,
  PRIMARY KEY  (`file_id`)
);