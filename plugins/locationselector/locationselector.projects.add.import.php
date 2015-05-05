<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.add.import,projects.edit.update.import
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

$location = cot_import_location();
$ritem['item_country'] = $location['country'];
$ritem['item_region'] = $location['region'];
$ritem['item_city'] = $location['city'];

