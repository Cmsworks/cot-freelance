<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=market.edit.update.done
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
	// I18n
	if (cot_get_caller() == 'i18n.market')
	{
		global $i18n_locale;
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$rtags = cot_import('rtags', 'P', 'TXT');
	$tags = cot_tag_parse($rtags);
	$old_tags = cot_tag_list($id, 'market', $tags_extra);
	$kept_tags = array();
	$new_tags = array();
	// Find new tags, count old tags that have been left
	$cnt = 0;
	foreach ($tags as $tag)
	{
		$p = array_search($tag, $old_tags);
		if($p !== false)
		{
			$kept_tags[] = $old_tags[$p];
			$cnt++;
		}
		else
		{
			$new_tags[] = $tag;
		}
	}
	// Remove old tags that have been removed
	$rem_tags = array_diff($old_tags, $kept_tags);
	foreach ($rem_tags as $tag)
	{
		cot_tag_remove($tag, $id, 'market', $tags_extra);
	}
	// Add new tags
	$ncnt = count($new_tags);
	if ($cfg['plugin']['tags']['limit'] > 0
		&& $ncnt > $cfg['plugin']['tags']['limit'] - $cnt)
	{
		$lim = $cfg['plugin']['tags']['limit'] - $cnt;
	}
	else
	{
		$lim = $ncnt;
	}
	for ($i = 0; $i < $lim; $i++)
	{
		cot_tag($new_tags[$i], $id, 'market', $tags_extra);
	}
}
