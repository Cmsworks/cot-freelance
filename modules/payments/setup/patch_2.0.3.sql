ALTER TABLE `cot_payments_outs`
CHANGE `out_id` `out_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `out_userid` `out_userid` int(11) NOT NULL,
CHANGE `out_summ` `out_summ` float(16,2) NOT NULL,
CHANGE `out_status` `out_status` varchar(50)  DEFAULT '',
CHANGE `out_date` `out_date` int(11) DEFAULT '0',
CHANGE `out_details` `out_details` text collate utf8_unicode_ci NOT NULL;

ALTER TABLE `cot_payments_transfers`
CHANGE `trn_id` `trn_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `trn_from` `trn_from` int(11) NOT NULL,
CHANGE `trn_to` `trn_to` int(11) NOT NULL,
CHANGE `trn_summ` `trn_summ` float(16,2) NOT NULL,
CHANGE `trn_status` `trn_status` varchar(50) DEFAULT '',
CHANGE `trn_date` `trn_date` int(11) DEFAULT '0',
CHANGE `trn_done` `trn_done` int(11) DEFAULT '0',
CHANGE `trn_comment` `trn_comment` text collate utf8_unicode_ci NOT NULL;