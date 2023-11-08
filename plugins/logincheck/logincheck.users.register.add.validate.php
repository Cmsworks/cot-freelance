<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.register.add.validate
Order=1
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('logincheck', 'plug');

if (!empty($ruser['user_name']) && !preg_match("/^[a-zA-Z][_a-zA-Z0-9-]*$/i", $ruser['user_name'])) cot_error($L['logincheck_error_invalidchars'], 'rusername');

if(!empty($cfg['plugin']['logincheck']['invalidnames'])){
	$invalidnames = explode(',', $cfg['plugin']['logincheck']['invalidnames']);
	if(is_array($invalidnames)){
		if (!empty($ruser['user_name']) && in_array($ruser['user_name'], $invalidnames)) cot_error($L['logincheck_error_invalidname'], 'rusername');
	}
}