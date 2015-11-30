<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=projects.add.tags
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
	$t->assign(array(
		'PRJADD_FORM_TAGS_TITLE' => $L['Tags'],
		'PRJADD_FORM_TAGS_HINT' => $L['tags_comma_separated'],
		'PRJADD_FORM_TAGS' => cot_rc('tags_input_editpage', array('tags' => ''))
	));
	if (cot_get_caller() == 'i18n.projects')
	{
		$t->assign(array(
			'I18N_PAGE_TAGS' => implode(', ', cot_tag_list($id)),
			'I18N_IPAGE_TAGS' => cot_rc('tags_input_editpage', array('tags' => ''))
		));
	}
	$t->parse('MAIN.TAGS');
}