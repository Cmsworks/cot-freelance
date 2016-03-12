<?php

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$r = cot_import('r', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');
cot_block($usr['auth_write']);

$item = $db->query("SELECT p.*, u.* FROM $db_projects AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE item_id=" . (int)$id)->fetch();
if ($item['item_id'] != (int)$id)
{
	cot_die_message(404, TRUE);
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', $item['item_cat']);
cot_block($usr['isadmin'] || $usr['auth_write'] && $usr['id'] == $item['item_userid']);

/* === Hook === */
foreach (cot_getextplugins('projects.preview.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'save')
{
	cot_check_xg();

	/* === Hook === */
	foreach (cot_getextplugins('projects.preview.save.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$prj = array();
	if($cfg['projects']['prevalidate'] && !$usr['isadmin']){
		$prj['item_state'] = 2;
		
		$r_url = (empty($ritem['item_alias'])) ? 
			cot_url('projects', 'c='.$ritem['item_cat'].'&id='.$id, '', true) : cot_url('projects', 'c='.$ritem['item_cat'].'&al='.$ritem['item_alias'], '', true);
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['project_senttovalidation_mail_body'], array( 
				'user_name' => $item['user_name'],
				'prj_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($item['user_email'], $L['project_senttovalidation_mail_subj'], $rbody);
		}

		if ($cfg['projects']['notif_admin_moderate'])
		{
			$nbody = cot_rc($L['project_notif_admin_moderate_mail_body'], array( 
				'user_name' => $usr['profile']['user_name'],
				'prj_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . $r_url
			));
			cot_mail($cfg['adminemail'], $L['project_notif_admin_moderate_mail_subj'], $nbody);
		}	
	}
	else{
		$prj['item_state'] = 0;
		
		$r_url = (empty($item['item_alias'])) ? 
			cot_url('projects', 'c='.$item['item_cat'].'&id='.$id, '', true) : cot_url('projects', 'c='.$item['item_cat'].'&al='.$item['item_alias'], '', true);	
		
		if (!$usr['isadmin'])
		{
			$rbody = cot_rc($L['project_added_mail_body'], array(
				'user_name' => $item['user_name'],
				'prj_name' => $item['item_title'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('projects', 'id=' . $id, '', true)
			));
			cot_mail($item['user_email'], $L['project_added_mail_subj'], $rbody);
		}
	}
	$db->update($db_projects, $prj, "item_id=" . (int)$id);

	cot_projects_sync($item['item_cat']);
	
	/* === Hook === */
	foreach (cot_getextplugins('projects.preview.save.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	cot_redirect($r_url);
	exit;
}

$out['subtitle'] = $L['projects'];

$mskin = cot_tplfile(array('projects', 'preview', $structure['projects'][$item['item_cat']]['tpl']));
/* === Hook === */
foreach (cot_getextplugins('projects.preview.main') as $pl)
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
	cot_url('projects', 'c='.$item['item_cat'].'&id='.$id) : cot_url('projects', 'c='.$item['item_cat'].'&al='.$item['item_alias']);

$t->assign(cot_generate_usertags($item, 'PRJ_OWNER_'));
$t->assign(cot_generate_projecttags($item, 'PRJ_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign(array(
	"PRJ_SHOW_URL" => $cfg['mainurl'] . '/' . $r_url,
	"PRJ_SAVE_URL" => cot_url('projects', 'm=preview&a=save&id=' . $item['item_id'] . '&' . cot_xg()),
	"PRJ_EDIT_URL" => cot_url('projects', 'm=edit&id=' . $item['item_id']),
));

/* === Hook === */
foreach (cot_getextplugins('projects.preview.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');
