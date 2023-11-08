<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * filterforuser plugins
 *
 * @package filterforuser
 * @copyright (c) CrazyFreeMan
 */
defined('COT_CODE') or die('Wrong URL');


require_once cot_incfile('filterforuser', 'plug');
require_once cot_langfile('filterforuser', 'plug');
require_once cot_incfile('extrafields');
require_once cot_incfile('users', 'module');
$db_filterforuser = (isset($db_filterforuser)) ? $db_filterforuser : $db_x . 'filterforuser';
 //отримуємо список додаткових полів для USERS
		
$t = new XTemplate(cot_tplfile('filterforuser.admin', 'plug', true));

$adminsubtitle = $L['filterforuser'];

if ($a == 'add'){// вмикаємо використання поля в фільтрі
		$fu_opt = strtolower(trim(cot_import('fu_options', 'G', 'TXT')));					
		$queryToDB = "SELECT COUNT(*) FROM $db_filterforuser WHERE fu_fieldname = '$fu_opt'";		
		if ($db->query($queryToDB)->fetchColumn() > 0)
		{
			$db->update($db_filterforuser, array('fu_fieldstatus' => 1), "fu_fieldname = '$fu_opt'");
		}
		else
		{
			$db->insert($db_filterforuser, array('fu_fieldname' => $fu_opt, 'fu_fieldstatus' => 1));	
		}
	cot_message(cot_rc('filterfor_add', $fu_opt));
	cot_redirect(cot_url('admin', 'm=other&p=filterforuser', '', true));
}elseif($a == 'delete'){ // вимикаємо використання поля в фільтрі
		$fu_opt = trim(cot_import('fu_options', 'G', 'TXT'));	
		$queryToDB = "SELECT COUNT(*) FROM $db_filterforuser WHERE fu_fieldname = '$fu_opt'";		
		if ($db->query($queryToDB)->fetchColumn() == 1)
		{
			$db->delete($db_filterforuser, "fu_fieldname = ?", $fu_opt);	
		}
	cot_message(cot_rc('filterfor_delete', $fu_opt));
	cot_redirect(cot_url('admin', 'm=other&p=filterforuser', '', true));
}	
		
$array_fu = array();
$count = 0;
$allowtype = array('select','checklistbox','radio');
foreach($cot_extrafields[$db_users] as $exfld)
{
		if(in_array($exfld['field_type'], $allowtype, true)){
		$array_fu[$count]['futype'] = $exfld['field_type'];
		$array_fu[$count]['funame'] = strtolower($exfld['field_name']);
		$array_fu[$count]['futext'] = isset($L['user_'.$exfld['field_name'].'_title']) ? $L['user_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
		$array_fu[$count]['fuenabled'] = ($exfld['field_enabled']) ? "Используется" : "Отключено" ;
		$count++;
		}
}
foreach ($array_fu as $val)
{	
	if ($db->query("SELECT  COUNT(*) FROM $db_filterforuser WHERE fu_fieldname = '$val[funame]'")->fetchColumn() == 1) {		
		$fu_url = cot_url('admin', 'm=other&p=filterforuser&a=delete&fu_options='.$val['funame']);
		$fu_title = $L['filterfor_off'];
	}else{
		$fu_url = cot_url('admin', 'm=other&p=filterforuser&a=add&fu_options='.$val['funame']);
		$fu_title = $L['filterfor_on'];
	}
	$t->assign(array(
	'FILTERFORUSER_ADD_OPTION' => $val['futext']." [".$val['funame']."] - ".$val['futype'],
	'FILTERFORUSER_ADD' => ($val['fuenabled'] == 'Отключено') ? '#' : $fu_url,
	'FILTERFORUSER_ADD_TITLE' => $fu_title
	));
	$t->parse('MAIN.OPT_ROW');
}

cot_display_messages($t);
$t->parse();
$plugin_body = $t->text('MAIN');