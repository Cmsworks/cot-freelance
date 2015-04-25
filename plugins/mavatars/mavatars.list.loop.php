<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.loop
[END_COT_EXT]
==================== */

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 1.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */

defined('COT_CODE') or die('Wrong URL');


	require_once cot_incfile('mavatars', 'plug');
	global $mav_rowset_list;
	global $db_mavatars, $db;

	if (!isset($mav_rowset_list))
	{
		// Load tags for all entries with 1 query
		$rowset_copy = $sqllist_rowset;
		reset($rowset_copy);
		$mav_items = array();
		foreach ($rowset_copy as $t_row)
		{
			$mav_items[] = $t_row['page_id'];
		}
		unset($rowset_copy);
		$mav_code = implode("','", $mav_items);
		$mav_rowset_list = $db->query("SELECT * FROM $db_mavatars WHERE mav_extension ='page' AND
				 mav_code IN ('".$mav_code."') ORDER BY mav_code ASC, mav_order ASC, mav_item ASC")->fetchAll();
	
	}


