<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
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
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'reviews', 'RWA');

$touser = cot_import('touser', 'G', 'INT');
$itemid = cot_import('itemid', 'G', 'INT');
$area = cot_import('area', 'G', 'TXT');
$code = cot_import('code', 'G', 'TXT');
$redirect = cot_import('redirect', 'G', 'TXT');
$area = empty($area) ? 'users' : $area;

if($cfg['pligin']['reviews']['checkprojects'] && cot_module_active('projects') && $usr['id'] > 0 && $usr['auth_write'] && $usr['id'] != $userid)
{
	require_once cot_incfile('projects', 'module');
	global $db_projects_offers, $db_projects;
	$bothprj = $db->query("SELECT COUNT(*) FROM  $db_projects_offers AS o
		LEFT JOIN $db_projects AS p ON p.item_id=o.item_pid
		WHERE p.item_userid = '".$touser."' AND o.item_userid='".$usr['id']."' AND o.item_choise='performer'")->fetchColumn();
	$usr['auth_write'] = ((int)$bothprj == 0) ? false : $usr['auth_write'];
}

cot_block($usr['auth_write']);

if ($a == 'add')
{
	cot_shield_protect();
	
	
//	cot_print('step');
	$uinfo = $db->query("SELECT * FROM $db_users WHERE user_id='".$touser."'")->fetch();
	
	cot_block(!empty($uinfo['user_name']));

	$item = $db->query("SELECT * FROM $db_reviews WHERE item_touserid='$touser' AND item_area = '".$db->prep($area)."' AND item_code = '".$db->prep($code)."' AND item_userid=" . $usr['id'] . " LIMIT 1")->fetch();
	cot_block(empty($item));	
	
	$ritem['item_touserid'] = $touser;
	$ritem['item_text'] = cot_import('rtext', 'P', 'TXT');
	$ritem['item_score'] = cot_import('rscore', 'P', 'INT');
	$ritem['item_userid'] = (int)$usr['id']; 
	$ritem['item_date'] = (int)$sys['now']; 
	
	$ritem['item_area'] = $area;
	$ritem['item_code'] = (!empty($code)) ? $code : cot_import('code', 'P', 'TXT');
	$ritem['item_code'] = $db->prep($ritem['item_code']);
	
	cot_check(empty($ritem['item_text']), 'review_empty_text');
	cot_check(empty($ritem['item_score']), 'review_empty_score');

	if (!cot_error_found()  && $ritem['item_touserid'] != $urr['user_id'])
	{
		$db->insert($db_reviews, $ritem);
		$itemid = $db->lastInsertId();

		/* === Hook === */
		foreach (cot_getextplugins('reviews.add.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

}
elseif ($a == 'update')
{

	$sql = $db->query("SELECT * FROM $db_reviews as r LEFT JOIN $db_users as u ON u.user_id=r.item_touserid WHERE item_id='$itemid' LIMIT 1");
	cot_die($sql->rowCount() == 0);
	$item = $sql->fetch();

	cot_block($usr['isadmin'] || $usr['id'] == $item['item_userid']);


	$delete = cot_import('rdelete', 'P', 'BOL');

	$ritem['item_text'] = cot_import('rtext', 'P', 'TXT');
	$ritem['item_score'] = (int) cot_import('rscore', 'P', 'INT');

	cot_check(empty($ritem['item_text']), 'review_empty_text');
	cot_check(empty($ritem['item_score']), 'review_empty_score');

	if (!cot_error_found())
	{
		$db->update($db_reviews, $ritem, "item_id='" . (int) $itemid . "'");

		/* === Hook === */
		foreach (cot_getextplugins('reviews.edit.update.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
}
elseif ($a == 'delete')
{

	$sql = $db->query("SELECT * FROM $db_reviews as r
		LEFT JOIN $db_users as u ON u.user_id=r.item_touserid WHERE item_id='$itemid' LIMIT 1");
	cot_die($sql->rowCount() == 0);
	$item = $sql->fetch();

	cot_block($usr['id'] == $item['item_userid'] || $usr['isadmin']);

	$db->delete($db_reviews, "item_id='$itemid'");

	/* === Hook === */
	foreach (cot_getextplugins('reviews.edit.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

$redirect = (empty($redirect)) ? base64_decode($sys['uri_redir']) : base64_decode($redirect);
cot_redirect($redirect);
exit;

?>