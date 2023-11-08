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

$pid = cot_import('pid', 'G', 'INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders');
cot_block($usr['auth_read']);

if ($pid > 0)
{
	$sql = $db->query("SELECT m.*, u.* FROM $db_market AS m LEFT JOIN $db_users AS u ON u.user_id=m.item_userid WHERE item_id=".$pid." LIMIT 1");
}

if (!$pid || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$item = $sql->fetch();

cot_block(($item['item_cost'] > 0 || $cfg['plugin']['marketorders']['acceptzerocostorders']) && $item['item_state'] == 0);

/* === Hook === */
$extp = cot_getextplugins('marketorders.neworder.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('marketorders.neworder.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rorder['order_count'] = cot_import('rcount', 'P', 'INT');
	$rorder['order_text'] = cot_import('rtext', 'P', 'TXT');
	$email = cot_import('remail', 'P','TXT', 100, TRUE);

	/* === Hook === */
	foreach (cot_getextplugins('marketorders.neworder.add.import') as $pl)
	{
		include $pl;
	}
	/* ===== */

	//cot_check(empty($rorder['order_count']), 'marketorders_neworder_error_count', 'rcount');
	if (!cot_check_email($email) && $usr['id'] == 0) cot_error('aut_emailtooshort', 'remail');

	if(!empty($email) && $usr['id'] == 0)
	{
		$rorder['order_userid'] = $db->query("SELECT user_id FROM $db_users WHERE user_email = ? LIMIT 1", array($email))->fetchColumn();
	}
	else
	{
		$rorder['order_userid'] = $usr['id'];
	}

	/* === Hook === */
	foreach (cot_getextplugins('marketorders.neworder.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rorder['order_count'] = ($rorder['order_count'] > 0) ? $rorder['order_count'] : 1;

	if (!cot_error_found())
	{
		$rorder['order_pid'] = $pid;
		$rorder['order_date'] = $sys['now'];
		$rorder['order_status'] = 'new';
		$rorder['order_title'] = $item['item_title'];
		$rorder['order_seller'] = $item['item_userid'];
		$rorder['order_cost'] = $item['item_cost']*$rorder['order_count'];
		$rorder['order_email'] = $email;

		if ($db->insert($db_market_orders, $rorder))
		{
			$orderid = $db->lastInsertId();

			if(!empty($rorder['order_email']) && $usr['id'] == 0)
			{
				$key = sha1($rorder['order_email'].'&'.$orderid);
			}

			if($rorder['order_cost'] > 0) {
				$options['code'] = $orderid;
				$options['desc'] = $item['item_title'];

				if ($db->fieldExists($db_payments, "pay_redirect"))
				{
					$options['redirect'] = $cfg['mainurl'].'/'.cot_url('marketorders', 'id='.$orderid.'&key='.$key, '', true);
				}

				/* === Hook === */
				foreach (cot_getextplugins('marketorders.neworder.add.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

				cot_payments_create_order('marketorders', $rorder['order_cost'], $options);
			} elseif($cfg['plugin']['marketorders']['acceptzerocostorders']) {
				cot_redirect(cot_url('marketorders', 'id='.$orderid.'&key='.$key, '', true));
			} else {
				cot_redirect(cot_url('payments', 'm=error&msg=3', '', true));
			}
		}
	}

	cot_redirect(cot_url('marketorders', 'm=neworder&pid=' . $pid, '', true));
	exit;
}

$out['subtitle'] = $L['marketorders_neworder_title'];
$out['head'] .= $R['code_noindex'];

$mskin = cot_tplfile(array('marketorders', 'neworder', $structure['market'][$item['item_cat']]['tpl']), 'plug');

/* === Hook === */
foreach (cot_getextplugins('marketorders.neworder.main') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate($mskin);

$catpatharray[] = array(cot_url('market'), $L['market']);
$catpatharray = array_merge($catpatharray, cot_structure_buildpath('market', $item['item_cat']));
$catpatharray[] = array(cot_url('market', 'id='.$pid), $item['item_title']);
$catpatharray[] = array('', $L['marketorders_neworder_title']);

$catpath = cot_breadcrumbs($catpatharray, $cfg['homebreadcrumb'], true);

$t->assign(array(
	"BREADCRUMBS" => $catpath,
));

// Error and message handling
cot_display_messages($t);

$t->assign(cot_generate_markettags($item, 'NEWORDER_PRD_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

$t->assign(array(
	"NEWORDER_FORM_SEND" => cot_url('marketorders', 'm=neworder&pid='.$pid.'&a=add'),
	"NEWORDER_FORM_COUNT" => cot_inputbox('text', 'rcount', 1, 'size="10" id="count"'),
	"NEWORDER_FORM_COMMENT" => cot_textarea('rtext', '', 5, 60),
	"NEWORDER_FORM_EMAIL" => cot_inputbox('text', 'remail'),
));

/* === Hook === */
foreach (cot_getextplugins('marketorders.neworder.tags') as $pl)
{
	include $pl;
}
/* ===== */
