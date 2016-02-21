<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

if (cot_auth('market', 'any', 'A'))
{	
	$prd_moderated = $db->query("SELECT COUNT(*) FROM {$db_market} WHERE item_state=2")->fetchColumn();
	$notifymarket_moderated = ($prd_moderated > 0) ? array(cot_url('admin', 'm=market&state=2'), cot_declension($prd_moderated, $Ls['market_headermoderated'])) : '';
	if (!empty($notifymarket_moderated))
	{
		$out['notices_array'][] = $notifymarket_moderated;
	}
}