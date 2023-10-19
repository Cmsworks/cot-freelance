<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

$ref = cot_import('ref', 'C', 'INT');
if($usr['id'] == 0 && empty($ref)){
	cot_setcookie('ref', $urr['user_id'], $sys['now']+12*30*24*60*60, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
}