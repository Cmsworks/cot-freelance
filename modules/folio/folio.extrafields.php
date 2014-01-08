<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');
$extra_whitelist[$db_folio] = array(
	'name' => $db_folio,
	'caption' => $L['Module'].' folio',
	'type' => 'module',
	'code' => 'folio',
	'tags' => array(
		'folio.list.tpl' => '{PRD_ROW_XXXXX}, {PRD_ROW_XXXXX_TITLE}',
		'folio.tpl' => '{PRD_XXXXX}, {PRD_XXXXX_TITLE}',
		'folio.add.tpl' => '{PRDADD_FORM_XXXXX}, {PRDADD_FORM_XXXXX_TITLE}',
		'folio.edit.tpl' => '{PRDEDIT_FORM_XXXXX}, {PRDEDIT_FORM_XXXXX_TITLE}',
	)
);
