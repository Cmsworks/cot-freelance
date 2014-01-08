<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=users.edit.update.delete
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

$db->update($db_market, array('item_state' => -1), "item_userid='" . $urr['user_id'] . "'");
