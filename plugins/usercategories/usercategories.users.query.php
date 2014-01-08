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

$group = cot_import('group', 'G', 'ALP');
$cat = cot_import('cat', 'G', 'ALP');

if (!empty($cat))
{
	$out['subtitle'] = ($cot_usercategories[$cat]['mtitle']) ? $cot_usercategories[$cat]['mtitle'] : $cot_usercategories[$cat]['title'];
	$out['meta_desc'] = (!empty($cot_usercategories[$cat]['mdesc'])) ? $cot_usercategories[$cat]['mdesc'] : '';
	$out['meta_keywords'] = (!empty($cot_usercategories[$cat]['mkey'])) ? $cot_usercategories[$cat]['mkey'] : '';

	$catsub = cot_usercategories_children($cat);
	foreach($cot_groups as $grpid => $grp)
	{
		if($group == $grp['alias'])
		{
			$g = $grpid;
			break;
		}
	}
	if($g > 1)
	{
		$where['maingrp'] = "user_maingrp=$g";
	}
	
	$where['user_cat'] = "1 GROUP BY user_id";
	$join_condition .= " JOIN $db_usercategories_users AS flu ON (u.user_id=flu.ucat_userid AND ucat_cat IN ('" . implode("','", $catsub) . "'))";
	
	$users_url_path['cat'] =  $cat;
}
