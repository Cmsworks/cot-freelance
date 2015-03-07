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
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('usercategories', 'plug');

$r_id = $usr['id'];
if ($m == 'edit')
{
	$r_id = $id;
}
elseif ($m == 'register')
{
	$r_id = $userid;
}

$rcats = cot_import('rcats', 'P', 'ARR');
if(is_array($rcats)){
	$ucats = array_filter($rcats);
	$db->update($db_users, array('user_cats' => implode(',', $ucats)), "user_id=".$r_id);
}
