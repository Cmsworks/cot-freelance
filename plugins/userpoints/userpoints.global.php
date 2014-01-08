<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
/**
 * Userpoints plugin
 *
 * @package freelancers
 * @version 2.0.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userpoints', 'plug');
	
if($usr['id'] > 0)
{
	$lastauthpoints = $_COOKIE["lastauthuserpoints"];
	if(!empty($lastauthpoints) && $lastauthpoints + 86400 < $sys['now'])
	{
		cot_setuserpoints($cfg['plugin']['userpoints']['auth'], 'auth', $usr['id']);
		cot_setcookie("lastauthuserpoints", $sys['now'], time()+$cfg['cookielifetime'], $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
	}
}

?>