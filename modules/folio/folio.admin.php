<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=admin
 * [END_COT_EXT]
 */

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('folio', 'module');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('folio', 'any');
cot_block($usr['isadmin']);

$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
$adminpath[] = array(cot_url('admin', 'm=extensions&a=details&mod='.$m), $cot_modules[$m]['title']);
$adminpath[] = array(cot_url('admin', 'm='.$m), $L['Administration']);

if (!in_array($p, array('default')))
{
	$p = 'default';
}

require_once cot_incfile('folio', 'module', 'admin.'.$p);