<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.mainpanel
Order=1
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('regstat.admin.home.mainpanel', 'plug'));

switch ($cfg['plugin']['regstat']['period']){
	case 'week':
		$mindate = $sys['now'] - 7*24*60*60;
		break;
	
	case 'month':
		$mindate = $sys['now'] - 30*24*60*60;
		break;
	
	case 'year':
		$mindate = $sys['now'] - 365*24*60*60;
		break;
	
	default :
		$mindate = $db->query("SELECT user_regdate FROM $db_users WHERE user_maingrp > 3 ORDER BY user_regdate ASC")->fetchColumn();
}

$mindate = mktime( 0, 0, 0, cot_date('m', $mindate), cot_date('d', $mindate), cot_date('Y', $mindate) );

$maxdate = $sys['now'];
$maxdate = mktime( 23, 59, 59, cot_date('m', $maxdate), cot_date('d', $maxdate), cot_date('Y', $maxdate) );

$day = $mindate;
while($day <= $maxdate){
	$nextday = $day + 24*60*60;
	$userscount[$day] = $db->query("SELECT COUNT(*) FROM $db_users WHERE user_maingrp > 3 AND user_regdate >= ".$day." AND user_regdate < ".$nextday)->fetchColumn();
	$day = $nextday;
}

if(is_array($userscount)){
	foreach($userscount AS $day => $count){
		$tt->assign(array(
			'REG_ROW_COUNT' => $count,
			'REG_ROW_DAY' => $day,
		));
		$tt->parse('MAIN.REG_ROW');
	}
}

$tt->parse('MAIN');
$line = $tt->text('MAIN');
