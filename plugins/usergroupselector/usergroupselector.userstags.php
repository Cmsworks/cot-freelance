<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
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

if(is_array($user_data)){
	if(empty($user_data['user_usergroup'])) $user_data['user_usergroup'] = $user_data['user_maingrp'];

	$temp_array['USERSELECTED_GROUP'] = $user_data['user_usergroup'];
	$temp_array['USERSELECTED_GROUP_ALIAS'] = $cot_groups[$user_data['user_usergroup']]['alias'];
	$temp_array['USERSELECTED_GROUP_NAME'] = $cot_groups[$user_data['user_usergroup']]['name'];
	$temp_array['USERSELECTED_GROUP_TITLE'] = $cot_groups[$user_data['user_usergroup']]['title'];
	$temp_array['USERSELECTED_GROUP_URL'] = cot_url('users', 'group='.$cot_groups[$user_data['user_usergroup']]['alias']);
}