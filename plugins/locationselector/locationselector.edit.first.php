<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.edit.update.first, users.register.add.first, users.profile.update.first
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

if (function_exists('cot_import_location'))
{
	$location = cot_import_location('P');
	$ruser['user_country'] = $location['country'];
	$ruser['user_region'] = $location['region'];
	$ruser['user_city'] = $location['city'];
	$_POST['rcountry'] = $ruser['user_country'];
	$_POST['rusercountry'] = $ruser['user_country'];
}
