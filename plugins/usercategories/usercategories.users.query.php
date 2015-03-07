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
	if(!empty($cat)){
		$where['cat'] = "user_cats LIKE '%".$db->prep($cat)."%'";
	}else{
		$where['cat'] = "user_id=0";
	}
	$users_url_path['cat'] =  $cat;
}
