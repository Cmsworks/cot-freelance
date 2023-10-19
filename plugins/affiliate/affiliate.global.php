<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL');


require_once cot_incfile('payments', 'module');
require_once cot_incfile('affiliate', 'plug');

$ref = cot_import('ref', 'G', 'INT');

if($ref > 0 && empty($_COOKIE['ref'])){
	cot_setcookie('ref', $ref, $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
}