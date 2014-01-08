<?php
/**
 * Installation handler
 *
 * @package usercategories
 * @version 2.1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');

global $db_freelancers_cat, $db_freelancers_users;

if(cot_plugin_active('freelancers'))
{
	require_once cot_incfile('freelancers', 'plug');
	
	$sql = $db->query("SELECT * FROM $db_freelancers_cat WHERE 1");
	while($row = $sql->fetch())
	{
		unset($row['cat_id']);
		$db->insert($db_usercategories, $row);
	}
	
	$sql = $db->query("SELECT * FROM $db_freelancers_users WHERE 1");
	while($row = $sql->fetch())
	{
		$row['ucat_userid'] = $row['item_userid'];
		$row['ucat_cat'] = $row['item_cat'];
		unset($row['item_userid']);
		unset($row['item_cat']);
		$db->insert($db_usercategories_users, $row);
	}
}
else
{
	$db->query("INSERT INTO $db_usercategories 
		(`cat_code`, `cat_path`, `cat_title`, `cat_desc`) 
		VALUES
		('programming', '001', 'Программирование', ''),
		('management', '002', 'Менеджмент', ''),
		('marketing', '003', 'Маркетинг и реклама', ''),
		('design', '004', 'Дизайн', ''),
		('seo', '005', 'Оптимизация (SEO)', ''),
		('texts', '006', 'Тексты', ''),
		('photo', '007', 'Фотография', ''),
		('gamedev', '008', 'Разработка игр', ''),
		('consulting', '009', 'Консалтинг', ''),
		('construction', '010', 'Строительство', '');
	");
}