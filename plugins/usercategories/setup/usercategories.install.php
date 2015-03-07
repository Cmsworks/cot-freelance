<?php
/**
 * Installation handler
 *
 * @package usercategories
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

require_once cot_incfile('usercategories', 'plug');
require_once cot_incfile('extrafields');
require_once cot_incfile('structure');

// Add field if missing
if (!$db->fieldExists($db_users, "user_cats"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_cats` TEXT collate utf8_unicode_ci NOT NULL");
}

cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'programming', 'structure_title' => 'Программирование', 'structure_path' => '001'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'management', 'structure_title' => 'Менеджмент', 'structure_path' => '002'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'marketing', 'structure_title' => 'Маркетинг и реклама', 'structure_path' => '003'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'design', 'structure_title' => 'Дизайн', 'structure_path' => '004'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'seo', 'structure_title' => 'Оптимизация (SEO)', 'structure_path' => '005'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'texts', 'structure_title' => 'Тексты', 'structure_path' => '006'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'photo', 'structure_title' => 'Фотография', 'structure_path' => '007'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'gamedev', 'structure_title' => 'Разработка игр', 'structure_path' => '008'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'consulting', 'structure_title' => 'Консалтинг', 'structure_path' => '009'));
cot_structure_add('usercategories', array('structure_area' => 'usercategories', 'structure_code' => 'construction', 'structure_title' => 'Строительство', 'structure_path' => '010'));