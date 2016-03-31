<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */
/**
 * Null billing Plugin
 *
 * @package nullbilling
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('nullbilling', 'plug');
require_once cot_incfile('payments', 'module');

$m = cot_import('m', 'G', 'ALP');
$pid = cot_import('pid', 'G', 'INT');

if (empty($m))
{
	// Получаем информацию о заказе
	if (!empty($pid) && $pinfo = cot_payments_payinfo($pid))
	{
		cot_block($usr['id'] == $pinfo['pay_userid']);
		cot_block($pinfo['pay_status'] == 'new' || $pinfo['pay_status'] == 'process');

		cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"
		
		if(cot_payments_updatestatus($pid, 'paid')) // Изменяем статус "Оплачено"
		{
			cot_redirect(cot_url('plug', 'e=nullbilling&m=success&pid='.$pid, '', true));
		}
		else
		{
			cot_redirect(cot_url('plug', 'e=nullbilling&m=fail&pid='.$pid, '', true));
		}
	}
	else
	{
		cot_die();
	}
}
elseif ($m == 'success')
{
	if (!empty($pid) && $pinfo = cot_payments_payinfo($pid))
	{
		if(!empty($pinfo['pay_code']) && $prinfo = cot_payments_payinfo($pinfo['pay_code'])){
			$redirect = $prinfo['pay_redirect'];
		}
	}
	
	$t->assign(array(
		"BILLING_TITLE" => $L['nullbilling_error_title'],
		"BILLING_ERROR" => $L['nullbilling_error_done']
	));
	
	if($redirect){
		$t->assign(array(
			"BILLING_REDIRECT_TEXT" => sprintf($L['nullbilling_redirect_text'], $redirect),
			"BILLING_REDIRECT_URL" => $redirect,
		));
	}
	
	$t->parse("MAIN.ERROR");
}
elseif ($m == 'fail')
{
	$t->assign(array(
		"BILLING_TITLE" => $L['nullbilling_error_title'],
		"BILLING_ERROR" => $L['nullbilling_error_fail']
	));
	$t->parse("MAIN.ERROR");
}
?>