<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=market.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$vizitedproducts = cot_import('vizitedproducts', 'C', 'TXT');
$vizitedproducts = explode(',', $vizitedproducts);
if(!in_array($id, $vizitedproducts)) { array_push($vizitedproducts, $id); }
$vizitedproducts = array_diff($vizitedproducts, array(''));
$vizitedproducts = implode(',', $vizitedproducts);

cot_setcookie('vizitedproducts', $vizitedproducts, time()+$cfg['plugin']['vizitedproducts']['cookielife']*24*3600, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);