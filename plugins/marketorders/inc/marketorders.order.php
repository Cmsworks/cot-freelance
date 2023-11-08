<?php

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');
$key = cot_import('key', 'G', 'TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders');
cot_block($usr['auth_read']);

if ($id > 0)
{
	$sql = $db->query("SELECT * FROM $db_market_orders  AS o
		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
		WHERE ".(!$cfg['plugin']['marketorders']['showneworderswithoutpayment'] ? "order_status!='new' AND" : "")." order_id=".$id." LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$marketorder = $sql->fetch();

cot_block($usr['isadmin'] || $usr['id'] == $marketorder['order_userid'] || $usr['id'] == $marketorder['order_seller'] || !empty($key) && $usr['id'] == 0);

if($usr['id'] == 0)
{
	$hash = sha1($marketorder['order_email'].'&'.$marketorder['order_id']);
	cot_block($key == $hash);
}

/* === Hook === */
$extp = cot_getextplugins('marketorders.order.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$out['subtitle'] = $L['marketorders_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('marketorders', 'order', $structure['market'][$marketorder['item_cat']]['tpl']), 'plug');

/* === Hook === */
foreach (cot_getextplugins('marketorders.order.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$catpatharray[] = array(cot_url('market'), $L['market']);
//$catpatharray = array_merge($catpatharray, cot_structure_buildpath('market', $item['item_cat']));
//$catpatharray[] = array(cot_url('market', 'id='.$id), $marketorder['item_title']);
$catpatharray[] = array('', $L['marketorders_title']);

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

// Error and message handling
cot_display_messages($t);

$t->assign(cot_generate_markettags($marketorder['order_pid'], 'ORDER_PRD_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));
$t->assign(cot_generate_usertags($marketorder['order_seller'], 'ORDER_SELLER_'));
$t->assign(cot_generate_usertags($marketorder['order_userid'], 'ORDER_CUSTOMER_'));

$t->assign(array(
	"ORDER_ID" => $marketorder['order_id'],
	"ORDER_COUNT" => $marketorder['order_count'],
	"ORDER_COST" => $marketorder['order_cost'],
	"ORDER_TITLE" => $marketorder['order_title'],
	"ORDER_COMMENT" => $marketorder['order_text'],
	"ORDER_EMAIL" => $marketorder['order_email'],
	"ORDER_PAID" => $marketorder['order_paid'],
	"ORDER_DONE" => $marketorder['order_done'],
	"ORDER_STATUS" => $marketorder['order_status'],
	"ORDER_DOWNLOAD" => (in_array($marketorder['order_status'], array('paid', 'done')) && !empty($marketorder['item_file']) && file_exists($cfg['plugin']['marketorders']['filepath'].'/'.$marketorder['item_file'])) ? cot_url('plug', 'r=marketorders&m=download&id='.$marketorder['order_id'].'&key='.$key) : '',
	"ORDER_LOCALSTATUS" => $L['marketorders_status_'.$marketorder['order_status']],
	"ORDER_WARRANTYDATE" => $marketorder['order_paid'] + $cfg['plugin']['marketorders']['warranty']*60*60*24,
));

if($marketorder['order_status'] == 'claim')
{
	$t->assign(array(
		"CLAIM_DATE" => $marketorder['order_claim'],
		"CLAIM_TEXT" => $marketorder['order_claimtext'],
	));

	/* === Hook === */
	foreach (cot_getextplugins('marketorders.order.claim') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if($usr['isadmin'])
	{
		// Отменяем заказ, возвращаем оплату покупателю
		if($a == 'acceptclaim')
		{
			$rorder['order_cancel'] = $sys['now'];
			$rorder['order_status'] = 'cancel';

			if($db->update($db_market_orders, $rorder, 'order_id='.$id))
			{
				if($marketorder['order_userid'] > 0)
				{
					$payinfo['pay_userid'] = $marketorder['order_userid'];
					$payinfo['pay_area'] = 'balance';
					$payinfo['pay_code'] = 'market:'.$marketorder['order_id'];
					$payinfo['pay_summ'] = $marketorder['order_cost'];
					$payinfo['pay_cdate'] = $sys['now'];
					$payinfo['pay_pdate'] = $sys['now'];
					$payinfo['pay_adate'] = $sys['now'];
					$payinfo['pay_status'] = 'done';
					$payinfo['pay_desc'] = cot_rc($L['marketorders_claim_payments_customer_desc'],
						array(
							'product_title' => $marketorder['item_title'],
							'order_id' => $marketorder['order_id']
						)
					);

					$db->insert($db_payments, $payinfo);
				}

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

				// Уведопляем продавца об отмене заказа
				$rsubject = cot_rc($L['marketorders_acceptclaim_mail_toseller_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
				$rbody = cot_rc($L['marketorders_acceptclaim_mail_toseller_body'], array(
					'product_id' => $marketorder['item_id'],
					'product_title' => $marketorder['item_title'],
					'order_id' => $marketorder['order_id'],
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
				));
				cot_mail ($seller['user_email'], $rsubject, $rbody);

				// Уведопляем покупателя об отмене заказа
				$rsubject = cot_rc($L['marketorders_acceptclaim_mail_tocustomer_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
				$rbody = cot_rc($L['marketorders_acceptclaim_mail_tocustomer_body'], array(
					'product_id' => $marketorder['item_id'],
					'product_title' => $marketorder['item_title'],
					'order_id' => $marketorder['order_id'],
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
				));

				/* === Hook === */
				foreach (cot_getextplugins('marketorders.order.acceptclaim.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

				cot_mail ($customer['user_email'], $rsubject, $rbody);

				cot_redirect(cot_url('marketorders', 'm=order&id=' . $id, '', true));
				exit;
			}

			cot_redirect(cot_url('marketorders', 'm=order&id=' . $id, '', true));
			exit;
		}

		// Отменяем жалобу
		if($a == 'cancelclaim')
		{
			$rorder['order_claim'] = 0;
			$rorder['order_status'] = 'paid';

			if($db->update($db_market_orders, $rorder, 'order_id='.$id))
			{
				$customer = $db->query("SELECT * FROM $db_users WHERE user_id=".$marketorder['order_userid'])->fetch();

				// Уведопляем покупателя об отклонении жалобы
				$rsubject = cot_rc($L['marketorders_cancelclaim_mail_tocustomer_header'], array('order_id' => $marketorder['order_id'], 'product_title' => $marketorder['item_title']));
				$rbody = cot_rc($L['marketorders_cancelclaim_mail_tocustomer_body'], array(
					'product_title' => $marketorder['item_title'],
					'order_id' => $marketorder['order_id'],
					'sitename' => $cfg['maintitle'],
					'link' => COT_ABSOLUTE_URL . cot_url('marketorders', "id=" . $marketorder['order_id'], '', true)
				));

				/* === Hook === */
				foreach (cot_getextplugins('marketorders.order.cancelclaim.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

				cot_mail ($customer['user_email'], $rsubject, $rbody);
			}

			cot_redirect(cot_url('marketorders', 'm=order&id=' . $id, '', true));
			exit;
		}

		$t->parse('MAIN.CLAIM.ADMINCLAIM');
	}
	$t->parse('MAIN.CLAIM');
}

/* === Hook === */
foreach (cot_getextplugins('marketorders.order.tags') as $pl)
{
	include $pl;
}
/* ===== */
