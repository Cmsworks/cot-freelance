<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.done, users.register.add.done, users.edit.update.done
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

if(!empty($cfg['plugin']['usergroupselector']['groups']))
{
	$groupstoselect = explode(',', $cfg['plugin']['usergroupselector']['groups']);
	
	$r_id = $usr['id'];
	if ($m == 'edit')
	{
		$r_id = $id;
	}
	elseif ($m == 'register')
	{
		$r_id = $userid;
	}
	if (in_array($m, array('profile', 'edit'))
		&& ($cfg['plugin']['usergroupselector']['allowchange'] || $usr['isadmin'])
		&& $ruser['user_usergroup'] != $urr['user_maingrp'] 
		&& $ruser['user_usergroup'] != COT_GROUP_SUPERADMINS
		&& $ruser['user_usergroup'] != COT_GROUP_MODERATORS
		&& in_array($ruser['user_usergroup'], $groupstoselect)	
		&& $urr['user_maingrp'] != COT_GROUP_SUPERADMINS
		&& $urr['user_maingrp'] != COT_GROUP_MODERATORS)	
	{
		$db->update($db_users, array('user_maingrp'=>$ruser['user_usergroup']), "user_id=".$r_id);
		$db->update($db_groups_users, array('gru_groupid' => $ruser['user_usergroup']), "gru_userid=".$r_id." AND gru_groupid=".$urr['user_maingrp']);
	}
}