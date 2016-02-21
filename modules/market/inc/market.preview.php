<?php

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

$id = cot_import('id', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', 'any', 'RWA');

cot_block($usr['auth_write']);

$item = $db->query("SELECT m.*, u.* FROM $db_market AS m LEFT JOIN $db_users AS u ON u.user_id=m.item_userid WHERE item_id=" . (int)$id)->fetch();
if ($item['item_id'] != (int)$id)
{
	cot_die_message(404, TRUE);
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', $item['item_cat']);
cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $item['item_userid']);

/* === Hook === */
foreach (cot_getextplugins('market.preview.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'save')
{
	cot_check_xg();

	/* === Hook === */
	foreach (cot_getextplugins('market.preview.save.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$ritem = array();
	if($cfg['market']['prevalidate'] && !$usr['isadmin']){
		$ritem['item_state'] = 2;
		
		$r_url = (empty($ritem['item_alias'])) ? 
			cot_url('market', 'c='.$ritem['item_cat'].'&id='.$id, '', true) : cot_url('market', 'c='.$ritem['item_cat'].'&al='.$ritem['item_alias'], '', true);
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['market_senttovalidation_mail_body'], array( 
				'user_name' => $item['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($item['user_email'], $L['market_senttovalidation_mail_subj'], $rbody);
		}

		if ($cfg['market']['notifmarket_admin_moderate'])
		{
			$nbody = cot_rc($L['market_notif_admin_moderate_mail_body'], array( 
				'user_name' => $usr['profile']['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($cfg['adminemail'], $L['market_notif_admin_moderate_mail_subj'], $nbody);
		}
	}
	else{
		$ritem['item_state'] = 0;
		
		$r_url = (empty($item['item_alias'])) ? 
			cot_url('market', 'c='.$item['item_cat'].'&id='.$id, '', true) : cot_url('market', 'c='.$item['item_cat'].'&al='.$item['item_alias'], '', true);	
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['market_added_mail_body'], array(
				'user_name' => $item['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('market', 'id=' . $id, '', true)
			));
			cot_mail($item['user_email'], $L['market_added_mail_subj'], $rbody);
		}
	}
	$db->update($db_market, $ritem, "item_id=" . (int)$id);

	cot_market_sync($item['item_cat']);
	
	/* === Hook === */
	foreach (cot_getextplugins('market.preview.save.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	cot_redirect($r_url);
	exit;
}

$out['subtitle'] = $L['market'];

$mskin = cot_tplfile(array('market', 'preview', $structure['market'][$item['item_cat']]['tpl']));
/* === Hook === */
foreach (cot_getextplugins('market.step2.main') as $pl)
{
	include $pl;
}
/* ===== */
$t = new XTemplate($mskin);

if ($item['item_state'] != 0 && !$usr['isadmin'] && $usr['id'] != $item['item_userid'])
{
	cot_log("Attempt to directly access an un-validated", 'sec');
	cot_redirect(cot_url('message', "msg=930", '', true));
	exit;
}

$r_url = (empty($item['item_alias'])) ? 
	cot_url('market', 'c='.$item['item_cat'].'&id='.$id) : cot_url('market', 'c='.$item['item_cat'].'&al='.$item['item_alias']);

$t->assign(cot_generate_usertags($item, 'PRD_OWNER_'));
$t->assign(cot_generate_markettags($item, 'PRD_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign(array(
	"PRD_SHOW_URL" => $cfg['mainurl'] . '/' . $r_url,
	"PRD_SAVE_URL" => cot_url('market', 'm=preview&a=save&id=' . $item['item_id'] . '&' . cot_xg()),
	"PRD_EDIT_URL" => cot_url('market', 'm=edit&id=' . $item['item_id']),
));

/* === Hook === */
foreach (cot_getextplugins('market.preview.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');
