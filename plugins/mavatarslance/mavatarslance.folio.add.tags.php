<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=folio.add.tags,folio.edit.tags
 * Tags=folio.add.tpl:{PRDADD_FORM_MAVATAR};folio.edit.tpl:{PRDEDIT_FORM_MAVATAR}
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

if (cot_plugin_active('mavatars') && $cfg['plugin']['mavatarslance']['folio'])
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
	$mavatar = new mavatar('folio', $category, $code, 'edit');

	$t->assign('PRD'.$mavpr.'_FORM_MAVATAR', $mavatar->upload_form());
}