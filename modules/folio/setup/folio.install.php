<?php 

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');


require_once cot_incfile('folio', 'module');

global $db_structure, $db_foliostore, $db_folio, $db_auth, $db_mavatars;

if(cot_module_active('foliostore'))
{
	require_once cot_incfile('foliostore', 'module');
	// Копируем структуру модуля Foliostore в Folio
	$sql = $db->query("SELECT * FROM $db_structure WHERE structure_area='foliostore'");
	while($row = $sql->fetch())
	{
		unset($row['structure_id']);
		$row['structure_area'] = 'folio';

		$db->insert($db_structure, $row);
	}

	// Копируем права структуры Foliostore
	$sql = $db->query("SELECT * FROM $db_auth WHERE auth_code='foliostore'");
	while($row = $sql->fetch())
	{
		unset($row['auth_id']);
		$row['auth_code'] = 'folio';

		$db->insert($db_auth, $row);
	}

	// Копируем записи из таблицы Foliostore в Folio
	// При этом также переименовываем загруженные изображения в плагине Mavatars
	$sql = $db->query("SELECT * FROM $db_foliostore WHERE item_store<>1");
	while($row = $sql->fetch())
	{
		$folioid = $row['item_id'];

		unset($row['item_id']);
		unset($row['item_store']);
		unset($row['item_index']);

		$db->insert($db_folio, $row);
		$id = $db->lastInsertId();

		if(cot_plugin_active('mavatars'))
		{
			if($mav = $db->query("SELECT * FROM $db_mavatars WHERE mav_code=" . $folioid . " AND mav_extension='foliostore'")->fetch())
			{
				unset($mav['mav_id']);
				$mav['mav_extension'] = 'folio';
				$mav['mav_code'] = $id;

				$db->insert($db_mavatars, $mav);
			}	
		}
	}
}
else
{
	$db->query("INSERT INTO $db_structure 
		(`structure_area`, `structure_code`, `structure_path`, `structure_tpl`, `structure_title`, `structure_desc`, `structure_icon`, `structure_locked`, `structure_count`) 
		VALUES
		('folio', 'soft', '001', '', 'Программы', '', '', 0, 0),
		('folio', 'sites', '002', '', 'Сайты', '', '', 0, 0),
		('folio', 'design', '003', '', 'Дизайн', '', '', 0, 0),
		('folio', 'logos', '004', '', 'Логотипы', '', '', 0, 0),
		('folio', 'photos', '005', '', 'Фотографии', '', '', 0, 0),
		('folio', 'hm', '006', '', 'Hand-made', '', '', 0, 0);
	");
	
	$db->query("INSERT INTO $db_auth (`auth_groupid`, `auth_code`, `auth_option`,
		`auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
		(1, 'folio', 'soft',	1,		0,	1),
		(2, 'folio', 'soft',	1,		254,	1),
		(3, 'folio', 'soft',	0,		255,	1),
		(4, 'folio', 'soft',	7,		0,		1),
		(5, 'folio', 'soft',	255,	255,	1),
		(6, 'folio', 'soft',	135,	0,		1),
		(1, 'folio', 'sites',	1,		0,	1),
		(2, 'folio', 'sites',	1,		254,	1),
		(3, 'folio', 'sites',	0,		255,	1),
		(4, 'folio', 'sites',	7,		0,		1),
		(5, 'folio', 'sites',	255,	255,	1),
		(6, 'folio', 'sites',	135,	0,		1),
		(1, 'folio', 'design',		1,		0,	1),
		(2, 'folio', 'design',		1,		254,	1),
		(3, 'folio', 'design',		0,		255,	1),
		(4, 'folio', 'design',		7,		0,		1),
		(5, 'folio', 'design',		255,	255,	1),
		(6, 'folio', 'design',		135,	0,		1),
		(1, 'folio', 'logos',		1,		0,	1),
		(2, 'folio', 'logos',		1,		254,	1),
		(3, 'folio', 'logos',		0,		255,	1),
		(4, 'folio', 'logos',		7,		0,		1),
		(5, 'folio', 'logos',		255,	255,	1),
		(6, 'folio', 'logos',		135,	0,		1),
		(1, 'folio', 'photo',		1,		0,	1),
		(2, 'folio', 'photo',		1,		254,	1),
		(3, 'folio', 'photo',		0,		255,	1),
		(4, 'folio', 'photo',		7,		0,		1),
		(5, 'folio', 'photo',		255,	255,	1),
		(6, 'folio', 'photo',		135,	0,		1),
		(1, 'folio', 'hm',		1,		0,	1),
		(2, 'folio', 'hm',		1,		254,	1),
		(3, 'folio', 'hm',		0,		255,	1),
		(4, 'folio', 'hm',		7,		0,		1),
		(5, 'folio', 'hm',		255,	255,	1),
		(6, 'folio', 'hm',		135,	0,		1);
	");
}


?>