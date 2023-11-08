<?php

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'support');

/* === Hook === */
foreach (cot_getextplugins('support.newticket.first') as $pl)
{
	include $pl;
}
/* ===== */

cot_block($usr['auth_write']);

$tickets_open = $db->query("SELECT COUNT(*) FROM $db_support_tickets WHERE ticket_userid=".$usr['id']." AND ticket_status='open'")->fetchColumn();
cot_block($tickets_open == 0 || !$cfg['plugin']['support']['onlyoneticket']);

$sys['parser'] = $cfg['plugin']['support']['parser'];
		
if ($a == 'add')
{
	cot_shield_protect();

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'support', 'RWA');
	cot_block($usr['auth_write']);
	
	/* === Hook === */
	foreach (cot_getextplugins('support.newticket.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$rticket['ticket_title'] = cot_import('rtickettitle', 'P', 'TXT');
	$rticket['ticket_name'] = cot_import('rticketname', 'P', 'TXT', 100, TRUE);
	$rticket['ticket_email'] = cot_import('rticketemail', 'P', 'TXT', 64, TRUE);
	
	if(empty($rticket['ticket_name'])){
		$rticket['ticket_name'] = $usr['profile']['user_name'];
	}
	
	if(empty($rticket['ticket_email'])){
		$rticket['ticket_email'] = $usr['profile']['user_email'];
	}
	
	$rticket['ticket_status'] = 'open';
	$rticket['ticket_date'] = $sys['now'];
	$rticket['ticket_update'] = $sys['now'];

	$rmsg['msg_text'] = cot_import('rmsgtext', 'P', 'HTM');
	
	$rmsg['msg_date'] = $sys['now'];
			
	/* === Hook === */
	foreach (cot_getextplugins('support.newticket.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	cot_check(empty($rticket['ticket_title']), $L['support_error_rtickettitle'], 'rtickettitle');
	cot_check(strlen($rticket['ticket_title']) > 50, $L['support_error_rtickettitlelong'], 'rtickettitle');
	cot_check(empty($rmsg['msg_text']), $L['support_error_rmsgtext'], 'rmsgtext');
	
	if($usr['id'] == 0){
		cot_check(empty($rticket['ticket_name']), $L['support_error_rticketname'], 'rticketname');
		cot_check(!cot_check_email($rticket['ticket_email']), $L['support_error_rticketemail'], 'rticketemail');
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('support.newticket.add.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!cot_error_found())
	{
		if($usr['id'] == 0){
			$userid = $db->query("SELECT user_id FROM $db_users WHERE user_email = ? LIMIT 1", array($rticket['ticket_email']))->fetchColumn();
		}else{
			$userid = $usr['id'];
		}
		
		$rticket['ticket_userid'] = $userid;
		$rmsg['msg_userid'] = $userid;
		
		$db->insert($db_support_tickets, $rticket);
		$tid = $db->lastInsertId();
		
		$rmsg['msg_tid'] = $tid;

		$db->insert($db_support_messages, $rmsg);
		$mid = $db->lastInsertId();
		
		/* === Hook === */
		foreach (cot_getextplugins('support.newticket.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$supportemails = explode(',', $cfg['plugin']['support']['email']);
		foreach ($supportemails as $supportemail){
			$rsubject = sprintf($L['support_notify_newticket_title'], $tid);
			$rbody = sprintf($L['support_notify_newticket_body'], htmlspecialchars($usr['name']), $cfg['mainurl'] . '/' . cot_url('support', 'id='.$tid, '', true));
			cot_mail($supportemail, $rsubject, $rbody);
		}

		cot_redirect(cot_url('support', 'id=' . $tid, '', true));
	}

	cot_redirect(cot_url('support', 'm=newticket', '', true));
}

$out['subtitle'] = $L['support_addtitle'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('support', 'newticket'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('support.newticket.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$patharray[] = array(cot_url('support'), $L['support']);
$patharray[] = array(cot_url('support', 'm=add'), $L['support_addtitle']);

$t->assign(array(
	'TICKETADD_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
	'TICKETADD_SUBTITLE' => $L['support_addtitle'],
	'TICKETADD_FORM_SEND' => cot_url('support', 'm=newticket&a=add'),
	'TICKETADD_FORM_OWNER' => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	'TICKETADD_FORM_OWNERID' => $usr['id'],
	'TICKETADD_FORM_TITLE' => cot_inputbox('text', 'rtickettitle', $rticket['ticket_title'], 'class="form-control" maxlength="50" placeholder="'.$L['support_newticket_title'].'"'),
	'TICKETADD_FORM_TEXT' => cot_textarea('rmsgtext', $rmsg['msg_text'], 24, 120, '', 'input_textarea_editor'),
	'TICKETADD_FORM_NAME' => cot_inputbox('text', 'rticketname', $rticket['ticket_name'], 'class="form-control" maxlength="50" placeholder="'.$L['support_newticket_name'].'"'),
	'TICKETADD_FORM_EMAIL' => cot_inputbox('text', 'rticketemail', $rticket['ticket_email'], 'class="form-control" maxlength="50" placeholder="'.$L['support_newticket_email'].'"'),
));	

if(cot_module_active('pfs'))
{
	require_once cot_incfile('pfs', 'module');

	$pfs_src = 'ticketform';
	$pfs_name = 'rmsgtext';
	$pfs = cot_build_pfs($usr['id'], $pfs_src, $pfs_name, $L['Mypfs'], $sys['parser']);
	$pfs .= (cot_auth('pfs', 'a', 'A')) ? ' &nbsp; '.cot_build_pfs(0, $pfs_src, $pfs_name, $L['SFS'], $sys['parser']) : '';
	$t->assign('TICKETADD_FORM_MYPFS', $pfs);
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('support.newticket.tags') as $pl)
{
	include $pl;
}
/* ===== */
