<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=folio.list.tags
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


if ($cfg['plugin']['tagslance']['folio'])
{
	require_once cot_incfile('tags', 'plug');
	// I18n or not i18n
	if (cot_plugin_active('i18n') && $i18n_enabled && $i18n_notmain)
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
		$tags_where .= " AND tag_locale = '$i18n_locale'";
	}
	else
	{
		$tags_extra = null;
	}
	// Get all subcategories
	$tc_cats = cot_structure_children('folio', $c);
	$tc_cats = implode("','", $tc_cats);

	// Get all pages from all subcategories and all tags with counts for them
	$limit = $cfg['plugin']['tags']['lim_pages'] == 0 ? '' : ' LIMIT ' . (int) $cfg['plugin']['tags']['lim_pages'];
	$order = $cfg['plugin']['tags']['order'];
	switch($order)
	{
		case 'Alphabetical':
			$order = 'tag';
		break;
		case 'Frequency':
			$order = 'cnt DESC';
		break;
		default:
			$order = 'RAND()';
	}

	$tc_res = $db->query("SELECT r.tag AS tag, COUNT(r.tag_item) AS cnt
		FROM $db_tag_references AS r LEFT JOIN $db_folio AS p
		ON r.tag_item = p.item_id
		WHERE r.tag_area = 'folio' $tags_where AND p.item_cat IN ('".$tc_cats."') AND p.item_state = 0
		GROUP BY r.tag
		ORDER BY $order $limit");
	$tc_html = $R['tags_code_cloud_open'];
	$tag_count = 0;
	while ($tc_row = $tc_res->fetch())
	{
		$tag_count++;
		$tag = $tc_row['tag'];
		$tag_t = $cfg['plugin']['tags']['title'] ? cot_tag_title($tag) : $tag;
		$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
		$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
		$cnt = (int) $tc_row['cnt'];
		foreach ($tc_styles as $key => $val)
		{
			if ($cnt <= $key)
			{
				$dim = $val;
				break;
			}
		}
		$tc_html .= cot_rc('tags_link_cloud_tag', array(
			'url' => cot_url('plug', array('e' => 'tags', 'a' => 'folio', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)),
			'tag_title' => htmlspecialchars($tag_t),
			'dim' => $dim
		));
	}
	$tc_res->closeCursor();
	$tc_html .= $R['tags_code_cloud_close'];
	$tc_html = ($tag_count > 0) ? $tc_html : $L['tags_Tag_cloud_none'];

	$t->assign('PRD_TAG_CLOUD', $tc_html);
	if ($cfg['plugin']['tags']['more'] && $limit > 0 && $tag_count == $limit)
	{
		$t->assign('PRD_TAG_CLOUD_ALL_LINK',
			cot_rc('tags_code_cloud_more', array('url' => cot_url('plug', 'e=tags&a=folio'))));
	}
}
