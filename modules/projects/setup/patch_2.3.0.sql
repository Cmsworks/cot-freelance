/* 2.3.0 separate field for last page update */
ALTER TABLE `cot_projects` ADD COLUMN `item_alias` varchar(255) collate utf8_unicode_ci NOT NULL;
ALTER TABLE `cot_projects` ADD COLUMN `item_desc` varchar(255) collate utf8_unicode_ci NOT NULL;
ALTER TABLE `cot_projects` ADD COLUMN `item_keywords` varchar(255) collate utf8_unicode_ci NOT NULL;
ALTER TABLE `cot_projects` ADD COLUMN `item_metatitle` varchar(255) collate utf8_unicode_ci NOT NULL;
ALTER TABLE `cot_projects` ADD COLUMN `item_metadesc` varchar(255) collate utf8_unicode_ci NOT NULL;
