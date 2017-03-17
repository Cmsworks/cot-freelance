ALTER TABLE `cot_payments`
CHANGE `pay_id` `pay_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `pay_userid` `pay_userid` int(11) DEFAULT '0',
CHANGE `pay_status` `pay_status` varchar(50) DEFAULT '',
CHANGE `pay_cdate` `pay_cdate` int(11) DEFAULT '0',
CHANGE `pay_pdate` `pay_pdate` int(11) DEFAULT '0',
CHANGE `pay_adate` `pay_adate` int(11) DEFAULT '0',
CHANGE `pay_summ` `pay_summ` float(16,2) DEFAULT '0',
CHANGE `pay_desc` `pay_desc` varchar(255) DEFAULT '',
CHANGE `pay_area` `pay_area` varchar(20) DEFAULT '',
CHANGE `pay_code` `pay_code` varchar(255) DEFAULT '',
CHANGE `pay_time` `pay_time` int(11) DEFAULT '0',
CHANGE `pay_redirect` `pay_redirect` varchar(255) DEFAULT '';