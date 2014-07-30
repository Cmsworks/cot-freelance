/**
 * Projects module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_projects` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_state` tinyint(2) NOT NULL,
  `item_realized` tinyint(4) NOT NULL,
  `item_userid` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_update` int(11) NOT NULL,
  `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `item_cat` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_type` int(11) NOT NULL,
  `item_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `item_desc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metatitle` varchar(255) collate utf8_unicode_ci default NULL,
  `item_metadesc` varchar(255) collate utf8_unicode_ci default NULL,
  `item_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `item_cost` float(16,2) default NULL,
  `item_count` int(11) NOT NULL,
  `item_offerscount` int(11) NOT NULL,
  `item_country` varchar(3) collate utf8_unicode_ci NOT NULL,
  `item_region` INT( 11 ) NOT NULL DEFAULT '0',
  `item_city` INT( 11 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_offers` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_pid` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_userid` int(11) NOT NULL,
  `item_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `item_cost_min` float NOT NULL,
  `item_cost_max` float NOT NULL,
  `item_time_min` int(11) NOT NULL,
  `item_time_max` int(11) NOT NULL,
  `item_time_type` tinyint(4) NOT NULL,
  `item_choise` varchar(20) collate utf8_unicode_ci NOT NULL,
  `item_choise_date` int(11) NOT NULL,
  `item_hidden` tinyint(4) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `post_pid` int(11) NOT NULL,
  `post_oid` int(11) NOT NULL,
  `post_userid` int(11) NOT NULL,
  `post_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,
  `post_date` int(11) NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cot_projects_types` (
  `type_id` int(10) unsigned NOT NULL auto_increment,
  `type_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cot_auth` (`auth_groupid`, `auth_code`, `auth_option`,
  `auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
(1, 'projects', 'programming',	1,		0,	1),
(2, 'projects', 'programming',	1,		254,	1),
(3, 'projects', 'programming',	0,		255,	1),
(4, 'projects', 'programming',	7,		0,		1),
(5, 'projects', 'programming',	255,	255,	1),
(6, 'projects', 'programming',	135,	0,		1),
(1, 'projects', 'management',	1,		0,	1),
(2, 'projects', 'management',	1,		254,	1),
(3, 'projects', 'management',	0,		255,	1),
(4, 'projects', 'management',	7,		0,		1),
(5, 'projects', 'management',	255,	255,	1),
(6, 'projects', 'management',	135,	0,		1),
(1, 'projects', 'marketing',	1,		0,	1),
(2, 'projects', 'marketing',	1,		254,	1),
(3, 'projects', 'marketing',	0,		255,	1),
(4, 'projects', 'marketing',	7,		0,		1),
(5, 'projects', 'marketing',	255,	255,	1),
(6, 'projects', 'marketing',	135,	0,		1),
(1, 'projects', 'design',		1,		0,	1),
(2, 'projects', 'design',		1,		254,	1),
(3, 'projects', 'design',		0,		255,	1),
(4, 'projects', 'design',		7,		0,		1),
(5, 'projects', 'design',		255,	255,	1),
(6, 'projects', 'design',		135,	0,		1),
(1, 'projects', 'seo',		1,		0,	1),
(2, 'projects', 'seo',		1,		254,	1),
(3, 'projects', 'seo',		0,		255,	1),
(4, 'projects', 'seo',		7,		0,		1),
(5, 'projects', 'seo',		255,	255,	1),
(6, 'projects', 'seo',		135,	0,		1),
(1, 'projects', 'texts',		1,		0,	1),
(2, 'projects', 'texts',		1,		254,	1),
(3, 'projects', 'texts',		0,		255,	1),
(4, 'projects', 'texts',		7,		0,		1),
(5, 'projects', 'texts',		255,	255,	1),
(6, 'projects', 'texts',		135,	0,		1),
(1, 'projects', 'photo',		1,		0,	1),
(2, 'projects', 'photo',		1,		254,	1),
(3, 'projects', 'photo',		0,		255,	1),
(4, 'projects', 'photo',		7,		0,		1),
(5, 'projects', 'photo',		255,	255,	1),
(6, 'projects', 'photo',		135,	0,		1),
(1, 'projects', 'gamedev',		1,		0,	1),
(2, 'projects', 'gamedev',		1,		254,	1),
(3, 'projects', 'gamedev',		0,		255,	1),
(4, 'projects', 'gamedev',		7,		0,		1),
(5, 'projects', 'gamedev',		255,	255,	1),
(6, 'projects', 'gamedev',		135,	0,		1),
(1, 'projects', 'consulting',		1,		0,	1),
(2, 'projects', 'consulting',		1,		254,	1),
(3, 'projects', 'consulting',		0,		255,	1),
(4, 'projects', 'consulting',		7,		0,		1),
(5, 'projects', 'consulting',		255,	255,	1),
(6, 'projects', 'consulting',		135,	0,		1),
(1, 'projects', 'construction',		1,		0,	1),
(2, 'projects', 'construction',		1,		254,	1),
(3, 'projects', 'construction',		0,		255,	1),
(4, 'projects', 'construction',		7,		0,		1),
(5, 'projects', 'construction',		255,	255,	1),
(6, 'projects', 'construction',		135,	0,		1);


INSERT INTO `cot_structure` 
(`structure_area`, `structure_code`, `structure_path`, `structure_tpl`, `structure_title`, `structure_desc`, `structure_icon`, `structure_locked`, `structure_count`) 
VALUES
('projects', 'programming', '001', '', 'Программирование', '', '', 0, 0),
('projects', 'management', '002', '', 'Менеджмент', '', '', 0, 0),
('projects', 'marketing', '003', '', 'Маркетинг и реклама', '', '', 0, 0),
('projects', 'design', '004', '', 'Дизайн', '', '', 0, 0),
('projects', 'seo', '005', '', 'Оптимизация (SEO)', '', '', 0, 0),
('projects', 'texts', '006', '', 'Тексты', '', '', 0, 0),
('projects', 'photo', '007', '', 'Фотография', '', '', 0, 0),
('projects', 'gamedev', '008', '', 'Разработка игр', '', '', 0, 0),
('projects', 'consulting', '009', '', 'Консалтинг', '', '', 0, 0),
('projects', 'construction', '010', '', 'Строительство', '', '', 0, 0);