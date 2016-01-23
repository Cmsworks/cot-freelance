<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.addofferform.tags
 * Tags=projects.offers.tpl:{OFFER_FORM_MAVATAR}
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
	
	$mavatar = new mavatar('projectoffers', $id, '', 'edit');
	
	$t_o->assign('OFFER_FORM_MAVATAR', $mavatar->upload_form());
}