<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=99
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('usercategories', 'plug');

$cat = cot_import('cat', 'G', 'ALP');

if (!empty($cat))
{
	$out['subtitle'] = ($cot_usercategories[$cat]['mtitle']) ? $cot_usercategories[$cat]['mtitle'] : $cot_usercategories[$cat]['title'];
	$out['meta_desc'] = (!empty($cot_usercategories[$cat]['mdesc'])) ? $cot_usercategories[$cat]['mdesc'] : '';
	$out['meta_keywords'] = (!empty($cot_usercategories[$cat]['mkey'])) ? $cot_usercategories[$cat]['mkey'] : '';

	$catsub = cot_usercategories_children($cat);
	$sql = $db->query("SELECT ucat_userid FROM $db_usercategories_users WHERE ucat_cat IN ('" . implode("','", $catsub) . "')");
	while ($sqlcatuser = $sql->fetch()){
		$catusers[] = $sqlcatuser['ucat_userid'];
	}
	if(is_array($catusers)){
		$where['cat'] = "user_id IN (" . implode(",", $catusers) . ")";
	}
	$users_url_path['cat'] =  $cat;
}
