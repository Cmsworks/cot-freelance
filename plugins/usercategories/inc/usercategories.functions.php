<?php

/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('usercategories', 'plug');

function cot_usercategories_treecheck($chosen, $name, $parent = '', $template = '', $userrights = 'W', $level = 0)
{
	global $structure, $cfg, $gm, $group;
	global $i18n_notmain, $i18n_locale, $i18n_read;
	
	if(empty($structure['usercategories'])){
		return false;
	}
	
	if (empty($parent)){
		$i18n_enabled = $i18n_read;
		$children = array();
		foreach ($structure['usercategories'] as $i => $x){
			if (mb_substr_count($structure['usercategories'][$i]['path'], ".") == 0){
				$children[] = $i;
			}
		}
	}
	else{
		$i18n_enabled = $i18n_read && cot_i18n_enabled($parent);
		$children = cot_structure_children('usercategories', $parent, false, false);
	}

	if (count($children) == 0){
		return false;
	}

	$t1 = new XTemplate(cot_tplfile(array('usercategories', 'catcheck', $template), 'plug'));

	$level++;
	foreach ($children as $row)
	{
		if(cot_auth('usercategories', $row, $userrights)){
			$subcats = cot_structure_children('usercategories', $row, false, false);
			$cattitle = htmlspecialchars($structure['usercategories'][$row]['title']);
			if ($i18n_enabled && $i18n_notmain){
				$x_i18n = cot_i18n_get_cat($row, $i18n_locale);
				if ($x_i18n){
					$cattitle = $x_i18n['title'];
				}
			}

			$t1->assign(array(
				"CAT_ROW_CAT" => $row,
				"CAT_ROW_CHECKBOX" => (is_array($chosen) && in_array($row, $chosen) || !is_array($chosen) && $row == $chosen) ? cot_checkbox($row, $name, $cattitle, '', $row) : cot_checkbox('', $name, $cattitle, '', $row),
				"CAT_ROW_SUBCAT" => (count($subcats) > 0) ? cot_usercategories_treecheck($chosen, $name, $row, $template, $userrights, $level) : '',
			));
			
			if ($i18n_enabled && $i18n_notmain){
				$x_i18n = cot_i18n_get_cat($row, $i18n_locale);
				if ($x_i18n){
					$urlparams = (!$cfg['plugin']['i18n']['omitmain'] || $i18n_locale != $cfg['defaultlang']) ? "gm=" . $gm . "&cat=" . $row. "&group=" . $group . "&l=" . $i18n_locale : "gm=" . $gm . "&cat=" . $row. "&group=" . $group;
					$t1->assign(array(
						'CAT_ROW_URL' => cot_url('users', $urlparams),
						'CAT_ROW_TITLE' => $x_i18n['title'],
						'CAT_ROW_DESC' => $x_i18n['desc'],
					));
				}
			}
			$t1->parse("MAIN.CAT_ROW");

			if($parent){
				$t1->assign(array(
					"CAT_TITLE" => htmlspecialchars($structure['usercategories'][$parent]['title']),
				));
			}

			$t1->assign(array(
				"CAT_LEVEL" => $level,
			));
		}
	}
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}

function cot_usercategories_tree($chosen = '', $parent = '', $template = '', $level = 0)
{
	global $structure, $cfg, $gm, $group;
	global $i18n_notmain, $i18n_locale, $i18n_read;
	
	if(empty($structure['usercategories'])){
		return false;
	}
	
	if (empty($parent)){
		$i18n_enabled = $i18n_read;
		$children = array();
		foreach ($structure['usercategories'] as $i => $x){
			if (mb_substr_count($structure['usercategories'][$i]['path'], ".") == 0){
				$children[] = $i;
			}
		}
	}
	else{
		$i18n_enabled = $i18n_read && cot_i18n_enabled($parent);
		$children = cot_structure_children('usercategories', $parent, false, false);
	}

	if (count($children) == 0){
		return false;
	}

	$t1 = new XTemplate(cot_tplfile(array('usercategories', 'cattree', $template), 'plug'));
	
	$level++;
	$jj = 0;
	foreach ($children as $row)
	{
		$jj++;
		$subcats = cot_structure_children('usercategories', $row, false, false);
		$t1->assign(array(
			"CAT_ROW_CAT" => $row,
			"CAT_ROW_TITLE" => htmlspecialchars($structure['usercategories'][$row]['title']),
			"CAT_ROW_DESC" => $structure['usercategories'][$row]['desc'],
			"CAT_ROW_COUNT" => $structure['usercategories'][$row]['count'],
			"CAT_ROW_ICON" => $structure['usercategories'][$row]['icon'],
			"CAT_ROW_URL" => cot_url("users", "gm=" . $gm . "&cat=" . $row . "&group=" . $group),
			"CAT_ROW_SELECTED" => (is_array($chosen) && in_array($row, $chosen) || !is_array($chosen) && $row == $chosen) ? 1 : 0,
			"CAT_ROW_SUBCAT" => (count($subcats) > 0) ? cot_usercategories_tree($chosen, $row, $template, $level) : '',
			"CAT_ROW_ODDEVEN" => cot_build_oddeven($jj),
			"CAT_ROW_JJ" => $jj
		));

		if ($i18n_enabled && $i18n_notmain){
			$x_i18n = cot_i18n_get_cat($row, $i18n_locale);
			if ($x_i18n){
				$urlparams = (!$cfg['plugin']['i18n']['omitmain'] || $i18n_locale != $cfg['defaultlang']) ? "gm=" . $gm . "&cat=" . $row. "&group=" . $group . "&l=" . $i18n_locale : "gm=" . $gm . "&cat=" . $row. "&group=" . $group;
				$t1->assign(array(
					'CAT_ROW_URL' => cot_url('users', $urlparams),
					'CAT_ROW_TITLE' => $x_i18n['title'],
					'CAT_ROW_DESC' => $x_i18n['desc'],
				));
			}
		}
		$t1->parse("MAIN.CAT_ROW");

		if($parent){
			$t1->assign(array(
				"CAT_TITLE" => htmlspecialchars($structure['usercategories'][$parent]['title']),
				"CAT_DESC" => $structure['usercategories'][$parent]['desc'],
				"CAT_COUNT" => $structure['usercategories'][$parent]['count'],
				"CAT_ICON" => $structure['usercategories'][$parent]['icon'],
			));
		}
		
		$t1->assign(array(
			"CAT_URL" => cot_url("users", "gm=" . $gm . "&cat=" . $parent . "&group=" . $group),
			"CAT_LEVEL" => $level,
		));
	}
	
	if ($jj == 0)
	{
		return false;
	}
	
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}

/**
 * Select users cat for search from
 * 
 * @global array $structure
 * @param type $check
 * @param type $name
 * @param type $subcat
 * @param type $hideprivate
 * @param type $is_module
 * @return type
 */
function cot_usercategories_selectcat($check, $name, $subcat = '', $hideprivate = true)
{
	global $structure;

	$structure['usercategories'] = (is_array($structure['usercategories'])) ? $structure['usercategories'] : array();

	$result_array = array();
	foreach ($structure['usercategories'] as $i => $x)
	{
		$display = ($hideprivate) ? cot_auth('usercategories', $i, 'R') : true;
		if ($display && !empty($subcat) && isset($structure['usercategories'][$subcat]))
		{
			$mtch = $structure['usercategories'][$subcat]['path'].".";
			$mtchlen = mb_strlen($mtch);
			$display = (mb_substr($x['path'], 0, $mtchlen) == $mtch || $i === $subcat);
		}

		if ((!$is_module || cot_auth('usercategories', $i, 'R')) && $i!='all' && $display)
		{
			$result_array[$i] = $x['tpath'];
		}
	}
	$result = cot_selectbox($check, $name, array_keys($result_array), array_values($result_array), true);

	return($result);
}