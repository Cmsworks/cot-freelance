<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=market.add.add.done
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
	$tags_extra = (cot_get_caller() == 'i18n.market') ? array('tag_locale' => $i18n_locale): null;

	$rtags = cot_import('rtags', 'P', 'TXT');
	$tags = cot_tag_parse($rtags);
	$cnt = 0;
	foreach ($tags as $tag)
	{
		cot_tag($tag, $id, 'market', $tags_extra);
		$cnt++;
		if ($cfg['plugin']['tags']['limit'] > 0 && $cnt == $cfg['plugin']['tags']['limit'])
		{
			break;
		}
	}
}