<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=projects.edit.tags
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

if ($cfg['plugin']['tagslance']['projects'] && cot_auth('plug', 'tags', 'W'))
{
	require_once cot_incfile('tags', 'plug');
	$tags_caller = cot_get_caller();
	if ($tags_caller == 'i18n.projects')
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$tags = cot_tag_list($id, 'projects', $tags_extra);
	$tags = implode(', ', $tags);
	$t->assign(array(
		'PRJEDIT_FORM_TAGS_TITLE' => $L['Tags'],
		'PRJEDIT_FORM_TAGS_HINT' => $L['tags_comma_separated'],
		'PRJEDIT_FORM_TAGS' => cot_rc('tags_input_editpage')
	));
	if ($tags_caller == 'i18n.project')
	{
		$t->assign(array(
			'I18N_PRJ_TAGS' => implode(', ', cot_tag_list($id)),
			'I18N_IPRJ_TAGS' => cot_rc('tags_input_editpage')
		));
	}
	$t->parse('MAIN.TAGS');
}