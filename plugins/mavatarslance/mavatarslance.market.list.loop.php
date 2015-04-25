<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.loop
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['market'])
{
	require_once cot_incfile('mavatars', 'plug');
	global $mav_rowset_list;
	global $db_mavatars, $db;

	if (!isset($mav_rowset_list))
	{
		$rowset_copy = $sqllist_rowset;
		reset($rowset_copy);
		$mav_items = array();
		foreach ($rowset_copy as $t_row)
		{
			$mav_items[] = $t_row['item_id'];
		}
		unset($rowset_copy);
		$mav_code = implode("','", $mav_items);
		$mav_rowset_list = $db->query("SELECT * FROM $db_mavatars WHERE mav_extension ='market' AND
				 mav_code IN ('".$mav_code."') ORDER BY mav_code ASC, mav_order ASC, mav_item ASC")->fetchAll();
	
	}
}