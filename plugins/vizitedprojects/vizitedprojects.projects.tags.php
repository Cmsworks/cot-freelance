<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.tags
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

$vizitedprojects = cot_import('vizitedprojects', 'C', 'TXT');
$vizitedprojects = explode(',', $vizitedprojects);
if(!in_array($id, $vizitedprojects)) { array_push($vizitedprojects, $id); }
$vizitedprojects = array_diff($vizitedprojects, array(''));
$vizitedprojects = implode(',', $vizitedprojects);

cot_setcookie('vizitedprojects', $vizitedprojects, time()+$cfg['plugin']['vizitedprojects']['cookielife']*24*3600, $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);