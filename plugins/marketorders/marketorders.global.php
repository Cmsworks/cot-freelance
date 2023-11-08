<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('marketorders', 'plug');
require_once cot_incfile('market', 'module');
require_once cot_incfile('payments', 'module');

// Проверяем платежки на оплату в маркете
if ($marketpays = cot_payments_getallpays('marketorders', 'paid'))
{
	foreach ($marketpays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$db->update($db_market_orders,  array('order_paid' => (int)$sys['now'], 'order_status' => 'paid'), "order_id=".(int)$pay['pay_code']);

			$marketorder = $db->query("SELECT * FROM $db_market_orders AS o
				LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
				WHERE order_id=".$pay['pay_code'])->fetch();

			$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_seller'])->fetch();
			if($marketorder['order_userid'] > 0)
			{
				$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_userid'])->fetch();
			}
			else
			{
				$customer['user_name'] = $marketorder['order_email'];
				$customer['user_email'] = $marketorder['order_email'];
			}

			$summ = $marketorder['order_cost'] - $marketorder['order_cost']*$cfg['plugin']['marketorders']['tax']/100;

			// Уведопляем продавца о совершении покупки его товара
			$rsubject = cot_rc($L['marketorders_paid_mail_toseller_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
			$rbody = cot_rc($L['marketorders_paid_mail_toseller_body'], array(
				'user_name' => $customer['user_name'],
				'product_id' => $marketorder['item_id'],
				'product_title' => $marketorder['item_title'],
				'order_id' => $marketorder['order_id'],
				'summ' => $summ.' '.$cfg['payments']['valuta'],
				'tax' => $cfg['plugin']['marketorders']['tax'],
				'warranty' => $cfg['plugin']['marketorders']['warranty'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
			));
			cot_mail ($seller['user_email'], $rsubject, $rbody);

			// Уведопляем покупателя о совершении покупки
			if(!empty($marketorder['order_email']))
			{
				$key = sha1($marketorder['order_email'].'&'.$marketorder['order_id']);
			}

			$rsubject = cot_rc($L['marketorders_paid_mail_tocustomer_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
			$rbody = cot_rc($L['marketorders_paid_mail_tocustomer_body'], array(
				'user_name' => $customer['user_name'],
				'product_id' => $marketorder['item_id'],
				'product_title' => $marketorder['item_title'],
				'order_id' => $marketorder['order_id'],
				'cost' => $marketorder['order_cost'].' '.$cfg['payments']['valuta'],
				'tax' => $cfg['plugin']['marketorders']['tax'],
				'warranty' => $cfg['plugin']['marketorders']['warranty'],
				'sitename' => $cfg['maintitle'],
				'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'] . '&key=' . $key, '', true)
			));
			cot_mail ($customer['user_email'], $rsubject, $rbody);

			/* === Hook === */
			foreach (cot_getextplugins('marketorders.order.paid') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

if($cfg['plugin']['marketorders']['acceptzerocostorders']) {
	// Проверяем заказы с ценой 0 в маркете
	$marketorders = $db->query("SELECT * FROM $db_market_orders AS o
		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
		WHERE order_status='new' AND order_cost<=0")->fetchAll();
	foreach ($marketorders as $marketorder)
	{
		$db->update($db_market_orders,  array('order_paid' => (int)$sys['now'], 'order_status' => 'paid'), "order_id=".(int)$marketorder['order_id']);

		$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_seller'])->fetch();
		if($marketorder['order_userid'] > 0)
		{
			$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_userid'])->fetch();
		}
		else
		{
			$customer['user_name'] = $marketorder['order_email'];
			$customer['user_email'] = $marketorder['order_email'];
		}

		$summ = 0;

		// Уведопляем продавца о совершении покупки его товара
		$rsubject = cot_rc($L['marketorders_paid_mail_toseller_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
		$rbody = cot_rc($L['marketorders_paid_mail_toseller_body'], array(
			'user_name' => $customer['user_name'],
			'product_id' => $marketorder['item_id'],
			'product_title' => $marketorder['item_title'],
			'order_id' => $marketorder['order_id'],
			'summ' => $summ.' '.$cfg['payments']['valuta'],
			'tax' => $cfg['plugin']['marketorders']['tax'],
			'warranty' => $cfg['plugin']['marketorders']['warranty'],
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
		));
		cot_mail ($seller['user_email'], $rsubject, $rbody);

		// Уведопляем покупателя о совершении покупки
		if(!empty($marketorder['order_email']))
		{
			$key = sha1($marketorder['order_email'].'&'.$marketorder['order_id']);
		}

		$rsubject = cot_rc($L['marketorders_paid_mail_tocustomer_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
		$rbody = cot_rc($L['marketorders_paid_mail_tocustomer_body'], array(
			'user_name' => $customer['user_name'],
			'product_id' => $marketorder['item_id'],
			'product_title' => $marketorder['item_title'],
			'order_id' => $marketorder['order_id'],
			'cost' => $marketorder['order_cost'].' '.$cfg['payments']['valuta'],
			'tax' => $cfg['plugin']['marketorders']['tax'],
			'warranty' => $cfg['plugin']['marketorders']['warranty'],
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'] . '&key=' . $key, '', true)
		));
		cot_mail ($customer['user_email'], $rsubject, $rbody);

		/* === Hook === */
		foreach (cot_getextplugins('marketorders.order.paid') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
}

// Выплаты продавцам по завершению гарантийного срока по оформленным заказам
$warranty = $cfg['plugin']['marketorders']['warranty']*60*60*24;
$marketorders = $db->query("SELECT * FROM $db_market_orders AS o
	LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
	WHERE order_status='paid' AND order_paid+".$warranty."<".$sys['now'])->fetchAll();
foreach ($marketorders as $marketorder)
{
	// Выплата продавцу на счет
	$seller = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_seller'])->fetch();

	if($marketorder['order_cost'] <= 0) {
		$rorder = array();
		$rorder['order_done'] = $sys['now'];
		$rorder['order_status'] = 'done';

		if($db->update($db_market_orders, $rorder, "order_id=".$marketorder['order_id']))
		{

		}

		/* === Hook === */
		foreach (cot_getextplugins('marketorders.order.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		continue;
	}

	$summ = $marketorder['order_cost'] - $marketorder['order_cost']*$cfg['plugin']['marketorders']['tax']/100;

	$payinfo['pay_userid'] = $marketorder['order_seller'];
	$payinfo['pay_area'] = 'balance';
	$payinfo['pay_code'] = 'marketorders:'.$marketorder['order_id'];
	$payinfo['pay_summ'] = $summ;
	$payinfo['pay_cdate'] = $sys['now'];
	$payinfo['pay_pdate'] = $sys['now'];
	$payinfo['pay_adate'] = $sys['now'];
	$payinfo['pay_status'] = 'done';
	$payinfo['pay_desc'] = cot_rc($L['marketorders_done_payments_desc'],
		array(
			'product_title' => $marketorder['item_title'],
			'order_id' => $marketorder['order_id']
		)
	);

	if($db->insert($db_payments, $payinfo))
	{
		// Уведомляем продавца о поступлении оплаты на его счет
		$rsubject = cot_rc($L['marketorders_done_mail_toseller_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
		$rbody = cot_rc($L['marketorders_done_mail_toseller_body'], array(
			'product_id' => $marketorder['item_id'],
			'product_title' => $marketorder['item_title'],
			'order_id' => $marketorder['order_id'],
			'summ' => $summ.' '.$cfg['payments']['valuta'],
			'tax' => $cfg['plugin']['marketorders']['tax'],
			'sitename' => $cfg['maintitle'],
			'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
		));
		cot_mail ($seller['user_email'], $rsubject, $rbody);

		$rorder['order_done'] = $sys['now'];
		$rorder['order_status'] = 'done';

		if($db->update($db_market_orders, $rorder, "order_id=".$marketorder['order_id']))
		{
			if($cfg['plugin']['marketorders']['adminid'] > 0 && $cfg['plugin']['marketorders']['tax'] > 0)
			{
				$payinfo['pay_userid'] = $cfg['plugin']['marketorders']['adminid'];
				$payinfo['pay_area'] = 'balance';
				$payinfo['pay_code'] = 'marketorders:'.$marketorder['order_id'];
				$payinfo['pay_summ'] = $marketorder['order_cost']*$cfg['plugin']['marketorders']['tax']/100;
				$payinfo['pay_cdate'] = $sys['now'];
				$payinfo['pay_pdate'] = $sys['now'];
				$payinfo['pay_adate'] = $sys['now'];
				$payinfo['pay_status'] = 'done';
				$payinfo['pay_desc'] = cot_rc($L['marketorders_tax_payments_desc'],
					array(
						'product_title' => $marketorder['item_title'],
						'order_id' => $marketorder['order_id']
					)
				);

				$db->insert($db_payments, $payinfo);
			}
		}

		/* === Hook === */
		foreach (cot_getextplugins('marketorders.order.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
}
