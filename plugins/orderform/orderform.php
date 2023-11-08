<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_langfile('orderform', 'plug');

$area = cot_import('area', 'G', 'ALP');
$code = cot_import('code', 'G', 'ALP');

switch ($area){
	case 'market':
		require_once cot_langfile('market', 'module');
		$item = $db->query("SELECT item_title as title, item_id as id, u.* FROM $db_market AS m
			LEFT JOIN $db_users AS u ON u.user_id=m.item_userid
			WHERE item_id=".$code)->fetch();
	break;
	case 'products':
		require_once cot_langfile('products', 'module');
		$item = $db->query("SELECT prd_title as title, prd_id as id, u.* FROM $db_products AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.prd_ownerid
			WHERE prd_id=".$code)->fetch();
	break;
}

cot_block($item);

if($a == 'send'){
	$remail = cot_import('remail','P', 'TXT', 64, TRUE);
	$rname = cot_import('rname', 'P', 'TXT');
	$rphone = cot_import('rphone', 'P', 'TXT');
	$rquantity = cot_import('rquantity', 'P', 'INT');
	$rcomment = cot_import('rcomment', 'P', 'TXT');
	
	cot_check($usr['id'] == 0 && !cot_check_email($remail), 'orderform_error_email', 'remail');
	cot_check(empty($rname), 'orderform_error_name', 'rname');
	cot_check(empty($rphone), 'orderform_error_phone', 'rphone');
	cot_check(empty($rquantity), 'orderform_error_quantity', 'rquantity');
//	cot_check(empty($rcomment), 'orderform_error_comment', 'rcomment');
	
	if(!cot_error_found()){
		
		$remail = ($usr['id']) ? $usr['profile']['user_email'] : $remail;
		
		$headers = ("From: \"" . $rname . "\" <" . $remail . ">\n");
		$context = array(
			'sitetitle' => $cfg["maintitle"],
			'siteurl' => $cfg['mainurl'],
			'name' => $rname,
			'email' => $remail,
			'phone' => $rphone,
			'product_title' => $item['title'],
			'product_url' => $cfg['mainurl'].'/'.cot_url($area, 'id='.$item['id'], '', true),
			'quantity' => $rquantity,
			'comment' => $rcomment
		);
		
		// Отправка продавцу
		$rsubject = $L['orderform_subject_seller'];
		$rbody = cot_rc($L['orderform_body_seller'], $context);
		cot_mail($item['user_email'], $rsubject, $rbody, $headers);
		
		// Отправка покупателю
		$rsubject = $L['orderform_subject_customer'];
		$rbody = cot_rc($L['orderform_body_customer'], $context);
		cot_mail($remail, $rsubject, $rbody);
		
		// Отправка админу
		$rsubject = $L['orderform_subject_admin'];
		$rbody = cot_rc($L['orderform_body_admin'], $context);
		cot_mail($cfg['adminemail'], $rsubject, $rbody);
		
		cot_message('orderform_sent');
	}
	
	cot_redirect(cot_url('orderform', 'area='.$area.'&code='.$code, '', true));
}

$t = new XTemplate(cot_tplfile(array('orderform', $area), 'plug'));
	
$t->assign(array(
	'ORDERFORM_ACTION' => cot_url('orderform', 'area='.$area.'&code='.$code.'&a=send'),
	'ORDERFORM_FORM_EMAIL' => cot_inputbox('text', 'remail', $remail, 'size="56" class="form-control"'),
	'ORDERFORM_FORM_NAME' => cot_inputbox('text', 'rname', $rname, 'size="56" class="form-control"'),
	'ORDERFORM_FORM_PHONE' => cot_inputbox('text', 'rphone', $rphone, 'size="56" class="form-control"'),
	'ORDERFORM_FORM_QUANTITY' => cot_inputbox('text', 'rquantity', $rquantity, 'size="56" class="form-control"'),
	'ORDERFORM_FORM_COMMENT' => cot_textarea('rcomment', $rcomment, 10, 60, 'id="formtext"', '', 'class="form-control"'),
));

switch ($area){
	case 'market':
		$t->assign(cot_generate_markettags($item['id'], 'PRD_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
	break;
	case 'products':
		$t->assign(cot_generate_prdtags($item['id'], 'PRD_', 0, $usr['isadmin'], $cfg['homebreadcrumb']));
	break;
}

cot_display_messages($t);