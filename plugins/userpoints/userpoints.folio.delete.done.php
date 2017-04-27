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

global $db_userpoints, $db_users;

$db->delete($db_userpoints, "item_type IN ('portfolioaddtocat', 'portfoliodeltocat') AND item_itemid=".$id);

$uuserpoints = $db->query("SELECT SUM(item_point) as summ FROM $db_userpoints WHERE item_userid=" . (int)$ritem['item_userid'])->fetchColumn();
$db->update($db_users, array('user_userpoints' => $uuserpoints), "user_id=" . (int)$ritem['item_userid']);
