<?php
/**
 * support
 *
 * @package support
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'support');

/* === Hook === */
foreach (cot_getextplugins('support.ticket.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0)
{
	$query_string = (!$usr['isadmin']) ? " AND ticket_userid=".$usr['id'] : "";
	$sql = $db->query("SELECT * FROM $db_support_tickets AS t
		LEFT JOIN $db_users AS u ON u.user_id=t.ticket_userid 
		WHERE ticket_id=" . $id . " " . $query_string . " LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_block();
}
$ticket = $sql->fetch();

$messages = $db->query("SELECT * FROM $db_support_messages AS m
LEFT JOIN $db_users AS u ON u.user_id=m.msg_userid
WHERE msg_tid=".$id." ORDER BY msg_date ASC")->fetchAll();

if($a == 'close')
{
	cot_check_xg();
	
	$db->update($db_support_tickets, array('ticket_status' => 'closed', 'ticket_close' => $sys['now']), 'ticket_id='.$id);
	
	cot_redirect(cot_url('support', 'id=' . $id, '', true));
}

if($a == 'addmsg')
{
	cot_shield_protect();
	
	$rmsg['msg_text'] = cot_import('rmsgtext', 'P', 'HTM');
	
	$rmsg['msg_tid'] = $id;
	$rmsg['msg_userid'] = $usr['id'];
	$rmsg['msg_date'] = $sys['now'];
	
	/* === Hook === */
	foreach (cot_getextplugins('support.ticket.addmsg.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	cot_check(empty($rmsg['msg_text']), $L['support_tickets_message_error_textempty'], 'rmsgtext');
	cot_check($ticket['ticket_status'] == 'closed' && !$usr['isadmin'], $L['support_tickets_message_error_closed'], 'rmsgtext');
	
	/* === Hook === */
	foreach (cot_getextplugins('support.ticket.addmsg.validate') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if(!cot_error_found())
	{
		
		$db->insert($db_support_messages, $rmsg);
		$mid = $db->lastInsertId();
		
		$rticket['ticket_update'] = $sys['now'];
		$rticket['ticket_count'] = $ticket['ticket_count'] + 1;
		
		$db->update($db_support_tickets, $rticket, 'ticket_id='.$id);
		
		if($usr['id'] == $ticket['ticket_userid'])
		{
			$supportemails = explode(',', $cfg['plugin']['support']['email']);
			foreach ($supportemails as $supportemail){
				$rsubject = sprintf($L['support_notify_newmsg_admin_title'], $id);
				$rbody = sprintf($L['support_notify_newmsg_admin_body'], $id, $cfg['mainurl'] . '/' . cot_url('support', 'id='.$id, '', true));
				cot_mail($supportemail, $rsubject, $rbody);
			}
		}
		else
		{
			$rsubject = sprintf($L['support_notify_newmsg_user_title'], $id);
			$rbody = sprintf($L['support_notify_newmsg_user_body'], $ticket['ticket_name'], $id, $cfg['mainurl'] . '/' . cot_url('support', 'id='.$id, '', true));
			cot_mail($ticket['ticket_email'], $rsubject, $rbody);
		}
		
		/* === Hook === */
		foreach (cot_getextplugins('support.ticket.addmsg.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	cot_redirect(cot_url('support', 'id=' . $id, '#msg'.$mid, true));
}

$out['subtitle'] = $support['support_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('support', 'ticket'), 'plug');

/* === Hook === */
foreach (cot_getextplugins('support.ticket.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$patharray[] = array(cot_url('support'), $L['support']);
$patharray[] = array(cot_url('support', 'id='.$id), $ticket['ticket_title']);

$t->assign(array(
	'SUPPORT_TITLE' => cot_breadcrumbs($patharray, $cfg['homebreadcrumb'], true),
));

$t->assign(cot_generate_usertags($ticket, 'TICKET_USER_'));

$t->assign(array(
	'TICKET_ID' => $ticket['ticket_id'],
	'TICKET_STATUS' => $ticket['ticket_status'],
	'TICKET_TITLE' => $ticket['ticket_title'],
	'TICKET_DATE' => $ticket['ticket_date'],
	'TICKET_CLOSE_URL' => cot_url('support', 'a=close&id='.$id.'&'.cot_xg(), '', true),
));

foreach ($messages as $msg)
{
	$t->assign(cot_generate_usertags($msg, 'MSG_ROW_USER_'));
	$t->assign(array(
		'MSG_ROW_ID' => $msg['msg_id'],
		'MSG_ROW_TEXT' => cot_parse($msg['msg_text'], $cfg['plugin']['support']['markup'], $cfg['plugin']['support']['parser']),
		'MSG_ROW_DATE' => $msg['msg_date'],
	));
	$lastposterid = $msg['user_id'];
	$t->parse("MAIN.MSG_ROW");
}

$sys['parser'] = $cfg['plugin']['support']['parser'];

$t->assign(array(
	'MSG_FORM_SEND' => cot_url('support', 'id='.$id.'&a=addmsg'),
	'MSG_FORM_TEXT' => cot_textarea('rmsgtext', $rmsg['msg_text'], 24, 120, '', 'input_textarea_editor'),
));	

if(cot_module_active('pfs'))
{
	require_once cot_incfile('pfs', 'module');

	$pfs_src = 'msgform';
	$pfs_name = 'rmsgtext';
	$pfs = cot_build_pfs($usr['id'], $pfs_src, $pfs_name, $L['Mypfs'], $sys['parser']);
	$pfs .= (cot_auth('pfs', 'a', 'A')) ? ' &nbsp; '.cot_build_pfs(0, $pfs_src, $pfs_name, $L['SFS'], $sys['parser']) : '';
	$t->assign('MSG_FORM_MYPFS', $pfs);
}

if($ticket['ticket_status'] == 'open')
{
	if($cfg['plugin']['support']['waitanswer'] && $lastposterid == $usr['id'] && !$usr['isadmin'])
	{
		/* === Hook === */
		foreach (cot_getextplugins('support.ticket.wait.tags') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		$t->parse("MAIN.MSGWAIT");
	}
	else
	{
		/* === Hook === */
		foreach (cot_getextplugins('support.ticket.msgform') as $pl)
		{
			include $pl;
		}
		/* ===== */

		// Error and message handling
		cot_display_messages($t);

		$t->parse("MAIN.MSGFORM");
	}
}
else
{
	/* === Hook === */
	foreach (cot_getextplugins('support.ticket.closed.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	$t->parse("MAIN.CLOSED");
}

/* === Hook === */
foreach (cot_getextplugins('support.ticket.tags') as $pl)
{
	include $pl;
}
/* ===== */
