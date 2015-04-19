<?php

/**
 * plugin tagslance for Cotonti Siena
 * 
 * @package tagslance
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('tagslance', 'plug');

/**
 * Search by tag in folio
 *
 * @param string $query User-entered query string
 * @global CotDB $db
 */
function cot_tag_search_folio($query)
{
	global $db, $t, $L, $lang, $cfg, $usr, $qs, $d, $db_tag_references, $db_folio, $o, $row, $sys;

	if (!cot_module_active('folio'))
	{
		return;
	}

	$query = cot_tag_parse_query($query, 'f.item_id');
	if (empty($query))
	{
		return;
	}

	$totalitems = $db->query("SELECT DISTINCT COUNT(*)
		FROM $db_tag_references AS r LEFT JOIN $db_folio AS f
			ON r.tag_item = f.item_id
		WHERE r.tag_area = 'folio' AND ($query) AND f.item_state = 0")->fetchColumn();
	switch($o)
	{
		case 'title':
			$order = 'ORDER BY `item_title`';
		break;
		case 'date':
			$order = 'ORDER BY `item_date` DESC';
		break;
		case 'category':
			$order = 'ORDER BY `item_cat`';
		break;
		default:
			$order = '';
	}


	/* == Hook == */
	foreach (cot_getextplugins('tags.search.folio.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql = $db->query("SELECT DISTINCT f.* $join_columns
		FROM $db_tag_references AS r LEFT JOIN $db_folio AS f
			ON r.tag_item = f.item_id $join_tables
		WHERE r.tag_area = 'folio' AND ($query) AND f.item_id IS NOT NULL AND f.item_state = 0 $join_where
		$order
		LIMIT $d, {$cfg['maxrowsperpage']}");
	$t->assign('TAGS_RESULT_TITLE', $L['tags_Found_in_folio']);
	$pcount = $sql->rowCount();

	/* == Hook : Part 1 == */
	$extp = cot_getextplugins('tags.search.folio.loop');
	/* ===== */

	if ($pcount > 0)
	{
		foreach ($sql->fetchAll() as $row)
		{
			$tags = cot_tag_list($row['item_id'],'folio');
			$tag_list = '';
			$tag_i = 0;
			foreach ($tags as $tag)
			{
				$tag_t = $cfg['plugin']['tags']['title'] ? cot_tag_title($tag) : $tag;
				$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
				$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
				if ($tag_i > 0) $tag_list .= ', ';
				$tag_list .= cot_rc_link(cot_url('plug', array('e' => 'tags', 'a' => 'folio', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)), htmlspecialchars($tag_t));
				$tag_i++;
			}

			$t->assign(cot_generate_foliotags($row, 'TAGS_RESULT_ROW_'));
			$t->assign(array(
				//'TAGS_RESULT_ROW_URL' => empty($row['page_alias']) ? cot_url('page', 'c='.$row['page_cat'].'&id='.$row['page_id']) : cot_url('page', 'c='.$row['page_cat'].'&al='.$row['page_alias']),
				'TAGS_RESULT_ROW_TITLE' => htmlspecialchars($row['item_title']),
				'TAGS_RESULT_ROW_PATH' => cot_breadcrumbs(cot_structure_buildpath('folio', $row['item_cat']), false),
				'TAGS_RESULT_ROW_TAGS' => $tag_list
			));
			/* == Hook : Part 2 == */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */
			$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_ROW');
		}
		$sql->closeCursor();
		$qs_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($qs) : $qs;
		$tl = $lang != 'en' && $qs_u != $qs ? 1 : null;
		$pagenav = cot_pagenav('plug', array('e' => 'tags', 'a' => 'folio', 't' => $qs_u, 'tl' => $tl), $d, $totalitems, $cfg['maxrowsperpage']);
		$t->assign(array(
			'TAGS_PAGEPREV' => $pagenav['prev'],
			'TAGS_PAGENEXT' => $pagenav['next'],
			'TAGS_PAGNAV' => $pagenav['main']
		));

		/* == Hook == */
		foreach (cot_getextplugins('tags.search.folio.tags') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

	if($pcount == 0)
	{
		$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_NONE');
	}

	$t->parse('MAIN.TAGS_RESULT');
}

function cot_tag_search_market($query)
{
	global $db, $t, $L, $lang, $cfg, $usr, $qs, $d, $db_tag_references, $db_market, $o, $row, $sys;

	if (!cot_module_active('market'))
	{
		return;
	}

	$query = cot_tag_parse_query($query, 'm.item_id');
	if (empty($query))
	{
		return;
	}

	$totalitems = $db->query("SELECT DISTINCT COUNT(*)
		FROM $db_tag_references AS r LEFT JOIN $db_market AS m
			ON r.tag_item = m.item_id
		WHERE r.tag_area = 'market' AND ($query) AND m.item_state = 0")->fetchColumn();
	switch($o)
	{
		case 'title':
			$order = 'ORDER BY `item_title`';
		break;
		case 'date':
			$order = 'ORDER BY `item_date` DESC';
		break;
		case 'category':
			$order = 'ORDER BY `item_cat`';
		break;
		default:
			$order = '';
	}


	/* == Hook == */
	foreach (cot_getextplugins('tags.search.market.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql = $db->query("SELECT DISTINCT m.* $join_columns
		FROM $db_tag_references AS r LEFT JOIN $db_market AS m
			ON r.tag_item = m.item_id $join_tables
		WHERE r.tag_area = 'market' AND ($query) AND m.item_id IS NOT NULL AND m.item_state = 0 $join_where
		$order
		LIMIT $d, {$cfg['maxrowsperpage']}");
	$t->assign('TAGS_RESULT_TITLE', $L['tags_Found_in_market']);
	$pcount = $sql->rowCount();

	/* == Hook : Part 1 == */
	$extp = cot_getextplugins('tags.search.market.loop');
	/* ===== */

	if ($pcount > 0)
	{
		foreach ($sql->fetchAll() as $row)
		{
			$tags = cot_tag_list($row['item_id'],'market');
			$tag_list = '';
			$tag_i = 0;
			foreach ($tags as $tag)
			{
				$tag_t = $cfg['plugin']['tags']['title'] ? cot_tag_title($tag) : $tag;
				$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
				$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
				if ($tag_i > 0) $tag_list .= ', ';
				$tag_list .= cot_rc_link(cot_url('plug', array('e' => 'tags', 'a' => 'market', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)), htmlspecialchars($tag_t));
				$tag_i++;
			}

			$t->assign(cot_generate_markettags($row, 'TAGS_RESULT_ROW_'));
			$t->assign(array(
				//'TAGS_RESULT_ROW_URL' => empty($row['page_alias']) ? cot_url('page', 'c='.$row['page_cat'].'&id='.$row['page_id']) : cot_url('page', 'c='.$row['page_cat'].'&al='.$row['page_alias']),
				'TAGS_RESULT_ROW_TITLE' => htmlspecialchars($row['item_title']),
				'TAGS_RESULT_ROW_PATH' => cot_breadcrumbs(cot_structure_buildpath('market', $row['item_cat']), false),
				'TAGS_RESULT_ROW_TAGS' => $tag_list
			));
			/* == Hook : Part 2 == */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */
			$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_ROW');
		}
		$sql->closeCursor();
		$qs_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($qs) : $qs;
		$tl = $lang != 'en' && $qs_u != $qs ? 1 : null;
		$pagenav = cot_pagenav('plug', array('e' => 'tags', 'a' => 'market', 't' => $qs_u, 'tl' => $tl), $d, $totalitems, $cfg['maxrowsperpage']);
		$t->assign(array(
			'TAGS_PAGEPREV' => $pagenav['prev'],
			'TAGS_PAGENEXT' => $pagenav['next'],
			'TAGS_PAGNAV' => $pagenav['main']
		));

		/* == Hook == */
		foreach (cot_getextplugins('tags.search.market.tags') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

	if($pcount == 0)
	{
		$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_NONE');
	}

	$t->parse('MAIN.TAGS_RESULT');
}
function cot_tag_search_projects($query)
{
	global $db, $t, $L, $lang, $cfg, $usr, $qs, $d, $db_tag_references, $db_projects, $o, $row, $sys;

	if (!cot_module_active('projects'))
	{
		return;
	}

	$query = cot_tag_parse_query($query, 'p.item_id');
	if (empty($query))
	{
		return;
	}

	$totalitems = $db->query("SELECT DISTINCT COUNT(*)
		FROM $db_tag_references AS r LEFT JOIN $db_projects AS p
			ON r.tag_item = p.item_id
		WHERE r.tag_area = 'projects' AND ($query) AND p.item_state = 0")->fetchColumn();
	switch($o)
	{
		case 'title':
			$order = 'ORDER BY `item_title`';
		break;
		case 'date':
			$order = 'ORDER BY `item_date` DESC';
		break;
		case 'category':
			$order = 'ORDER BY `item_cat`';
		break;
		default:
			$order = '';
	}


	/* == Hook == */
	foreach (cot_getextplugins('tags.search.projects.query') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$sql = $db->query("SELECT DISTINCT p.* $join_columns
		FROM $db_tag_references AS r LEFT JOIN $db_projects AS p
			ON r.tag_item = p.item_id $join_tables
		WHERE r.tag_area = 'projects' AND ($query) AND p.item_id IS NOT NULL AND p.item_state = 0 $join_where
		$order
		LIMIT $d, {$cfg['maxrowsperpage']}");
	$t->assign('TAGS_RESULT_TITLE', $L['tags_Found_in_projects']);
	$pcount = $sql->rowCount();

	/* == Hook : Part 1 == */
	$extp = cot_getextplugins('tags.search.projects.loop');
	/* ===== */

	if ($pcount > 0)
	{
		foreach ($sql->fetchAll() as $row)
		{
			$tags = cot_tag_list($row['item_id'],'projects');
			$tag_list = '';
			$tag_i = 0;
			foreach ($tags as $tag)
			{
				$tag_t = $cfg['plugin']['tags']['title'] ? cot_tag_title($tag) : $tag;
				$tag_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($tag) : $tag;
				$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
				if ($tag_i > 0) $tag_list .= ', ';
				$tag_list .= cot_rc_link(cot_url('plug', array('e' => 'tags', 'a' => 'projects', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)), htmlspecialchars($tag_t));
				$tag_i++;
			}

			$t->assign(cot_generate_projecttags($row, 'TAGS_RESULT_ROW_'));
			$t->assign(array(
				//'TAGS_RESULT_ROW_URL' => empty($row['page_alias']) ? cot_url('page', 'c='.$row['page_cat'].'&id='.$row['page_id']) : cot_url('page', 'c='.$row['page_cat'].'&al='.$row['page_alias']),
				'TAGS_RESULT_ROW_TITLE' => htmlspecialchars($row['item_title']),
				'TAGS_RESULT_ROW_PATH' => cot_breadcrumbs(cot_structure_buildpath('projects', $row['item_cat']), false),
				'TAGS_RESULT_ROW_TAGS' => $tag_list
			));
			/* == Hook : Part 2 == */
			foreach ($extp as $pl)
			{
				include $pl;
			}
			/* ===== */
			$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_ROW');
		}
		$sql->closeCursor();
		$qs_u = $cfg['plugin']['tags']['translit'] ? cot_translit_encode($qs) : $qs;
		$tl = $lang != 'en' && $qs_u != $qs ? 1 : null;
		$pagenav = cot_pagenav('plug', array('e' => 'tags', 'a' => 'projects', 't' => $qs_u, 'tl' => $tl), $d, $totalitems, $cfg['maxrowsperpage']);
		$t->assign(array(
			'TAGS_PAGEPREV' => $pagenav['prev'],
			'TAGS_PAGENEXT' => $pagenav['next'],
			'TAGS_PAGNAV' => $pagenav['main']
		));

		/* == Hook == */
		foreach (cot_getextplugins('tags.search.projects.tags') as $pl)
		{
			include $pl;
		}
		/* ===== */
	}

	if($pcount == 0)
	{
		$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_NONE');
	}

	$t->parse('MAIN.TAGS_RESULT');
}

?>