<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.add.tags,market.edit.tags
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
if ((int) $id > 0) {
	$t->assign(array(
		"PRDEDIT_FORM_LOCATION" => cot_select_location($item['item_country'], $item['item_region'], $item['item_city'])
	)); 
} else {
	$t->assign(array(
		"PRDADD_FORM_LOCATION" => cot_select_location(
            !empty($ritem['item_country']) ? $ritem['item_country'] : '',
            !empty($ritem['item_region']) ? $ritem[',item_region'] : 0,
            !empty($ritem['item_city']) ? $ritem['item_city'] : 0,
            true
        )
	));
}

// ==============================================

