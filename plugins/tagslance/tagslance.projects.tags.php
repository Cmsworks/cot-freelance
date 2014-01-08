<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=projects.tags
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

if ($cfg['plugin']['tagslance']['projects'])
{
	if (!isset($tags))
	{
		require_once cot_incfile('projects', 'plug');
		if (cot_plugin_active('i18n') && $i18n_enabled && $i18n_notmain)
		{
			$tags_extra = array('tag_locale' => $i18n_locale);
		}
		else
		{
			$tags_extra = null;
		}
		$item_id = $item['item_id'];
		$tags = cot_tag_list($item_id, 'projects', $tags_extra);
	}
	if (count($tags) > 0)
	{
		$tag_i = 0;
		foreach ($tags as $tag)
		{
			$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
			$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
			$t->assign(array(
				'PRJ_TAGS_ROW_TAG' => $cfg['plugin']['tags']['title'] ? htmlspecialchars(cot_tag_title($tag)) : htmlspecialchars($tag),
				'PRJ_TAGS_ROW_URL' => cot_url('plug', array('e' => 'tags', 'a' => 'projects', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl))
			));
			$t->parse('MAIN.PRJ_TAGS_ROW');
			$tag_i++;
		}
	}
	else
	{
		$t->assign(array(
			'PRJ_NO_TAGS' => $L['tags_Tag_cloud_none']
		));
		$t->parse('MAIN.PRJ_NO_TAGS');
	}
}
