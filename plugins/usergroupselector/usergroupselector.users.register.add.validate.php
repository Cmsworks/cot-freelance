<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.add.validate
 * [END_COT_EXT]
 */
/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('usergroupselector', 'plug');

$usergroup = cot_import('usergroup', 'G', 'ALP');
if (cot_error_found() && !empty($usergroup))
{
	cot_redirect(cot_url('users', 'm=register&usergroup='.$usergroup, '', true));
}