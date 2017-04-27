<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.edit.delete.done
 * [END_COT_EXT]
 */
/**
 * UserPoints plugin
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

global $db_userpoints;

$db->delete($db_userpoints, "item_type IN ('portfolioaddtocat', 'portfoliodeltocat') AND item_itemid=".$id);
