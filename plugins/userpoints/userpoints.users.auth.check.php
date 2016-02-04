<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
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

require_once cot_incfile('userpoints', 'plug');

$lastlog = $db->query("SELECT item_date FROM $db_userpoints 
	WHERE item_userid=" . $ruserid . " AND item_type='auth' ORDER by item_date DESC LIMIT 1")->fetchColumn();
if ($lastlog + 86400 < $sys['now'])
{
	cot_setuserpoints($cfg['plugin']['userpoints']['auth'], 'auth', $ruserid);
	$db->update($db_users, array('user_userpointsauth' => $sys['now']), "user_id=".$ruserid);
}