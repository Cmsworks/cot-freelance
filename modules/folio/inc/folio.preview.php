<?php

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

$id = cot_import('id', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', 'any', 'RWA');

cot_block($usr['auth_write']);

$item = $db->query("SELECT f.*, u.* FROM $db_folio AS f LEFT JOIN $db_users AS u ON u.user_id=f.item_userid WHERE item_id=" . (int)$id)->fetch();
if ($item['item_id'] != (int)$id)
{
	cot_die_message(404, TRUE);
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', $item['item_cat']);
cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $item['item_userid']);

/* === Hook === */
foreach (cot_getextplugins('folio.preview.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'save')
{
	cot_check_xg();

	$ritem = array();
	if($cfg['folio']['prevalidate'] && !$usr['isadmin']){
		$ritem['item_state'] = 2;
		
		$r_url = (empty($item['item_alias'])) ? 
			cot_url('folio', 'c='.$item['item_cat'].'&id='.$id, '', true) : cot_url('folio', 'c='.$item['item_cat'].'&al='.$item['item_alias'], '', true);
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['folio_senttovalidation_mail_body'], array( 
				'user_name' => $item['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($item['user_email'], $L['folio_senttovalidation_mail_subj'], $rbody);
		}

		if ($cfg['folio']['notiffolio_admin_moderate'])
		{
			$nbody = cot_rc($L['folio_notif_admin_moderate_mail_body'], array( 
				'user_name' => $usr['profile']['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($cfg['adminemail'], $L['folio_notif_admin_moderate_mail_subj'], $nbody);
		}	
	}
	else{
		$ritem['item_state'] = 0;
		
		$r_url = (empty($item['item_alias'])) ? 
			cot_url('folio', 'c='.$item['item_cat'].'&id='.$id, '', true) : cot_url('folio', 'c='.$item['item_cat'].'&al='.$item['item_alias'], '', true);	
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['folio_added_mail_body'], array(
				'user_name' => $item['user_name'],
				'prd_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('folio', 'id=' . $id, '', true)
			));
			cot_mail($item['user_email'], $L['folio_added_mail_subj'], $rbody);
		}
	}
	$db->update($db_folio, $ritem, "item_id=" . (int)$id);

	cot_folio_sync($item['item_cat']);
	
	/* === Hook === */
	foreach (cot_getextplugins('folio.preview.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	cot_redirect($r_url);
	exit;
}

$out['subtitle'] = $L['folio'];

$mskin = cot_tplfile(array('folio', 'preview', $structure['folio'][$item['item_cat']]['tpl']));
/* === Hook === */
foreach (cot_getextplugins('folio.preview.main') as $pl)
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
	cot_url('folio', 'c='.$item['item_cat'].'&id='.$id) : cot_url('folio', 'c='.$item['item_cat'].'&al='.$item['item_alias']);

$t->assign(cot_generate_usertags($item, 'PRD_OWNER_'));
$t->assign(cot_generate_foliotags($item, 'PRD_', $cfg['folio']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign(array(
	"PRD_SHOW_URL" => $cfg['mainurl'] . '/' . $r_url,
	"PRD_SAVE_URL" => cot_url('folio', 'm=preview&a=save&id=' . $item['item_id'] . '&' . cot_xg()),
	"PRD_EDIT_URL" => cot_url('folio', 'm=edit&id=' . $item['item_id']),
));

/* === Hook === */
foreach (cot_getextplugins('folio.preview.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');
