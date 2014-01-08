<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=99
 * [END_COT_EXT]
 */
/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */
defined('COT_CODE') or die('Wrong URL.');

$group = cot_import('group', 'G', 'ALP');

if(!empty($group))
{
	foreach($cot_groups as $i => $grp)
	{
		if($grp['alias'] == $group)
		{
			$where['group'] = "user_maingrp=".$i;
			unset($title);
			$title[] = $cot_groups[$i]['name'];
			$subtitle = $cot_groups[$i]['name'];
			break;
		}
	}
	
	$users_url_path['group'] = $group;
	$localskin = cot_tplfile(array('users', $group), 'module');
}

