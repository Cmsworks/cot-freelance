<?php
/**
 * projects module
 *
 * @package projects
 * @version 2.5.5
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');
require_once cot_incfile('structure');

cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'programming', 'structure_title' => 'Программирование', 'structure_path' => '001'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'management', 'structure_title' => 'Менеджмент', 'structure_path' => '002'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'marketing', 'structure_title' => 'Маркетинг и реклама', 'structure_path' => '003'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'design', 'structure_title' => 'Дизайн', 'structure_path' => '004'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'seo', 'structure_title' => 'Оптимизация (SEO)', 'structure_path' => '005'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'texts', 'structure_title' => 'Тексты', 'structure_path' => '006'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'photo', 'structure_title' => 'Фотография', 'structure_path' => '007'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'gamedev', 'structure_title' => 'Разработка игр', 'structure_path' => '008'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'consulting', 'structure_title' => 'Консалтинг', 'structure_path' => '009'));
cot_structure_add('projects', array('structure_area' => 'projects', 'structure_code' => 'construction', 'structure_title' => 'Строительство', 'structure_path' => '010'));

$db->update($db_auth, array('auth_rights' => 5), "auth_code='projects' AND auth_groupid=4");