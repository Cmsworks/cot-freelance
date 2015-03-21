<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags, users.register.tags, users.edit.tags
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

$prfx = 'USERS_REGISTER_';
if ($m == 'edit')
{
	$prfx = 'USERS_EDIT_';
}
elseif ($m == 'profile')
{
	$prfx = 'USERS_PROFILE_';
}
if ($prfx != 'USERS_REGISTER_')
{
	$rcats = explode(',', $urr['user_cats']);
}
$t->assign(array(
	$prfx . 'CAT' => cot_usercategories_treecheck($rcats, 'rcats[]')
));
