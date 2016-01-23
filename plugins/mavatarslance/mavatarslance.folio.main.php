<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=foliotags.main
 * [END_COT_EXT]
 */
/**
 * mavatarslance for Cotonti CMF
 *
 * @version 1.2.1
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 */
defined('COT_CODE') or die('Wrong URL');
global $cfg, $mavatar, $mav_rowset_list;
if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['folio'])
{
	require_once cot_incfile('mavatars', 'plug');
	
	$mavatar = new mavatar('folio', $item_data['item_cat'], $item_data['item_id'], '', $mav_rowset_list);
	$mavatars_tags = $mavatar->tags();
	$temp_array['MAVATAR'] = $mavatars_tags;
	$temp_array['MAVATARCOUNT'] = count($mavatars_tags);
	
}
