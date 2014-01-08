<?php 

defined('COT_CODE') or die('Wrong URL');


require_once cot_incfile('market', 'module');

global $db_structure, $db_foliostore, $db_market, $db_auth, $db_mavatars;

if(cot_module_active('foliostore'))
{	
	require_once cot_incfile('foliostore', 'module');
	// Копируем структуру модуля Foliostore в Market
	$sql = $db->query("SELECT * FROM $db_structure WHERE structure_area='foliostore'");
	while($row = $sql->fetch())
	{
		unset($row['structure_id']);
		$row['structure_area'] = 'market';

		$db->insert($db_structure, $row);
	}

	// Копируем права структуры Foliostore
	$sql = $db->query("SELECT * FROM $db_auth WHERE auth_code='foliostore'");
	while($row = $sql->fetch())
	{
		unset($row['auth_id']);
		$row['auth_code'] = 'market';

		$db->insert($db_auth, $row);
	}

	// Копируем записи из таблицы Foliostore в Market
	// При этом также переименовываем загруженные изображения в плагине Mavatars
	$sql = $db->query("SELECT * FROM $db_foliostore WHERE item_store=1");
	while($row = $sql->fetch())
	{
		$folioid = $row['item_id'];

		unset($row['item_id']);
		unset($row['item_store']);
		unset($row['item_index']);

		$db->insert($db_market, $row);
		$id = $db->lastInsertId();

		if(cot_plugin_active('mavatars'))
		{
			if($mav = $db->query("SELECT * FROM $db_mavatars WHERE mav_code=" . $folioid . " AND mav_extension='foliostore'")->fetch())
			{
				unset($mav['mav_id']);
				$mav['mav_extension'] = 'market';
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
		('market', 'soft', '001', '', 'Программы', '', '', 0, 0),
		('market', 'sites', '002', '', 'Сайты', '', '', 0, 0),
		('market', 'design', '003', '', 'Дизайн', '', '', 0, 0),
		('market', 'logos', '004', '', 'Логотипы', '', '', 0, 0),
		('market', 'photos', '005', '', 'Фотографии', '', '', 0, 0),
		('market', 'hm', '006', '', 'Hand-made', '', '', 0, 0);
	");
	
	
	$db->query("INSERT INTO $db_auth (`auth_groupid`, `auth_code`, `auth_option`,
		`auth_rights`, `auth_rights_lock`, `auth_setbyuserid`) VALUES
		(1, 'market', 'soft',	1,		0,	1),
		(2, 'market', 'soft',	1,		254,	1),
		(3, 'market', 'soft',	0,		255,	1),
		(4, 'market', 'soft',	7,		0,		1),
		(5, 'market', 'soft',	255,	255,	1),
		(6, 'market', 'soft',	135,	0,		1),
		(1, 'market', 'sites',	1,		0,	1),
		(2, 'market', 'sites',	1,		254,	1),
		(3, 'market', 'sites',	0,		255,	1),
		(4, 'market', 'sites',	7,		0,		1),
		(5, 'market', 'sites',	255,	255,	1),
		(6, 'market', 'sites',	135,	0,		1),
		(1, 'market', 'design',		1,		0,	1),
		(2, 'market', 'design',		1,		254,	1),
		(3, 'market', 'design',		0,		255,	1),
		(4, 'market', 'design',		7,		0,		1),
		(5, 'market', 'design',		255,	255,	1),
		(6, 'market', 'design',		135,	0,		1),
		(1, 'market', 'logos',		1,		0,	1),
		(2, 'market', 'logos',		1,		254,	1),
		(3, 'market', 'logos',		0,		255,	1),
		(4, 'market', 'logos',		7,		0,		1),
		(5, 'market', 'logos',		255,	255,	1),
		(6, 'market', 'logos',		135,	0,		1),
		(1, 'market', 'photo',		1,		0,	1),
		(2, 'market', 'photo',		1,		254,	1),
		(3, 'market', 'photo',		0,		255,	1),
		(4, 'market', 'photo',		7,		0,		1),
		(5, 'market', 'photo',		255,	255,	1),
		(6, 'market', 'photo',		135,	0,		1),
		(1, 'market', 'hm',		1,		0,	1),
		(2, 'market', 'hm',		1,		254,	1),
		(3, 'market', 'hm',		0,		255,	1),
		(4, 'market', 'hm',		7,		0,		1),
		(5, 'market', 'hm',		255,	255,	1),
		(6, 'market', 'hm',		135,	0,		1);
	");
}

?>