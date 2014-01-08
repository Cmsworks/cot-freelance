<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=input
 * [END_COT_EXT]
 */
 
/**
 * Interkassa billing Plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$e = cot_import('e', 'G', 'ALP');
$r = cot_import('r', 'G', 'ALP');

if(($e == 'ikassabilling' || $r == 'ikassabilling') && $_SERVER['REQUEST_METHOD'] == 'POST' && $cfg['plugin']['ikassabilling']['enablepost'])
{
	define('COT_NO_ANTIXSS', TRUE) ;
	$cfg['referercheck'] = false;
}

?>