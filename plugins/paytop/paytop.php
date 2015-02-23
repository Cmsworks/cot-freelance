<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('paytop', 'plug');

$area = cot_import('area', 'G', 'ALP');

$pt_cfg = cot_cfg_paytop();
	
if (empty($pt_cfg[$area]) || empty($pt_cfg[$area]['cost']))
{
	cot_block();
}

list($auth_read, $auth_write, $auth_admin) = cot_auth('plug', 'paytop');
cot_block($auth_write);

if ($a == 'buy')
{
	if (!cot_error_found())
	{

		$options['desc'] = $L['paytop_buytop_paydesc'].' ('.$pt_cfg[$area]['name'].')';
		$options['time'] = (!empty($pt_cfg[$area]['period'])) ? $pt_cfg[$area]['period'] : 2592000;
		
		if ($db->fieldExists($db_payments, "pay_redirect")){
			$options['redirect'] = $cfg['mainurl'].'/'.cot_url('payments', 'm=balance', '', true);
		}
		
		cot_payments_create_order('paytop.'.$area, $pt_cfg[$area]['cost'], $options);
	}
}

$t = new XTemplate(cot_tplfile(array('paytop', $area), 'plug'));

cot_display_messages($t);

$t->assign(array(
	'TOP_FORM_ACTION' => cot_url('plug', 'e=paytop&a=buy&area='.$area),
	'TOP_FORM_COST' => $pt_cfg[$area]['cost'],
	'TOP_FORM_AREA_NAME' => $pt_cfg[$area]['name'],
));

?>