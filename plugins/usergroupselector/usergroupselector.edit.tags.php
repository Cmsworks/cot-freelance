<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags, users.register.tags, users.edit.tags
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

require_once cot_langfile('usergroupselector', 'plug');

$prfx = 'USERS_REGISTER_';
if ($m == 'edit')
{
	$prfx = 'USERS_EDIT_';
}
elseif ($m == 'profile')
{
	$prfx = 'USERS_PROFILE_';
}

if(($cfg['plugin']['usergroupselector']['allowchange'] || $cfg['plugin']['usergroupselector']['required']) 
	&& $urr['user_maingrp'] != COT_GROUP_SUPERADMINS 
	&& $urr['user_maingrp'] != COT_GROUP_MODERATORS)
{
	
	$options = explode(',', $cfg['plugin']['usergroupselector']['groups']);
	$groups_values = array();
	$groups_titles = array();
	foreach ($options as $v)
	{
		$groups_values[] = $v;
		$groups_titles[] = $cot_groups[$v]['title'];
		
		if($usergroup == $cot_groups[$v]['alias']) $usergroupid = $v;

		$t->assign(array(
			'USERGROUP_ROW_ID' => $v,
			'USERGROUP_ROW_TITLE' => $cot_groups[$v]['title'],
			'USERGROUP_ROW_ALIAS' => $cot_groups[$v]['alias'],
			'USERGROUP_ROW_ACTIVEID' => ($usergroup == $cot_groups[$v]['alias']) ? true : false,
		));
		$t->parse('MAIN.USERGROUP_ROW');		
	}
	
	if(count($groups_values) == 1)
	{
		$user_f_group = cot_checkbox($urr['user_usergroup'], 'ruserusergroup', $groups_titles[0], '', $groups_values[0]);
	}
	else
	{
		$user_f_group = cot_radiobox($urr['user_usergroup'], 'ruserusergroup', $groups_values, $groups_titles, '', '<br />');
	}
	$t->assign($prfx . 'GROUPSELECT', $user_f_group);
	$t->assign($prfx . 'GROUPSELECTBOX', cot_selectbox($urr['user_usergroup'], 'ruserusergroup', $groups_values, $groups_titles));
}