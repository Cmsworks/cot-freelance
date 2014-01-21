<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('paytop', 'plug');

$pt_cfg = cot_cfg_paytop();

$t = new XTemplate(cot_tplfile('paytop.admin', 'plug', true));

$id = cot_import('id', 'G', 'INT');

if ($a == 'add')
{
	$username = cot_import('username', 'P', 'TXT', 100, TRUE);
	$area = cot_import('area', 'P', 'ALP');
	$times = cot_import('times', 'P', 'INT');
	$urr_id = $db->query("SELECT user_id FROM $db_users WHERE user_name='" . $username . "'")->fetchColumn();

	cot_check(empty($username), 'paytop_error_username');
	cot_check(empty($urr_id), 'paytop_error_userempty');
	cot_check(empty($times), 'paytop_error_timesempty');
	cot_check(empty($area), 'paytop_error_areaempty');

	if (!cot_error_found())
	{
		cot_payments_userservice('paytop.' . $area, $urr_id, $times * $pt_cfg[$area]['period']);

		/* === Hook === */
		foreach (cot_getextplugins('paytop.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		/* === Hook === */
		foreach (cot_getextplugins('paytop.' . $area . '.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}
	cot_redirect(cot_url('admin', 'm=other&p=paytop', '', true));
}

if ($a == 'delete')
{
	$db->delete($db_payments_services, "service_id=?", array($id));
	cot_redirect(cot_url('admin', 'm=other&p=paytop', '', true));
}

$paytops = $db->query("SELECT * FROM $db_payments_services as s
	LEFT JOIN $db_users AS u ON u.user_id=s.service_userid
	WHERE s.service_area LIKE 'paytop.%' ORDER BY s.service_id DESC")->fetchAll();

foreach ($paytops as $urr)
{
	$t->assign(cot_generate_usertags($urr, 'TOP_ROW_USER_'));
	$t->assign(array(
		'TOP_ROW_AREA' => $urr['service_area'],
		'TOP_ROW_EXPIRE' => $urr['service_expire'],
		'TOP_ROW_SERVICE_ID' => $urr['service_id'],
	));
	$t->parse('MAIN.TOP_ROW');
}

cot_display_messages($t);

$areas_val[] = '';
$areas_title[] = '';

foreach ($pt_cfg as $area => $opt)
{
	$areas_val[] = $area;
	$areas_title[] = $opt['name'];
}

switch($pt_cfg[$area]['period'])
{
	case 2592000:
		$period = range(1, 12);
		$period_name = $L['paytop_month'];
	break;
	case 604800:
		$period = range(1, 48);
		$period_name = $L['paytop_week'];
	break;
	case 86400:
		$period = range(1, 100);
		$period_name = $L['paytop_day'];
	break;
	case 3600:
		$period = range(1, 100);
		$period_name = $L['paytop_hour'];
	break;
	
	default:
		$period = range(1, 12);
		$period_name = $L['paytop_month'];
	break;
}

$t->assign(array(
	'TOP_FORM_ACTION_URL' => cot_url('admin', 'm=other&p=paytop&a=add'),
	'TOP_FORM_PERIOD' => cot_selectbox($months, 'times', $period, $period, false),
	'TOP_FORM_PERIOD_NAME' => $period_name,
	'TOP_FORM_AREA' => cot_selectbox('', 'area', $areas_val, $areas_title, false),
));

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
