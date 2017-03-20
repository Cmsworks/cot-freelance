<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.done, users.register.add.done, users.edit.update.done
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.6.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

if($ruser['user_cats'] != $urr['user_cats'])
{
	$_cats = $urr['user_cats'].','.$ruser['user_cats'];
	$rcats = explode(',', $_cats);
	if(count($rcats) > 0)
	{
		$rcats = array_unique($rcats);
		$rcats = array_diff($rcats, array(''));
		foreach ($rcats as $cat) 
		{
			cot_usercategories_sync($cat);
		}
	}
}