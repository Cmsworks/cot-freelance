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
$location = cot_import_location('G');

if(!empty($location)){
	(!empty($location['country'])) && $where['user_country'] = "user_country='" . $location['country']."'";
	((int) $location['region'] > 0) && $where['user_region'] = "user_region=" . (int) $location['region'];
	((int) $location['city'] > 0) && $where['user_city'] = "user_city=" . (int) $location['city'];

	$users_url_path['country'] = $location['country'];
	$users_url_path['region'] = $location['region'];
	$users_url_path['city'] = $location['city'];
}