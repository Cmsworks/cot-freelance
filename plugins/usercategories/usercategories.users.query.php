<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=99
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('usercategories', 'plug');

$cat = cot_import('cat', 'G', 'ALP');

if (!empty($cat))
{
	$subcats = cot_structure_children('usercategories', $cat);
	if(count($subcats) > 0){
		foreach ($subcats as $val) {
			$cat_query[] = "FIND_IN_SET('".$db->prep($val)."', user_cats)";
		}
		$where['cat'] = "(".implode(' OR ', $cat_query).")";
	}else{
		$where['cat'] = "user_id=0";
	}
	$users_url_path['cat'] =  $cat;
}
