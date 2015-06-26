<?php

/**
 * PayPro plugin
 *
 * @package paypro
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

// Requirements
require_once cot_langfile('paypro', 'plug');
require_once cot_incfile('payments', 'module');

// Global variables
global $db_users_pro, $db_x;
$db_users_pro = (isset($db_users_pro)) ? $db_users_pro : $db_x . 'users_pro';

function cot_getuserpro($user = '')
{
	global $db, $db_users, $sys, $usr;

	if(empty($user) && $usr['profile']['user_pro'] > 0)
	{
		$upro = $usr['profile']['user_pro'];
		$userid = $usr['id'];
	}	
	elseif(!empty($user) && !is_array($user))
	{
		$upro = $db->query("SELECT user_pro FROM $db_users WHERE user_id=".$user)->fetchColumn();
		$userid = $user;
	}
	elseif(is_array($user))
	{	
		$upro = $user['user_pro'];
		$userid = $user['user_id'];
	}
	
	if($upro > $sys['now'])
	{
		return $upro;
	}	
	elseif($upro > 0)
	{
		$db->update($db_users, array('user_pro' => 0), "user_id=".$userid);
	}
	return false;
}


function cot_getcountprjofuser($userid)
{
	global $sys, $db, $db_projects;

	list($year, $month, $day) = explode('-', @date('Y-m-d', $sys['now_offset']));
	$currentday = cot_mktime(0, 0, 0, $month, $day, $year);

	$count = $db->query("SELECT COUNT(*) FROM $db_projects WHERE item_userid=" . $userid . " AND item_date<" . $sys['now'] . " AND item_date>" . $currentday . "")->fetchColumn();

	return $count;
}

function cot_getcountoffersofuser($userid)
{
	global $sys, $db, $db_projects_offers;

	list($year, $month, $day) = explode('-', @date('Y-m-d', $sys['now_offset']));
	$currentday = cot_mktime(0, 0, 0, $month, $day, $year);

	$sql = $db->query("SELECT COUNT(*) as count FROM $db_projects_offers WHERE offer_userid=" . $userid . " AND offer_date<" . $sys['now_offset'] . " AND offer_date>" . $currentday . "");
	$count = $sql->fetchColumn();

	return $count;
}

?>