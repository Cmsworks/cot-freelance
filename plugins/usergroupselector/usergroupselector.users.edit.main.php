<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.main,users.profile.main,users.edit.main,users.register.main
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

if($m == 'register')
{
	$usergroup = cot_import('usergroup', 'G', 'ALP');
	$mskin = cot_tplfile(array('users', $m, $usergroup), 'module');
}
elseif(!empty($cot_groups[$urr['user_maingrp']]['alias']))
{
	$mskin = cot_tplfile(array('users', $m, $cot_groups[$urr['user_maingrp']]['alias']), 'module');
}