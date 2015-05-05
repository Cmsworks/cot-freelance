<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.query
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

$location = cot_import_location('G');

$location_info = cot_getlocation($location['country'], $location['region'], $location['city']);
$out['subtitle'] .= (!empty($location_info['country'])) ? ' - ' . $location_info['country'] : '';
$out['subtitle'] .= (!empty($location_info['region'])) ? ' - ' . $location_info['region'] : '';
$out['subtitle'] .= (!empty($location_info['city'])) ? ' - ' . $location_info['city'] : '';

if(!empty($location['country'])) $where['location'] = "item_country='" . $db->prep($location['country'])."'";
if((int)$location['region'] > 0) $where['location'] =  "item_region=" . (int)$location['region'];
if((int)$location['city'] > 0) $where['location'] = "item_city=" . (int)$location['city'];


$list_url_path['country'] = $location['country'];
$list_url_path['region'] = $location['region'];
$list_url_path['city'] = $location['city'];