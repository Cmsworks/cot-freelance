<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=market.main
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

if ($cfg['plugin']['tagslance']['market'])
{
	require_once cot_incfile('tags', 'plug');
	// I18n or not i18n
	if (cot_plugin_active('i18n') && $i18n_enabled && $i18n_notmain)
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$item_id = $item['item_id'];
	$tags = cot_tag_list($item_id, 'market', $tags_extra);
	$tag_keywords = implode(', ', $tags);
	if (!empty($tag_keywords) && empty($item['item_keywords']))
	{
		$out['keywords'] = $tag_keywords;
	}
}