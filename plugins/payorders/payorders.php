<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('payorders', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'payorders');
cot_block($auth_read);

$payorders = $db->query("SELECT * FROM $db_payments WHERE pay_area='payorders' AND pay_userid=".$usr['id'])->fetchAll();
foreach($payorders as $ord)
{
	$t->assign(cot_generate_paytags($ord, 'ORD_ROW_'));
	$t->parse('MAIN.ORD_ROW');
}