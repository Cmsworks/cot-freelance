<?php

/**
 * UserPoints plugin
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

// Requirements
require_once cot_langfile('userpoints', 'plug');

// Global variables
global $db_userpoints, $db_x;
$db_userpoints = (isset($db_userpoints)) ? $db_userpoints : $db_x . 'userpoints';

function cot_setuserpoints($points, $type, $userid, $itemid = 0)
{
	global $db, $cfg, $sys, $db_userpoints, $db_users;
	
	if ($urr = $db->query("SELECT * FROM $db_users WHERE user_id=" . (int)$userid)->fetch())
	{
		if(preg_match("/([\d\.]{1,}\%)/", $points, $pt))
		{
			$points = $urr['user_userpoints']*$pt[1]/100;
		}
		
		if($points == 0)
		{
			return $urr['user_userpoints'];
		}
		
		$ritem = array();
		$ritem['item_date'] = (int)$sys['now'];
		$ritem['item_userid'] = (int)$userid;
		$ritem['item_type'] = $type;
		$ritem['item_itemid'] = (int)$itemid;
		$ritem['item_point'] = (float)$points;
		$db->insert($db_userpoints, $ritem);

		$uuserpoints = $db->query("SELECT SUM(item_point) as summ FROM $db_userpoints WHERE item_userid=" . (int)$userid)->fetchColumn();
		$db->update($db_users, array('user_userpoints' => $uuserpoints), "user_id=" . (int)$userid);

		return $uuserpoints;
	}
	else
	{
		return false;
	}
}

function cot_get_topusers ($maingrp, $count, $sqlsearch='', $tpl='index')
{
	global $L, $cfg, $db, $db_users;

	$t1 = new XTemplate(cot_tplfile(array('userpoints', $tpl), 'plug'));
	
	$sqlsearch = !empty($sqlsearch) ? " AND " . $sqlsearch : '';
	
	$topusers = $db->query("SELECT * FROM $db_users
		WHERE user_userpoints>0 AND user_maingrp=".$maingrp." $sqlsearch ORDER BY user_userpoints DESC LIMIT " . $count)->fetchAll();

	foreach ($topusers as $tur)
	{
		$t1->assign(cot_generate_usertags($tur, 'TOP_ROW_'));
		$t1->parse('MAIN.TOP_ROW');
	}

	$t1->parse('MAIN');
	return $t1->text('MAIN');
}


?>
