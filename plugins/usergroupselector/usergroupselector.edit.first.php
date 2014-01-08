<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.first, users.edit.update.first, users.register.add.first
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
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('usergroupselector', 'plug');

if(($cfg['plugin']['usergroupselector']['allowchange'] || $cfg['plugin']['usergroupselector']['required']) 
	&& !empty($cfg['plugin']['usergroupselector']['groups'])
	&& $urr['user_maingrp'] != COT_GROUP_SUPERADMINS 
	&& $urr['user_maingrp'] != COT_GROUP_MODERATORS)
{
	$groupstoselect = explode(',', $cfg['plugin']['usergroupselector']['groups']);
	$ruser['user_usergroup'] = cot_import('ruserusergroup','P','INT');
	
	if($cfg['plugin']['usergroupselector']['required'])
	{	
		cot_check((empty($ruser['user_usergroup']) || !in_array($ruser['user_usergroup'], $groupstoselect)), $L['usergroupselector_error_emptygroup'], 'rusergroup');
	}
}