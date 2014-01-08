<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
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

defined('COT_CODE') or die('Wrong URL');


list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'locationselector', 'RWA');
cot_block($usr['isadmin']);

if (!$cot_countries) 
{
	include_once cot_langfile('countries', 'core');
}

require_once cot_incfile('forms');
if (!in_array($n, array('city', 'region', 'show')))
{
	$n = 'country';
}

require_once cot_incfile('locationselector', 'plug', $n);
