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
 * @version 2.6.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

if(!empty($ruser['user_cats']))
{
	$rcats = explode(',', $ruser['user_cats']);
	foreach ($rcats as $cat) 
	{
		cot_usercategories_sync($cat);
	}
}