<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=market.list.loop
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
	if (cot_plugin_active('i18n') && $i18n_enabled && $i18n_notmain)
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$item_id = $item['item_id'];

	if (!isset($tags_rowset_list))
	{
		$tags_rowset_list = cot_tag_list(array_keys($sqllist_idset), 'market', $tags_extra);
	}

	$tags = isset($tags_rowset_list[$item_id]) ? $tags_rowset_list[$item_id] : array();
	if (count($tags) > 0)
	{
		$tag_i = 0;
		foreach ($tags as $tag)
		{
			$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
			$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
			$t->assign(array(
				'PRD_ROW_TAGS_ROW_TAG' => $cfg['plugin']['tags']['title'] ? htmlspecialchars(cot_tag_title($tag)) : htmlspecialchars($tag),
				'PRD_ROW_TAGS_ROW_URL' => cot_url('plug', array('e' => 'tags', 'a' => 'market', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl))
			));
			$t->parse('MAIN.PRD_ROWS.PRD_ROW_TAGS_ROW');
			$tag_i++;
		}
	}
	else
	{
		$t->assign(array(
			'PRD_ROW_NO_TAGS' => $L['tags_Tag_cloud_none']
		));
		$t->parse('MAIN.PRD_ROWS.PRD_ROW_NO_TAGS');
	}
}
