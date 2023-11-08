<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('payorders', 'plug');

$t = new XTemplate(cot_tplfile('payorders.admin', 'plug', true));

$id = cot_import('id','G','INT');

if($a == 'add'){
	$username = cot_import('username','P','TXT', 100, TRUE);
	$desc = cot_import('desc','P','TXT');
	$summ = cot_import('summ','P','NUM');
	
	$urr = $db->query("SELECT * FROM $db_users WHERE user_name='".$username."'")->fetch();
	
	cot_check(empty($desc), 'payorders_error_desc');
	cot_check($summ <= 0, 'payorders_error_summ');
	cot_check(empty($urr), 'payorders_error_userempty');
	
	if(!cot_error_found()){
		
		$payinfo['pay_userid'] = $urr['user_id'];
		$payinfo['pay_desc'] = $desc;
		$payinfo['pay_area'] = 'payorders';
		$payinfo['pay_summ'] = $summ;
		$payinfo['pay_cdate'] = $sys['now'];
		$payinfo['pay_status'] = 'new';
		
		$db->insert($db_payments, $payinfo);
		$id = $db->lastInsertId();
		
		$subject = $L['payorders_email_neworderinfo_subject'];
		$body = sprintf($L['payorders_email_neworderinfo_body'], $urr['user_name'], $id, $desc, COT_ABSOLUTE_URL . cot_url('payorders', '', '', true));
		cot_mail($urr['user_email'], $subject, $body);
	}
	cot_redirect(cot_url('admin', 'm=other&p=payorders', '', true));
}

if($a == 'delete'){
	$db->delete($db_payments, "pay_id=?", array($id));
	cot_redirect(cot_url('admin', 'm=other&p=payorders', '', true));
}

$payorders = $db->query("SELECT * FROM $db_payments AS p 
	LEFT JOIN $db_users AS u ON u.user_id=p.pay_userid
	WHERE pay_area='payorders' ORDER BY pay_cdate DESC")->fetchAll();
foreach ($payorders as $ord){
	$t->assign(cot_generate_usertags($ord, 'ORD_ROW_USER_'));
	$t->assign(array(
		'ORD_ROW_ID' => $ord['pay_id'],
		'ORD_ROW_DESC' => $ord['pay_desc'],
		'ORD_ROW_CDATE' => $ord['pay_cdate'],
		'ORD_ROW_PDATE' => $ord['pay_pdate'],
		'ORD_ROW_SUMM' => $ord['pay_summ'],
		'ORD_ROW_STATUS' => $ord['pay_status'],
	));
	$t->parse('MAIN.ORD_ROW');
}

cot_display_messages($t);


$t->assign(array(
	'ORD_FORM_ACTION_URL' => cot_url('admin', 'm=other&p=payorders&a=add'),
	'ORD_FORM_SUMM' => cot_inputbox('text', 'summ', $summ),
	'ORD_FORM_DESC' => cot_inputbox('text', 'desc', $desc),
));

$t->parse('MAIN');
$adminmain = $t->text('MAIN');