<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.tags,projects.edit.tags
 * Tags=projects.add.tpl:{PRJADD_FORM_MAVATAR};projects.edit.tpl:{PRJEDIT_FORM_MAVATAR}
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

	if ((int) $id > 0)
	{
		$code = $item['item_id'];
		$category = $item['item_cat'];
		$mavpr = 'EDIT';
	}
	else
	{
		$code = '';
		$category = $ritem['item_cat'];
		$mavpr = 'ADD';
	}
	$mavatar = new mavatar('projects', $category, $code, 'edit');

	$t->assign('PRJ'.$mavpr.'_FORM_MAVATAR', $mavatar->upload_form());
}