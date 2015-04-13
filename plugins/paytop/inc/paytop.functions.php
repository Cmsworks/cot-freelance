<?php

/**
 * PayTop plugin
 *
 * @package paytop
 * @version 1.0.3
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('paytop', 'plug');

// Global variables
global $db_users_top, $db_x;
$db_users_top = (isset($db_users_top)) ? $db_users_top : $db_x . 'users_top';

// Global variables
function cot_cfg_paytop()
{
	global $cfg;
	
	$tpaset = str_replace("\r\n", "\n", $cfg['plugin']['paytop']['paytopareas']);
	$tpaset = explode("\n", $tpaset);
	$paytopset = array();
	foreach ($tpaset as $lineset)
	{
		$lines = explode("|", $lineset);
		$lines[0] = trim($lines[0]);
		$lines[1] = trim($lines[1]);
		$lines[2] = (float)trim($lines[2]);
		$lines[3] = (int)trim($lines[3]);
		$lines[4] = (int)trim($lines[4]);
		
		if (!empty($lines[0]) && $lines[2] > 0)
		{
			$lines[3] = (!empty($lines[3])) ? $lines[3] : 2592000;
			$lines[4] = (!empty($lines[4])) ? $lines[4] : 4;
			
			$paytopset[$lines[0]]['name'] = $lines[1];
			$paytopset[$lines[0]]['cost'] = $lines[2];
			$paytopset[$lines[0]]['period'] = $lines[3];
			$paytopset[$lines[0]]['count'] = $lines[4];
		}
	}
	return $paytopset;
}

function cot_get_paytop ($area='', $count=0, $order = "s.service_id DESC")
{
	global $db, $cfg, $sys, $db_payments_services, $db_users;
	
	$pt_cfg = cot_cfg_paytop();
	
	if($count == 0)
	{
		$count = $pt_cfg[$area]['count'];
	}
	
	if (empty($area) && !isset($pt_cfg[$area]['cost']))
	{
		return false;
	}
	
	$t1 = new XTemplate(cot_tplfile(array('paytop', 'list', $area), 'plug'));
	
	$paytopcount = $db->query("SELECT COUNT(*) FROM $db_payments_services as s
		LEFT JOIN $db_users AS u ON u.user_id=s.service_userid
		WHERE u.user_id>0 AND s.service_area='paytop.".$db->prep($area)."' AND service_expire > " . $sys['now'])->fetchColumn();
	
	$paytops = $db->query("SELECT * FROM $db_payments_services as s
		LEFT JOIN $db_users AS u ON u.user_id=s.service_userid
		WHERE u.user_id>0 AND s.service_area='paytop.".$db->prep($area)."' AND service_expire > " . $sys['now'] . " ORDER BY $order LIMIT " . $count)->fetchAll();

	$jj = 0;
	
	foreach ($paytops as $tur)
	{
		$jj++;
		
		$t1->assign(cot_generate_usertags($tur, 'TOP_ROW_'));
		$t1->assign(array(
			'TOP_ROW_JJ' => $jj,
			'TOP_ROW_EXPIRE' => $tur['service_expire'],
		));
		$t1->parse('MAIN.TOP_ROW');
	}

	$t1->assign(array(
		'PAYTOP_BUY_URL' => cot_url('plug', 'e=paytop&area='.$area),
		'PAYTOP_COUNT' => $paytopcount
	));

	$t1->parse('MAIN');
	return $t1->text('MAIN');
}

?>