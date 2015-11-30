<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=market.edit.tags
 * [END_COT_EXT]
 */
 
/**
 * plugin tagslance for Cotonti Siena
 * 
 * @package tagslance
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL.');

if ($cfg['plugin']['tagslance']['market'] && cot_auth('plug', 'tags', 'W'))
{
	require_once cot_incfile('tags', 'plug');
	$tags_caller = cot_get_caller();
	if ($tags_caller == 'i18n.market')
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$tags = cot_tag_list($id, 'market', $tags_extra);
	$tags = implode(', ', $tags);
	$t->assign(array(
		'PRDEDIT_FORM_TAGS_TITLE' => $L['Tags'],
		'PRDEDIT_FORM_TAGS_HINT' => $L['tags_comma_separated'],
		'PRDEDIT_FORM_TAGS' => cot_rc('tags_input_editpage')
	));
	if ($tags_caller == 'i18n.market')
	{
		$t->assign(array(
			'I18N_PRD_TAGS' => implode(', ', cot_tag_list($id)),
			'I18N_IPRD_TAGS' => cot_rc('tags_input_editpage')
		));
	}
	$t->parse('MAIN.TAGS');
}