<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
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
	$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$ruserid)->fetch();

	if($urr['user_usergroup'] != $urr['user_maingrp'] 
		&& !empty($urr['user_usergroup']) 
		&& $urr['user_usergroup'] != COT_GROUP_SUPERADMINS
		&& $urr['user_usergroup'] != COT_GROUP_MODERATORS
		&& in_array($urr['user_usergroup'], $groupstoselect)
		&& $urr['user_maingrp'] != COT_GROUP_SUPERADMINS
		&& $urr['user_maingrp'] != COT_GROUP_MODERATORS)
	{
		$db->update($db_users, array('user_maingrp' => $urr['user_usergroup']), "user_id=".$urr['user_id']);
		$db->update($db_groups_users, array('gru_groupid' => $urr['user_usergroup']), "gru_userid=".$urr['user_id']." AND gru_groupid=".$urr['user_maingrp']);
	}	
}