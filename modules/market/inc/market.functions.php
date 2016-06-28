<?php

/**
 * market module
 *
 * @package market
 * @version 2.5.7
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', 'any', 'RWA');

// Requirements
require_once cot_langfile('market', 'module');
require_once cot_incfile('forms');
require_once cot_incfile('extrafields');

// Tables and extras
cot::$db->registerTable('market');

cot_extrafields_register_table('market');

$structure['market'] = (is_array($structure['market'])) ? $structure['market'] : array();

/**
 * Update market categories counters
 *
 * @param string $cat Cat code
 * @return int
 * @global CotDB $db
 */
function cot_market_sync($cat)
{
	global $db, $db_structure, $db_market, $cache;
	
	$parent = cot_structure_parents('market', $cat, 'first');
	$cats = cot_structure_children('market', $parent, true, true);
	foreach($cats as $c)
	{
		$subcats = cot_structure_children('market', $c, true, true);
		$count = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_cat IN ('".implode("','", $subcats)."') AND item_state = 0")->fetchColumn();		
		$db->query("UPDATE $db_structure SET structure_count=".(int)$count." WHERE structure_area='market' AND structure_code = ?", $c);
		$summcount += $count;
		if($cat == $c) $catcount = $count;
	}
	$cache && $cache->db->remove('structure', 'system');
	
	return $catcount;
}

/**
 * Update product category code
 *
 * @param string $oldcat Old Cat code
 * @param string $newcat New Cat code
 * @return bool
 * @global CotDB $db
 */
function cot_market_updatecat($oldcat, $newcat)
{
	global $db, $db_structure, $db_market;
	return (bool)$db->update($db_market, array("item_cat" => $newcat), "item_cat='" . $db->prep($oldcat) . "'");
}


/**
 * Returns permissions for a product category.
 * @param  string $cat Category code
 * @return array       Permissions array with keys: 'auth_read', 'auth_write', 'isadmin'
 */
function cot_market_auth($cat = null)
{
	if (empty($cat))
	{
		$cat = 'any';
	}
	$auth = array();
	list($auth['auth_read'], $auth['auth_write'], $auth['isadmin']) = cot_auth('market', $cat, 'RWA1');
	return $auth;
}





function cot_build_structure_market_tree($parent = '', $selected = '', $level = 0, $template = '')
{
	global $structure, $cfg, $db, $sys, $cot_extrafields, $db_structure;
	global $i18n_notmain, $i18n_locale, $i18n_write, $i18n_admin, $i18n_read, $db_i18n_pages;

	$urlparams = array();

	/* === Hook === */
	foreach (cot_getextplugins('market.tree.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (empty($parent))
	{
		$i18n_enabled = $i18n_read;
		$children = array();
		foreach ($structure['market'] as $i => $x)
		{
			if (mb_substr_count($structure['market'][$i]['path'], ".") == 0)
			{
				$children[] = $i;
			}
		}
	}
	else
	{
		$i18n_enabled = $i18n_read && cot_i18n_enabled($parent);
		$children = $structure['market'][$parent]['subcats'];
	}

	$t1 = new XTemplate(cot_tplfile(array('market', 'tree', $template), 'module'));

	/* === Hook === */
	foreach (cot_getextplugins('market.tree.main') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (count($children) == 0)
	{
		return false;
	}

	$t1->assign(array(
		"TITLE" => htmlspecialchars($structure['market'][$parent]['title']),
		"DESC" => $structure['market'][$parent]['desc'],
		"COUNT" => $structure['market'][$parent]['count'],
		"ICON" => $structure['market'][$parent]['icon'],
		"HREF" => cot_url("market", $urlparams + array('c' => $parent)),
		"LEVEL" => $level,
	));

	$jj = 0;

	/* === Hook - Part1 : Set === */
	$extp = cot_getextplugins('market.tree.loop');
	/* ===== */

	foreach ($children as $row)
	{
		$jj++;
		$urlparams['c'] = $row;
		$subcats = $structure['market'][$row]['subcats'];
		$t1->assign(array(
			"ROW_TITLE" => htmlspecialchars($structure['market'][$row]['title']),
			"ROW_DESC" => $structure['market'][$row]['desc'],
			"ROW_COUNT" => $structure['market'][$row]['count'],
			"ROW_ICON" => $structure['market'][$row]['icon'],
			"ROW_HREF" => cot_url("market", $urlparams),
			"ROW_SELECTED" => ((is_array($selected) && in_array($row, $selected)) || (!is_array($selected) && $row == $selected)) ? 1 : 0,
			"ROW_SUBCAT" => (count($subcats) > 0) ? cot_build_structure_market_tree($row, $selected, $level + 1) : '',
			"ROW_LEVEL" => $level,
			"ROW_ODDEVEN" => cot_build_oddeven($jj),
			"ROW_JJ" => $jj
		));
		
		// Extra fields for structure
		foreach ($cot_extrafields[$db_structure] as $exfld)
		{
			$uname = strtoupper($exfld['field_name']);
			$t1->assign(array(
				'ROW_'.$uname.'_TITLE' => isset($L['structure_'.$exfld['field_name'].'_title']) ?  $L['structure_'.$exfld['field_name'].'_title'] : $exfld['field_description'],
				'ROW_'.$uname => cot_build_extrafields_data('structure', $exfld, $structure['market'][$row][$exfld['field_name']]),
				'ROW_'.$uname.'_VALUE' => $structure['market'][$row][$exfld['field_name']],
			));
		}

		if ($i18n_enabled && $i18n_notmain){
			$x_i18n = cot_i18n_get_cat($row, $i18n_locale);
			if ($x_i18n){
				if(!$cfg['plugin']['i18n']['omitmain'] || $i18n_locale != $cfg['defaultlang']){
					$urlparams['l'] = $i18n_locale;
				}
				$t1->assign(array(
					'ROW_URL' => cot_url('market', $urlparams),
					'ROW_TITLE' => $x_i18n['title'],
					'ROW_DESC' => $x_i18n['desc'],
				));
			}
		}

		/* === Hook - Part2 : Include === */
		foreach ($extp as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t1->parse("MAIN.CATS");
	}
	if ($jj == 0)
	{
		return false;
	}
	$t1->parse("MAIN");
	return $t1->text("MAIN");
}

/**
 * Returns all product tags for coTemplate
 *
 * @param mixed $item_data product Info Array or ID
 * @param string $tag_prefix Prefix for tags
 * @param int $textlength Text truncate
 * @param bool $admin_rights product Admin Rights
 * @param bool $pagepath_home Add home link for page path
 * @param string $emptytitle Page title text if page does not exist
 * @return array
 * @global CotDB $db
 */
function cot_generate_markettags($item_data, $tag_prefix = '', $textlength = 0, $admin_rights = null,
									 $pagepath_home = false, $emptytitle = '')
{
	global $db, $cot_extrafields, $cfg, $L, $Ls, $R, $db_market, $usr, $sys, $cot_yesno, $structure, $db_structure;

	static $extp_first = null, $extp_main = null;

	if (is_null($extp_first))
	{
		$extp_first = cot_getextplugins('markettags.first');
		$extp_main = cot_getextplugins('markettags.main');
	}

	/* === Hook === */
	foreach ($extp_first as $pl)
	{
		include $pl;
	}
	/* ===== */
	if (!is_array($item_data))
	{
		$sql = $db->query("SELECT * FROM $db_market WHERE item_id = '" . (int)$item_data . "' LIMIT 1");
		$item_data = $sql->fetch();
	}

	if ($item_data['item_id'] > 0 && !empty($item_data['item_title']))
	{
		if (is_null($admin_rights))
		{
			$admin_rights = cot_auth('market', $item_data['item_cat'], 'A');
		}

		$item_data['item_pageurl'] = (empty($item_data['item_alias'])) ? 
			cot_url('market', 'c='.$item_data['item_cat'].'&id='.$item_data['item_id']) : cot_url('market', 'c='.$item_data['item_cat'].'&al='.$item_data['item_alias']);
		
		$catpatharray[] = array(cot_url('market'), $L['market']);
		$itempatharray[] = array($item_data['item_pageurl'], $item_data['item_title']);

		$patharray = array_merge($catpatharray, cot_structure_buildpath('market', $item_data['item_cat']), $itempatharray);

		$itempath = cot_breadcrumbs($patharray, $pagepath_home, true);

		$patharray = array_merge($catpatharray, cot_structure_buildpath('market', $item_data['item_cat']));
		$catpath = cot_breadcrumbs($patharray, $pagepath_home, true);

		$text = cot_parse($item_data['item_text'], $cfg['market']['markup'], $item_data['item_parser']);
		$text_cut = ((int)$textlength > 0) ? cot_string_truncate($text, $textlength) : $text;
		
		$item_data['item_status'] = cot_market_status($item_data['item_state']);
		
		$temp_array = array(
			'ID' => $item_data['item_id'],
			'ALIAS' => $item_data['item_alias'],
			'STATE' => $item_data['item_state'],
			'STATUS' => $item_data['item_status'],
			'LOCALSTATUS' => $L['market_status_'.$item_data['item_status']],
			'URL' => $item_data['item_pageurl'],
			'USER_PRDURL' => cot_url('users', 'm=details&id=' . $item_data['item_userid'] . '&u=' . $item_data['user_name'] . '&tab=market'),
			'TITLE' => $itempath,
			'SHORTTITLE' => $item_data['item_title'],
			'CAT' => $item_data['item_cat'],
			'CATTITLE' => htmlspecialchars($structure['market'][$item_data['item_cat']]['title']),
			'CATURL' => cot_url('market', 'c=' . $item_data['item_cat']),
			'CATPATH' => $catpath,
			'TEXT' => $text,
			'SHORTTEXT' => $text_cut,
			'COST' => (floor($item_data['item_cost']) != $item_data['item_cost']) ? number_format($item_data['item_cost'], '2', '.', ' ') : number_format($item_data['item_cost'], '0', '.', ' '),
			'DATE' => cot_date('datetime_medium', $item_data['item_date']),
			'DATE_STAMP' => $item_data['item_date'],
			'SHOW_URL' => $item_data['item_pageurl'],
			'COUNT' => $item_data['item_count'],
			'USER_IS_ADMIN' => ($admin_rights || $usr['id'] == $item_data['item_userid']),
		);

		if ($admin_rights || $usr['id'] == $item_data['item_userid'])
		{
			$temp_array['ADMIN_EDIT'] = cot_rc_link(cot_url('market', 'm=edit&id=' . $item_data['item_id']), $L['Edit']);
			$temp_array['ADMIN_EDIT_URL'] = cot_url('market', 'm=edit&id=' . $item_data['item_id']);
			$temp_array['HIDEPRODUCT_URL'] = cot_url('market', 'm=edit&id=' . $item_data['item_id'] .	(($item_data['item_state'] == 1) ? '&a=public' : '&a=hide'));
			$temp_array['HIDEPRODUCT_TITLE'] = ($item_data['item_state'] == 1) ? $L['Publish'] : $L['Hide'];
		}

		// Extrafields
		if (isset($cot_extrafields[$db_market]))
		{
			foreach ($cot_extrafields[$db_market] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array[$tag . '_TITLE'] = isset($L['market_' . $exfld['field_name'] . '_title']) ? $L['market_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
				$temp_array[$tag] = cot_build_extrafields_data('market', $exfld, $item_data['item_' . $exfld['field_name']]);
			}
		}

		// Extra fields for structure
		if (isset($cot_extrafields[$db_structure]))
		{
			foreach ($cot_extrafields[$db_structure] as $exfld)
			{
				$tag = mb_strtoupper($exfld['field_name']);
				$temp_array['CAT_' . $tag . '_TITLE'] = isset($L['structure_' . $exfld['field_name'] . '_title']) ? $L['structure_' . $exfld['field_name'] . '_title'] : $exfld['field_description'];
				$temp_array['CAT_' . $tag] = cot_build_extrafields_data('structure', $exfld,
															$structure['market'][$item_data['item_cat']][$exfld['field_name']]);
			}
		}

		/* === Hook === */
		foreach ($extp_main as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	else
	{
		$temp_array = array(
			'TITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
			'SHORTTITLE' => (!empty($emptytitle)) ? $emptytitle : $L['Deleted'],
		);
	}

	$return_array = array();
	foreach ($temp_array as $key => $val)
	{
		$return_array[$tag_prefix . $key] = $val;
	}

	return $return_array;
}



/**
 * Determines products status
 *
 * @param int $item_state
 * @return string 'hidden', 'moderated', 'published'
 */
function cot_market_status($item_state)
{
	global $sys;

	if ($item_state == 0)
	{
		return 'published';
	}
	elseif ($item_state == 2)
	{
		return 'moderated';
	}
	return 'hidden';
}


/**
 * Returns possible values for category sorting order
 */
function cot_market_config_order()
{
	global $cot_extrafields, $L, $db_market;

	$options_sort = array(
		'id' => $L['Id'],
		'title' => $L['Title'],
		'text' => $L['Body'],
		'userid' => $L['Owner'],
		'date' => $L['Date']
	);

	foreach($cot_extrafields[$db_market] as $exfld)
	{
		$options_sort[$exfld['field_name']] = isset($L['market_'.$exfld['field_name'].'_title']) ? $L['market_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
	}

	$L['cfg_order_params'] = array_values($options_sort);
	return array_keys($options_sort);
}




/**
 * Imports product data from request parameters.
 * @param  string $source Source request method for parameters
 * @param  array  $ritem  Existing product data from database
 * @param  array  $auth   Permissions array
 * @return array          Product data
 */
function cot_market_import($source = 'POST', $ritem = array(), $auth = array())
{
	global $cfg, $db_market, $cot_extrafields, $usr, $sys;

	if (count($auth) == 0)
	{
		$auth = cot_page_auth($ritem['item_cat']);
	}

	if ($source == 'D' || $source == 'DIRECT')
	{
		// A trick so we don't have to affect every line below
		global $_PATCH;
		$_PATCH = $ritem;
		$source = 'PATCH';
	}

	$ritem['item_cat'] = cot_import('rcat', $source, 'TXT');
	$ritem['item_title'] = cot_import('rtitle', $source, 'TXT');	
	$ritem['item_alias'] = cot_import('ralias', $source, 'TXT');
	$ritem['item_text'] = cot_import('rtext', $source, 'HTM');
	$ritem['item_cost'] = cot_import('rcost', $source, 'NUM');
	$ritem['item_parser'] = cot_import('rparser', $source, 'ALP');
	
	if(empty($ritem['item_date']))
	{
		$ritem['item_date'] = (int)$sys['now'];
	}
	else
	{
		$ritem['item_update'] = (int)$sys['now'];
	}
	
	if ($auth['isadmin'] && isset($ritem['item_userid']))
	{
		$ritem['item_count']     = cot_import('rcount', $source, 'INT');
		$ritem['item_userid']   = $ritem['item_userid'];
	}
	else
	{
		$ritem['item_userid'] = $usr['id'];
	}
	
	// Extra fields
	foreach ($cot_extrafields[$db_market] as $exfld)
	{
		$ritem['item_'.$exfld['field_name']] = cot_import_extrafields('ritem'.$exfld['field_name'], $exfld, $source, $ritem['item_'.$exfld['field_name']]);
	}
	
	return $ritem;
}



/**
 * Validates product data.
 * @param  array   $ritem Imported product data
 * @return boolean        TRUE if validation is passed or FALSE if errors were found
 */
function cot_market_validate($ritem)
{
	global $cfg, $structure;
	cot_check(empty($ritem['item_cat']), 'market_select_cat', 'rcat');
	if ($structure['market'][$ritem['item_cat']]['locked'])
	{
		cot_error('market_locked_cat', 'rcat');
	}
	cot_check(mb_strlen($ritem['item_title']) < 2, 'market_empty_title', 'rtitle');
	cot_check(!empty($ritem['item_alias']) && preg_match('`[+/?%#&]`', $ritem['item_alias']), 'market_aliascharacters', 'ralias');

	$allowemptytext = isset($cfg['market']['cat_' . $ritem['item_cat']]['allowemptytext']) ?
							$cfg['market']['cat_' . $ritem['item_cat']]['allowemptytext'] : $cfg['market']['cat___default']['allowemptytext'];
	cot_check(!$allowemptytext && empty($ritem['item_text']), 'market_empty_text', 'rtext');

	return !cot_error_found();
}



/**
 * Adds a new product to the CMS.
 * @param  array   $ritem product data
 * @param  array   $auth  Permissions array
 * @return integer        New product ID or FALSE on error
 */
function cot_market_add(&$ritem, $auth = array())
{
	global $cache, $cfg, $db, $db_market, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_market_auth($ritem['item_cat']);
	}
	
	if(!$cfg['market']['preview']){
		$ritem['item_state'] = (!$cfg['market']['prevalidate'] || $auth['isadmin']) ? 0 : 2;
	}
	else
	{
		$ritem['item_state'] = 1;
	}

	if (!empty($ritem['item_alias']))
	{
		$prd_count = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_alias = ?", $ritem['item_alias'])->fetchColumn();
		if ($prd_count > 0)
		{
			$ritem['item_alias'] = $ritem['item_alias'].rand(1000, 9999);
		}
	}
	/* === Hook === */
	foreach (cot_getextplugins('market.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($db->insert($db_market, $ritem))
	{
		$id = $db->lastInsertId();

		cot_extrafield_movefiles();
	}
	else
	{
		$id = false;
	}
	
	cot_market_sync($ritem['item_cat']);
	
	/* === Hook === */
	foreach (cot_getextplugins('market.add.add.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_shield_update(30, "r product");
	cot_log("Add product #".$id, 'adm');

	return $id;
}




/**
 * Removes a product from the CMS.
 * @param  int     $id    Product ID
 * @param  array   $rpage Product data
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_market_delete($id, $ritem = array())
{
	global $db, $db_market, $db_structure, $cache, $cfg, $cot_extrafields, $structure, $L;
	if (!is_numeric($id) || $id <= 0)
	{
		return false;
	}
	$id = (int)$id;
	if (count($ritem) == 0)
	{
		$ritem = $db->query("SELECT * FROM $db_market WHERE item_id = ?", $id)->fetch();
		if (!$ritem)
		{
			return false;
		}
	}

	foreach ($cot_extrafields[$db_market] as $exfld)
	{
		cot_extrafield_unlinkfiles($ritem['item_' . $exfld['field_name']], $exfld);
	}

	$db->delete($db_market, "item_id = ?", $id);
	cot_log("Deleted product #" . $id, 'adm');

	cot_market_sync($ritem['item_cat']);
	
	/* === Hook === */
	foreach (cot_getextplugins('market.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	return true;
}

/**
 * Updates a product in the CMS.
 * @param  integer $id    Product ID
 * @param  array   $ritem Product data
 * @param  array   $auth  Permissions array
 * @return boolean        TRUE on success, FALSE on error
 */
function cot_market_update($id, &$ritem, $auth = array())
{
	global $cache, $cfg, $db, $db_market, $db_structure, $structure, $L;
	if (cot_error_found())
	{
		return false;
	}

	if (count($auth) == 0)
	{
		$auth = cot_market_auth($ritem['item_cat']);
	}

	if (!empty($ritem['item_alias']))
	{
		$prd_count = $db->query("SELECT COUNT(*) FROM $db_market WHERE item_alias = ? AND item_id != ?", array($ritem['item_alias'], $id))->fetchColumn();
		if ($prd_count > 0)
		{
			$ritem['item_alias'] = $ritem['item_alias'].rand(1000, 9999);
		}
	}

	$item = $db->query("SELECT * FROM $db_market WHERE item_id = ?", $id)->fetch();	
	
	if(!$cfg['market']['preview']){
		$ritem['item_state'] = (!$cfg['market']['prevalidate'] || $auth['isadmin']) ? 0 : 2;
	}
	else
	{
		$ritem['item_state'] = 1;
	}
	
	if (!$db->update($db_market, $ritem, 'item_id = ?', $id))
	{
		return false;
	}

	cot_market_sync($item['item_cat']);
	cot_market_sync($ritem['item_cat']);
	
	cot_extrafield_movefiles();

	/* === Hook === */
	foreach (cot_getextplugins('market.edit.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	return true;
}



function cot_getmarketlist($template = 'index', $count = 5, $sqlsearch = '',
							 $order = "item_date DESC")
{
	global $db, $db_market, $cfg, $db_users;
	
	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', 'any', 'RWA');
	
	$t = new XTemplate(cot_tplfile(array('market', $template), 'module'));
	
	$sqlsearch = !empty($sqlsearch) ? " AND " . $sqlsearch : '';
	
	$sqllist = $db->query("SELECT * FROM $db_market AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	WHERE item_state=0 $sqlsearch ORDER BY $order LIMIT " . (int)$count);
	
	$sqllist_rowset = $sqllist->fetchAll();
	$sqllist_idset = array();
	foreach($sqllist_rowset as $item)
	{
		$sqllist_idset[$item['item_id']] = $item['item_alias'];
	}
	
	foreach($sqllist_rowset as $item)
	{
		$jj++;
		$t->assign(cot_generate_usertags($item, 'PRD_ROW_OWNER_'));
		$t->assign(cot_generate_markettags($item, 'PRD_ROW_', $cfg['market']['shorttextlen'],
													$usr['isadmin'], $cfg['homebreadcrumb']));
		$t->assign(array(
			"PRD_ROW_ODDEVEN" => cot_build_oddeven($jj),
		));
		$t->parse("MARKET.PRD_ROWS");
	}

	$t->parse("MARKET");

	return $t->text("MARKET");
}



/**
 * Select market cat for search from
 * 
 * @global array $structure
 * @param type $check
 * @param type $name
 * @param type $subcat
 * @param type $hideprivate
 * @param type $is_module
 * @return type
 */
function cot_market_selectcat($check, $name, $subcat = '', $hideprivate = true)
{
	global $structure;

	$structure['market'] = (is_array($structure['market'])) ? $structure['market'] : array();

	$result_array = array();
	foreach ($structure['market'] as $i => $x)
	{
		$display = ($hideprivate) ? cot_auth('market', $i, 'R') : true;
		if (!empty($subcat) && isset($structure['market'][$subcat]))
		{
			$mtch = $structure['market'][$subcat]['path'].".";
			$mtchlen = mb_strlen($mtch);
			$display = (mb_substr($x['path'], 0, $mtchlen) == $mtch || $i === $subcat);
		}

		if ((!$is_module || cot_auth('market', $i, 'R')) && $i!='all' && $display)
		{
			$result_array[$i] = $x['tpath'];
		}
	}
	$result = cot_selectbox($check, $name, array_keys($result_array), array_values($result_array), true);

	return($result);
}

if ($cfg['market']['markup'] == 1){
  $prdeditor = $cfg['market']['prdeditor'];
}