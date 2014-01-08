<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
 * [END_COT_EXT]
 */
/**
 * Reviews plugin
 *
 * @package reviews
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

$tab = cot_import('tab', 'G', 'ALP');

$t->assign('REVIEWS', cot_reviews_list($urr['user_id'], 'users', '', 'users', "m=details&id=" . $urr['user_id'] . "&u=" . $urr['user_name'] . "&tab=reviews", '', $cfg['plugin']['reviews']['userall']));

if (!$cfg['plugin']['reviews']['userall'])
{
	$sqlarea = " AND item_area='users'";
}
$user_reviews_count = $db->query("SELECT COUNT(*) FROM $db_reviews WHERE item_touserid=" . (int)$urr['user_id'] . " $sqlarea")->fetchColumn();

$t->assign(array(
	'USERS_DETAILS_REVIEWS_COUNT' => $user_reviews_count,
	"USERS_DETAILS_REVIEWS_URL" => cot_url('users', 'm=details&id=' . $urr['user_id'] . '&u=' . $urr['user_name'] . '&tab=reviews'),
));

?>