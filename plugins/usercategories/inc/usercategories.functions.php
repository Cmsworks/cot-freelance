<?php

/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('usercategories', 'plug');


global $cot_extrafields, $db_usercategories, $db_x, $db_usercategories_users;
$db_usercategories = (isset($db_usercategories)) ? $db_usercategories : $db_x . 'usercategories';
$db_usercategories_users = (isset($db_usercategories_users)) ? $db_usercategories_users : $db_x . 'usercategories_users';

function cot_usercategories_load()
{
	global $db, $db_usercategories, $cfg;
	$sql = $db->query("SELECT * FROM $db_usercategories WHERE 1 ORDER by cat_path ASC");

	$path = array(); // code path tree
	$tpath = array(); // title path tree
	
	$cot_usercategories = array(); // return array
	while ($row = $sql->fetch())
	{
		$last_dot = mb_strrpos($row['cat_path'], '.');

		if ($last_dot > 0)
		{
			$path1 = mb_substr($row['cat_path'], 0, $last_dot);
			$path[$row['cat_path']] = $path[$path1] . '.' . $row['cat_code'];
			$separaror = ($cfg['separator'] == strip_tags($cfg['separator'])) ? ' ' . $cfg['separator'] . ' ' : ' \ ';
			$tpath[$row['cat_path']] = $tpath[$path1] . $separaror . $row['cat_title'];
			$parent_dot = mb_strrpos($path[$path1], '.');
			$parent = ($parent_dot > 0) ? mb_substr($path[$path1], $parent_dot + 1) : $path[$path1];
		}
		else
		{
			$path[$row['cat_path']] = $row['cat_code'];
			$tpath[$row['cat_path']] = $row['structure_title'];
			$parent = $row['cat_code']; // self
		}
		$cot_usercategories[$row['cat_code']]['title'] = $row['cat_title'];
		$cot_usercategories[$row['cat_code']]['desc'] = $row['cat_desc'];
		$cot_usercategories[$row['cat_code']]['path'] = $row['cat_path'];

		$cot_usercategories[$row['cat_code']]['rpath'] = $path[$row['cat_path']];
	}

	return $cot_usercategories;
}

/**
 * Gets an array of usercategories category children
 *
 * @param string $cat Cat code
 * @param bool $allsublev All sublevels array
 * @param bool $firstcat Add main cat
 * @return array
 * @global array $cot_usercategories
 */
function cot_usercategories_children($cat, $allsublev = true, $firstcat = true)
{
	global $cot_usercategories;
	if (!empty($cat) && !is_array($cot_usercategories[$cat]))
	{
		return false;
	}
	if (!empty($cat))
	{
		$mtch = $cot_usercategories[$cat]['path'] . '.'; // путь с точкой
		$mtchlen = mb_strlen($mtch); // длинна пути
		$mtchlvl = mb_substr_count($mtch, "."); // уровень 
	}
	else
	{
		$mtch = ''; // путь с точкой
		$mtchlen = 0; // длинна пути
		$mtchlvl = 0; // уровень 
	}

	$catsub = array();
	if ($cat != '' && $firstcat)
	{
		$catsub[] = $cat;
	}

	foreach ($cot_usercategories as $i => $x)
	{
		if (mb_substr($x['path'], 0, $mtchlen) == $mtch && $i != $cat && ($allsublev || (!$allsublev && mb_substr_count($x['path'], ".") == $mtchlvl)))
		{
			$catsub[] = $i;
		}
	}
	return($catsub);
}

/**
 * Gets an array of usercategories category parents
 *
 * @param string $cat Cat code
 * @param string $type Type 'full', 'first', 'last'
 * @return mixed
 */
function cot_usercategories_parents($cat, $type = 'full')
{
	global $cot_usercategories;
	if (!array($cot_usercategories[$cat]))
	{
		return false;
	}
	$pathcodes = explode('.', $cot_usercategories[$cat]['rpath']);

	if ($type == 'first')
	{
		reset($pathcodes);
		$pathcodes = current($pathcodes);
	}
	elseif ($type == 'last')
	{
		$pathcodes = end($pathcodes);
	}

	return $pathcodes;
}

function cot_usercategories_treecheck($selected = array(), $name = 'ruc_cattree', $level = '', $enabled = true)
{
	global $R, $cot_usercategories;
	if (!is_array($selected))
	{
		$selected[] = $selected;
	}

	$getlevel = cot_usercategories_children($level, false, false);
	if (count($getlevel) == 0)
	{
		return false;
	}

	$t = new XTemplate(cot_tplfile(array('usercategories', 'cattree'), 'plug'));
	foreach ($getlevel as $cat)
	{
		$attr = ($enabled) ? '' : 'disabled="disabled"';
		$t->assign(array(
			'OPTION' => cot_checkbox(in_array($cat, $selected), $name . '[' . $cat . ']', $cot_usercategories[$cat]['title'], $attr),
			'SUBLEVEL' => cot_usercategories_treecheck($selected, $name, $cat, $enabled)
				));
		$t->parse('CAT_TREE_CHECK.ROW');
	}
	
	$t->parse('CAT_TREE_CHECK');
	return $t->text('CAT_TREE_CHECK');
}

function cot_usercategories_tree($selected = array(), $level = '', $template = '')
{
	global $R, $cot_usercategories, $gm, $group;

	if (!is_array($selected))
	{
		$selected[] = $selected;
	}

	$getlevel = cot_usercategories_children($level, false, false);
	if (count($getlevel) == 0)
	{
		return false;
	}
	
	$t = new XTemplate(cot_tplfile(array('usercategories', 'cattree', $template), 'plug'));
	foreach ($getlevel as $cat)
	{
		$t->assign(array(
			'OPTION' => $cot_usercategories[$cat]['title'],
			'SELECTED' => in_array($cat, $selected) ? 'active' : '',
			'HREF' => cot_url("users", "gm=" . $gm . "&cat=" . $cat."&group=".$group),
			'SUBLEVEL' => cot_usercategories_tree($selected, $cat)
		));
		$t->parse('CAT_TREE.ROW');
		
	}
	$t->parse('CAT_TREE');
	return $t->text('CAT_TREE');
}

function cot_usercategories_lighttree($selected = array(), $level = '', $full = false, $template = '')
{
	global $R, $cot_usercategories, $cot_groups, $gm, $urr;
	if (!is_array($selected))
	{
		$selected[] = $selected;
	}

	if (!$full)
	{
		$fullselect = array();
		foreach ($selected as $cat)
		{
			$cat_p = cot_usercategories_parents($cat);
			$fullselect = array_merge($fullselect, $cat_p);
		}
		$selected = array_unique($fullselect);
	}

	$getlevel = cot_usercategories_children($level, false, false);
	if (count($getlevel) == 0)
	{
		return false;
	}

	$count = 0;
	
	$t = new XTemplate(cot_tplfile(array('usercategories', 'cattree', $template), 'plug'));

	if(!empty($urr['user_maingrp']))
	{
		$group = $cot_groups[$urr['user_maingrp']]['alias'];
	}
	
	foreach ($getlevel as $cat)
	{
		if (in_array($cat, $selected))
		{
			$count++;
			$t->assign(array(
				'OPTION' => $cot_usercategories[$cat]['title'],
				'SELECTED' => in_array($cat, $selected) ? 'active' : '',
				'HREF' => cot_url("users", "gm=" . $gm . "&cat=" . $cat."&group=".$group),
				'SUBLEVEL' => cot_usercategories_lighttree($selected, $cat, true)
			));
			$t->parse('CAT_TREE.ROW');
		}
	}
	$t->parse('CAT_TREE');
	return ($count > 0) ? $t->text('CAT_TREE') : false;
}