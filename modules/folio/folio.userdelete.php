<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=users.edit.update.delete
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

$folioworks = $db->query("SELECT * FROM $db_folio WHERE item_userid=".$urr['user_id'])->fetchAll();
foreach ($folioworks as $item)
{
	cot_folio_delete($item['item_id'], $item);
}
