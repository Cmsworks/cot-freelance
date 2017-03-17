ALTER TABLE `cot_userpoints` 
CHANGE `item_id` `item_id` int(10) unsigned NOT NULL auto_increment,
CHANGE `item_userid` `item_userid` int(11) DEFAULT '0',
CHANGE `item_date` `item_date` int(11) DEFAULT '0',
CHANGE `item_type` `item_type` varchar(20) collate utf8_unicode_ci DEFAULT '',
CHANGE `item_point` `item_point` float DEFAULT '0',
CHANGE `item_itemid` `item_itemid` int(11) DEFAULT '0';