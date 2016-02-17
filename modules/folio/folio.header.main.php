<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */
if (cot_auth('folio', 'any', 'A'))
{	
	$folio_moderated = $db->query("SELECT COUNT(*) FROM {$db_folio} WHERE item_state=2")->fetchColumn();
	$notifyfolio_moderated = ($folio_moderated > 0) ? array(cot_url('admin', 'm=folio&state=2'), cot_declension($folio_moderated, $Ls['folio_headermoderated'])) : '';
	if (!empty($notifyfolio_moderated))
	{
		$out['notices_array'][] = $notifyfolio_moderated;
	}
}