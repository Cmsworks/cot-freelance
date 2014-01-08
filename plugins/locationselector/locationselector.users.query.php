<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=99
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

$c = cot_import('c', 'G', 'TXT');
if (function_exists('cot_import_location'))
{
	$location = cot_import_location('slocation', 'G');
}
if (function_exists('cot_getlocation'))
{
	$location_info = cot_getlocation($location['country'], $location['region'], $location['city']);
	$out['subtitle'] .= (!empty($location_info['country'])) ? ' - ' . $location_info['country'] : '';
	$out['subtitle'] .= (!empty($location_info['region'])) ? ' - ' . $location_info['region'] : '';
	$out['subtitle'] .= (!empty($location_info['city'])) ? ' - ' . $location_info['city'] : '';
}

(!empty($location['country'])) && $where['user_country'] = "user_country='" . $location['country']."'";
((int) $location['region'] > 0) && $where['user_region'] = "user_region=" . (int) $location['region'];
((int) $location['city'] > 0) && $where['user_city'] = "user_city=" . (int) $location['city'];
