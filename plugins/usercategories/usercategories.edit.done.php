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

if (isset($_POST['ruc_cattree']))
{
	
	$db->delete($db_usercategories_users, 'ucat_userid=' . (int) $r_id);

	$ruc_cattree = cot_import('ruc_cattree', 'P', 'ARR');
	foreach ($ruc_cattree as $key => $val)
	{
		if ($val)
		{
			$db->insert($db_usercategories_users, array('ucat_userid' => (int) $r_id, 'ucat_cat' => $key));
		}
	}
}
