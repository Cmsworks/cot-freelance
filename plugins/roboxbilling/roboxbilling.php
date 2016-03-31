<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */
/**
 * Robox billing Plugin
 *
 * @package roboxbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('roboxbilling', 'plug');
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

		$url = 'https://merchant.roboxchange.com/Index.aspx';

		$mrh_login = $cfg['plugin']['roboxbilling']['mrh_login'];
		$mrh_pass1 = $cfg['plugin']['roboxbilling']['mrh_pass1'];
		$inv_id = $pid;
		$shp_item = (!empty($pinfo['pay_code'])) ? $pinfo['pay_area'].'_'.$pinfo['pay_code'] : $pinfo['pay_area'];
		$inv_desc = $pinfo['pay_desc'];
		$in_curr = '';
		$culture = "ru";
		$out_summ = number_format($pinfo['pay_summ']*$cfg['plugin']['roboxbilling']['rate'], 2, '.', '');

		if($cfg['plugin']['roboxbilling']['testmode'])
		{
			$test_string = "&IsTest=1";
		}

		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");

		$post_opt = "MrchLogin=" . $mrh_login . "&OutSum=" . $out_summ . "&InvId=" . $inv_id . "&Desc=" . $inv_desc . "&SignatureValue=" . $crc . "&Shp_item=" . $shp_item . "&IncCurrLabel=" . $in_curr . "&Culture=" . $culture . $test_string;

		cot_payments_updatestatus($pid, 'process'); // Изменяем статус "в процессе оплаты"

		header('Location: ' . $url . '?' . $post_opt);
		exit;
	}
	else
	{
		cot_die();
	}
}
elseif ($m == 'success')
{
	// регистрационная информация (пароль #1)
	// registration info (password #1)
	$mrh_pass1 = $cfg['plugin']['roboxbilling']['mrh_pass1'];

	// чтение параметров
	// read parameters
	$out_summ = $_REQUEST["OutSum"];
	$inv_id = $_REQUEST["InvId"];
	$shp_item = $_REQUEST["Shp_item"];
	$crc = $_REQUEST["SignatureValue"];

	$crc = strtoupper($crc);

	$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item"));

	$plugin_body = $L['roboxbilling_error_otkaz'];

	// проверка корректности подписи
	if ($my_crc != $crc)
	{
		$plugin_body = $L['roboxbilling_error_incorrect'];
	}
	else
	{
		if(!empty($inv_id))
		{
			// проверка наличия номера платежки и ее статуса
			$pinfo = cot_payments_payinfo($inv_id);
			if ($pinfo['pay_status'] == 'done')
			{
				$plugin_body = $L['roboxbilling_error_done'];
				$redirect = $pinfo['pay_redirect'];
			}
			elseif ($pinfo['pay_status'] == 'paid')
			{
				$plugin_body = $L['roboxbilling_error_paid'];
			}
		}
	}

	$t->assign(array(
		"ROBOX_TITLE" => $L['roboxbilling_error_title'],
		"ROBOX_ERROR" => $plugin_body
	));
	
	if($redirect){
		$t->assign(array(
			"ROBOX_REDIRECT_TEXT" => sprintf($L['roboxbilling_redirect_text'], $redirect),
			"ROBOX_REDIRECT_URL" => $redirect,
		));
	}
	$t->parse("MAIN.ERROR");
}
elseif ($m == 'fail')
{
	$t->assign(array(
		"ROBOX_TITLE" => $L['roboxbilling_error_title'],
		"ROBOX_ERROR" => $L['roboxbilling_error_fail']
	));
	$t->parse("MAIN.ERROR");
}
?>