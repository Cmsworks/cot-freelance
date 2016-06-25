<?php

defined('COT_CODE') or die('Wrong URL');

function cot_load_structure_custom()
{
	global $db, $db_structure, $cfg, $cot_extrafields, $structure;
	$structure = array();
	if (defined('COT_UPGRADE'))
	{
		$sql = $db->query("SELECT * FROM $db_structure ORDER BY structure_path ASC");
		$row['structure_area'] = 'page';
	}
	else
	{
		$sql = $db->query("SELECT * FROM $db_structure ORDER BY structure_area ASC, structure_path ASC");
	}

	/* == Hook: Part 1 ==*/
	$extp = cot_getextplugins('structure');
	/* ================= */

	$path = array(); // code path tree
	$tpath = array(); // title path tree
	$tpls = array(); // tpl codes tree

	foreach ($sql->fetchAll() as $row)
	{
		$last_dot = mb_strrpos($row['structure_path'], '.');

		$row['structure_tpl'] = empty($row['structure_tpl']) ? $row['structure_code'] : $row['structure_tpl'];

		if ($last_dot > 0)
		{
			$path1 = mb_substr($row['structure_path'], 0, $last_dot);
			$path[$row['structure_path']] = $path[$path1] . '.' . $row['structure_code'];
			$separaror = ($cfg['separator'] == strip_tags($cfg['separator'])) ? ' ' . $cfg['separator'] . ' ' : ' \ ';
			$tpath[$row['structure_path']] = $tpath[$path1] . $separaror . $row['structure_title'];
			$parent_dot = mb_strrpos($path[$path1], '.');
			$parent = ($parent_dot > 0) ? mb_substr($path[$path1], $parent_dot + 1) : $path[$path1];
			$subcats[$row['structure_area']][$parent][] = $row['structure_code'];
		}
		else
		{
			$path[$row['structure_path']] = $row['structure_code'];
			$tpath[$row['structure_path']] = $row['structure_title'];
			$parent = $row['structure_code']; // self
		}

		if ($row['structure_tpl'] == 'same_as_parent')
		{
			$row['structure_tpl'] = $tpls[$parent];
		}

		$tpls[$row['structure_code']] = $row['structure_tpl'];

		$structure[$row['structure_area']][$row['structure_code']] = array(
			'path' => $path[$row['structure_path']],
			'tpath' => $tpath[$row['structure_path']],
			'rpath' => $row['structure_path'],
			'id' => $row['structure_id'],
			'tpl' => $row['structure_tpl'],
			'title' => $row['structure_title'],
			'desc' => $row['structure_desc'],
			'icon' => $row['structure_icon'],
			'locked' => $row['structure_locked'],
			'count' => $row['structure_count']
		);

		if (is_array($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$structure[$row['structure_area']][$row['structure_code']][$exfld['field_name']] = $row['structure_'.$exfld['field_name']];
			}
		}

		/* == Hook: Part 2 ==*/
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ================= */
	}

	foreach ($structure as $area => $area_structure)
	{
		foreach ($area_structure as $i => $x)
		{
			$structure[$area][$i]['subcats'] = $subcats[$area][$i];
		}
	}
}