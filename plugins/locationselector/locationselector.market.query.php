<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.query
 * Order=60
 * [END_COT_EXT]
 */

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

$location = cot_import_location('G');
$location['region'] = (int) $location['region'];
$location['city'] = (int) $location['city'];

$location_info = cot_getlocation($location['country'], $location['region'], $location['city']);
cot::$out['subtitle'] .= (!empty($location_info['country'])) ? ' - ' . $location_info['country'] : '';
cot::$out['subtitle'] .= (!empty($location_info['region'])) ? ' - ' . $location_info['region'] : '';
cot::$out['subtitle'] .= (!empty($location_info['city'])) ? ' - ' . $location_info['city'] : '';

if (!empty($location['country'])) {
    $where['location'] = "item_country=" . cot::$db->quote($location['country']);
}
if ($location['region'] > 0) {
    $where['location'] =  "item_region=" . $location['region'];
}
if ($location['city'] > 0) {
    $where['location'] = "item_city=" . $location['city'];
}


$list_url_path['country'] = $location['country'];
$list_url_path['region'] = $location['region'];
$list_url_path['city'] = $location['city'];