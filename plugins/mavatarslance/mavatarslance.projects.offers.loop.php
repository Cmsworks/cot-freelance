<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.loop
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
global $cfg;
if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['projects'])
{
	require_once cot_incfile('mavatars', 'plug');
	
	$mavatar = new mavatar('projectoffers', $id, $offer['offer_id']);
	$mavatars_tags = $mavatar->tags();
	
	$t_o->assign(array(
		'OFFER_ROW_MAVATAR' => $mavatars_tags,
		'OFFER_ROW_MAVATARCOUNT' => count($mavatars_tags)
	));
}
