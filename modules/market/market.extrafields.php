<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');
$extra_whitelist[$db_market] = array(
	'name' => $db_market,
	'caption' => $L['Module'].' market',
	'type' => 'module',
	'code' => 'market',
	'tags' => array(
		'market.list.tpl' => '{PRD_ROW_XXXXX}, {PRD_ROW_XXXXX_TITLE}',
		'market.tpl' => '{PRD_XXXXX}, {PRD_XXXXX_TITLE}',
		'market.add.tpl' => '{PRDADD_FORM_XXXXX}, {PRDADD_FORM_XXXXX_TITLE}',
		'market.edit.tpl' => '{PRDEDIT_FORM_XXXXX}, {PRDEDIT_FORM_XXXXX_TITLE}',
	)
);
