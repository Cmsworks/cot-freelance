<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('paymarkettop', 'plug');

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'paymarkettop');
cot_block($auth_write);

$id = cot_import('id', 'G', 'INT');

$discounts = explode(";", substr($cfg['plugin']['paymarkettop']['discounts'], 0, -1));
$discount = array();
foreach ($discounts as $_dis){
    list($m, $_discount) = explode("|", $_dis);
    $discount[$m] = $_discount;
}
	
if ($a == 'buy' && !empty($id))
{
	$days = cot_import('days', 'P', 'INT');

	cot_check(empty($days), 'paymarkettop_error_days');

	if (!cot_error_found())
	{

        		$discount = ($cfg['plugin']['paymarkettop']['cost'] / 100) * $discount[$days];
        		$summ = $days * ($cfg['plugin']['paymarkettop']['cost'] - $discount);    
		$options['time'] = $days * 24 * 60 * 60;
		$options['desc'] = $L['paymarkettop_buy_paydesc'];
		$options['code'] = (!empty($id) && $usr['id'] != $id) ? $id : $usr['id'];

		cot_payments_create_order('market.top', $summ, $options);
	}
}

$t = new XTemplate(cot_tplfile('paymarkettop', 'plug'));

cot_display_messages($t);

foreach ($discount as $i => $d) {
    $minus = ($cfg['plugin']['paymarkettop']['cost'] / 100) * $d;
    $t->assign('PAY_FORM_PERIOD_COST_'.$i, ($cfg['plugin']['paymarkettop']['cost'] - $minus) * $i);
    $t->assign('PAY_FORM_PERIOD_OLD_COST_'.$i, ($cfg['plugin']['paymarkettop']['cost']) * $i);
    $t->assign('PAY_FORM_PERIOD_DISCOUNT_'.$i, $d);
}

$t->assign(array(
	'PAY_FORM_ACTION' => cot_url('plug', 'e=paymarkettop&a=buy&id='.$id),
	'PAY_FORM_PERIOD' => cot_selectbox('', 'days', range(1, 30), range(1, 30), false),
));