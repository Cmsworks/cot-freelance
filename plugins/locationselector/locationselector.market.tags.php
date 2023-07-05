<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.tags,market.admin.list.tags
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

$location['country'] = !empty($location['country']) ? $location['country'] : '';
$location['region'] = !empty($location['region']) ? $location['region'] : 0;
$location['city'] = !empty($location['city']) ? $location['city'] : 0;
$t->assign(array(
	"SEARCH_LOCATION" => cot_select_location($location['country'], $location['region'], $location['city']),
));


