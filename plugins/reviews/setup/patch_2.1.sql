ALTER TABLE `cot_reviews` ADD COLUMN `item_code` varchar(255) collate utf8_unicode_ci NOT NULL default '';
ALTER TABLE `cot_reviews` ADD COLUMN  `item_area` varchar(64) collate utf8_unicode_ci NOT NULL default '';
UPDATE `cot_reviews` SET `item_area` = 'users';
