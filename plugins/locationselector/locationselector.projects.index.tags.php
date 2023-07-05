<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.index.searchtags
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

// ==============================================
$t_pr->assign(array(
	"SEARCH_LOCATION" => cot_select_location(
        !empty($location['country']) ? $location['country'] : '',
        !empty($location['region']) ? $location['region'] : 0,
        !empty($location['city']) ? $location['city'] : 0
    ),
));

// ==============================================

