<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.tags, users.register.tags, users.edit.tags
 * [END_COT_EXT]
 */
/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

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
	$ruser['user_country'] = $urr['user_country'];
	$ruser['user_region'] = $urr['user_region'];
	$ruser['user_city'] = $urr['user_city'];
}
$t->assign(array(
	$prfx . 'LOCATION' => (function_exists('cot_select_location')) ?
			cot_select_location($ruser['user_country'], $ruser['user_region'], $ruser['user_city']) : '',
));
