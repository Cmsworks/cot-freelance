<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rss.create
 * [END_COT_EXT]
 */

/**
 * Frelancers plugin
 *
 * @package freelancers
 * @version 2.2.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if ($c == "users")
{
	$defult_c = false;
	
	$groupid = cot_import('groupid', 'G', 'INT');
	$query_string = (!empty($groupid)) ? "AND user_maingrp=" . $groupid : "AND user_maingrp=4";
	
	if ($id != 'all')
	{
		$catsub = cot_fl_cat_children($id);

		$sql = $db->query("SELECT * FROM $db_users AS u
			WHERE user_cat IN ('".implode("','", $catsub)."') ".$query_string."
			ORDER BY user_regdate DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	else
	{
		$sql = $db->query("SELECT * FROM $db_users AS u
			WHERE ".$query_string."
			ORDER BY user_regdate DESC LIMIT ".$cfg['rss']['rss_maxitems']);
	}
	$i = 0;
	while ($row = $sql->fetch())
	{

		$items[$i]['title'] = $row['user_name'];
		$items[$i]['link'] = COT_ABSOLUTE_URL . cot_url('users', 'm=details&id='.$row['user_id'].'&u='.$row['user_name'], '', true);
		$items[$i]['pubDate'] = cot_date('r', $row['user_regdate']);
		$items[$i]['fields'] = cot_generate_usertags($row);

		$i++;
	}
	$sql->closeCursor();
}

?>