<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */
/**
 * Webmoney billing Plugin
 *
 * @package wmbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('wmbilling', 'plug');
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

		$rpay['pay_wmrnd'] = strtoupper(substr(md5(uniqid(microtime(), 1)) . getmypid(), 1, 8));
		$db->update($db_payments, $rpay, "pay_id=?", array($pid));

		$LMI_PAYMENT_AMOUNT = number_format($pinfo['pay_summ']*$cfg['plugin']['wmbilling']['webmoney_rate'], 2, '.', '');
		$LMI_PAYMENT_DESC_BASE64 = base64_encode($pinfo['pay_desc']);
		$LMI_PAYMENT_NO = $pid;
		$LMI_PAYEE_PURSE = $cfg['plugin']['wmbilling']['webmoney_purse'];
		$RND = $rpay['pay_wmrnd'];
		$LMI_SIM_MODE = '0';
		$LMI_HASH_METHOD = 'SIGN';

		$wm_form = "<form id=wmform name=pay method=\"POST\" action=\"https://merchant.webmoney.ru/lmi/payment.asp\">
			<input type=\"hidden\" name=\"LMI_PAYMENT_AMOUNT\" value=\"" . $LMI_PAYMENT_AMOUNT . "\">
			<input type=\"hidden\" name=\"LMI_PAYMENT_DESC_BASE64\" value=\"" . $LMI_PAYMENT_DESC_BASE64 . "\">
			<input type=\"hidden\" name=\"LMI_PAYMENT_NO\" value=\"" . $LMI_PAYMENT_NO . "\">
			<input type=\"hidden\" name=\"LMI_PAYEE_PURSE\" value=\"" . $LMI_PAYEE_PURSE . "\">
			<input type=\"hidden\" name=\"LMI_SIM_MODE\" value=\"" . $LMI_SIM_MODE . "\">
			<input type=\"hidden\" name=\"RND\" value=\"" . $RND . "\">
			<input type=\"submit\" class=\"btn btn-success btn-large\" value=\"" . $L['wmbilling_formbuy'] . "\" />
			</form>";

		$t->assign(array(
			'WEBMONEY_FORM' => $wm_form,
		));
		$t->parse("MAIN.WMFORM");

		cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"
	}
	else
	{
		cot_die();
	}
}
elseif ($m == 'success')
{
	$plugin_body = $L['wmbilling_error_incorrect'];

	if (isset($_GET['LMI_PAYMENT_NO']) && preg_match('/^\d+$/', $_GET['LMI_PAYMENT_NO']) == 1)
	{
		$pinfo = cot_payments_payinfo($_GET['LMI_PAYMENT_NO']);
		if ($pinfo['pay_status'] == 'done')
		{
			$plugin_body = $L['wmbilling_error_done'];
			$redirect = $pinfo['pay_redirect'];
		}
		elseif ($pinfo['pay_status'] == 'paid')
		{
			$plugin_body = $L['wmbilling_error_paid'];
		}
	}
	$t->assign(array(
		"WEBMONEY_TITLE" => $L['wmbilling_error_title'],
		"WEBMONEY_ERROR" => $plugin_body
	));
	
	if($redirect){
		$t->assign(array(
			"WEBMONEY_REDIRECT_TEXT" => sprintf($L['wmbilling_redirect_text'], $redirect),
			"WEBMONEY_REDIRECT_URL" => $redirect,
		));
	}
	
	$t->parse("MAIN.ERROR");
}
elseif ($m == 'fail')
{
	$t->assign(array(
		"WEBMONEY_TITLE" => $L['wmbilling_error_title'],
		"WEBMONEY_ERROR" => $L['wmbilling_error_fail']
	));
	$t->parse("MAIN.ERROR");
}
?>