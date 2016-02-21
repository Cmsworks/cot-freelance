<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

if (cot_auth('projects', 'any', 'A'))
{	
	$prj_moderated = $db->query("SELECT COUNT(*) FROM {$db_projects} WHERE item_state=2")->fetchColumn();
	$notify_moderated = ($prj_moderated > 0) ? array(cot_url('admin', 'm=projects&state=2'), cot_declension($prj_moderated, $Ls['projects_headermoderated'])) : '';
	if (!empty($notify_moderated))
	{
		$out['notices_array'][] = $notify_moderated;
	}
}