<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.register.add.done
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$ref = cot_import('ref', 'C', 'INT');
if($ref > 0 && $userid != $ref){
	$db->update($db_users, array('user_referal' => $ref), "user_id=".$userid);	
	cot_setcookie('ref', '', time()-63072000, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
}