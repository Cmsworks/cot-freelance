<?php

/* ====================
  [BEGIN_COT_EXT]
 * Hooks=standalone
  [END_COT_EXT]
  ==================== */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('paytop', 'plug');

$pt_cfg = cot_cfg_paytop();

if(empty($m))
{
	$area = cot_import('area', 'G', 'ALP');
		
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
}
elseif($m == 'my')
{
	$t = new XTemplate(cot_tplfile(array('paytop', 'my'), 'plug'));

	$paytops = $db->query("SELECT * FROM $db_payments_services 
		WHERE service_area LIKE 'paytop.%' AND service_userid=".$usr['id']." ORDER BY service_id DESC")->fetchAll();

	foreach ($paytops as $paytop)
	{
		$area = substr($paytop['service_area'], 7);
		$t->assign(array(
			'TOP_ROW_ID' => $paytop['service_id'],
			'TOP_ROW_AREA' => $paytop['service_area'],
			'TOP_ROW_AREA_TITLE' => $pt_cfg[$area]['name'],
			'TOP_ROW_EXPIRE' => $paytop['service_expire'],
			'TOP_ROW_SERVICE_ID' => $paytop['service_id'],
		));
		$t->parse('MAIN.TOP_ROW');
	}
}

