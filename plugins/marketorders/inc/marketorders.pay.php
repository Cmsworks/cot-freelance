<?php

defined('COT_CODE') or die('Wrong URL');

$id = cot_import('id', 'G', 'INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'marketorders');
cot_block($usr['auth_read']);

if ($id > 0)
{
	$sql = $db->query("SELECT * FROM $db_market_orders  AS o
		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
		WHERE order_id=".$id." LIMIT 1");
}

if (!$id || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$marketorder = $sql->fetch();

cot_block($marketorder['order_cost'] > 0 && $marketorder['order_status'] == 'new' && $marketorder['order_userid'] == $usr['id']);

/* === Hook === */
$extp = cot_getextplugins('marketorders.pay.first');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$orderid = $marketorder['order_id'];

if(!empty($marketorder['order_email']) && $usr['id'] == 0)
{
	$key = sha1($marketorder['order_email'].'&'.$orderid);
}

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

cot_payments_create_order('marketorders', $marketorder['order_cost'], $options);
exit;
