<?php defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('prjcount', 'plug');

function cot_prj_published_count($usr){
	global $cfg, $db, $db_projects;

	$realized = '';

	if($cfg['plugin']['prjcount']['realized']){
		$realized = " AND item_realized = 0";
	}
	$count = $db->query("SELECT COUNT(item_id) FROM {$db_projects} WHERE item_state= 0 AND item_userid = {$usr} {$realized}")->fetchColumn();

	if(!$count || $count < 0){
		$count = 0;
	}

	return $count;
}

function cot_prj_offers_published_count($usr){
	global $db, $db_projects_offers;

	$count = $db->query("SELECT COUNT(offer_id) FROM {$db_projects_offers} WHERE offer_userid = {$usr}")->fetchColumn();

	if(!$count || $count < 0){
		$count = 0;
	}
	
	return $count;
}