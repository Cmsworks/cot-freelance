<?php

/**
 * projects module
 *
 * @package projects
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('projects', 'any', 'RWA');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');
$r = cot_import('r', 'G', 'ALP');

/* === Hook === */
foreach (cot_getextplugins('projects.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "item_alias='".$al."'" : 'item_id='.$id;
	$sql = $db->query("SELECT p.*, u.* FROM $db_projects AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE $where LIMIT 1");
}

if (!$id && empty($al) || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$item = $sql->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin'], $usr['auth_offers']) = cot_auth('projects', $item['item_cat'], 'RWA1');
cot_block($usr['auth_read']);

$id = $item['item_id'];

$title_params = array(
	'TITLE' => empty($item['item_metatitle']) ? $item['item_title'] : $item['item_metatitle'],
	'TYPE' => $projects_types[$item['item_type']],
	'CATEGORY' => $structure['projects'][$item['item_cat']]['title'],
);
$out['subtitle'] = cot_title($cfg['projects']['title_projects'], $title_params);

$out['desc'] = (!empty($item['item_metadesc'])) ? $item['item_metadesc'] : cot_cutstring(strip_tags(cot_parse($item['item_text'], $cfg['projects']['markup'], $item['item_parser'])), 160);
$out['meta_keywords'] = (!empty($item['item_keywords'])) ? $item['item_keywords'] : $structure['projects'][$item['item_cat']]['keywords'];

if ($item['item_state'] != 0 && !$usr['isadmin'] && $usr['id'] != $item['item_userid'])
{
	$userofferexists = (bool)$db->query("SELECT COUNT(*) FROM $db_projects_offers 
			WHERE offer_userid=" . $usr['id'] . " AND offer_pid=" . $item['item_id'])->fetchColumn();
	if(!$userofferexists)
	{
		cot_log("Attempt to directly access an un-validated", 'sec');
		cot_redirect(cot_url('message', "msg=930", '', true));
		exit;
	}
}

if ($usr['id'] != $item['item_userid'] && (!$usr['isadmin'] || $cfg['projects']['count_admin']))
{
	$item['item_count']++;
	$db->update($db_projects, array('item_count' => $item['item_count']), "item_id=" . (int)$item['item_id']);
}

// Building the canonical URL
$pageurl_params = array('c' => $item['item_cat']);
empty($al) ? $pageurl_params['id'] = $id : $pageurl_params['al'] = $al;
$out['canonical_uri'] = cot_url('projects', $pageurl_params);

$mskin = cot_tplfile(array('projects', $structure['projects'][$item['item_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('projects.main') as $pl)
{
	include $pl;
}
/* ===== */
$t = new XTemplate($mskin);

$t->assign(cot_generate_usertags($item, 'PRJ_OWNER_'));
$t->assign(cot_generate_projecttags($item, 'PRJ_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

if ($item['item_performer'] > 0)
{
	$t->assign(cot_generate_usertags($item['item_performer'], 'PRJ_PERFORMER_'));
}

require_once cot_incfile('projects', 'module', 'offers');

/* === Hook === */
foreach (cot_getextplugins('projects.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	$t->parse('MAIN.PRJ_ADMIN');
}

if ($usr['id'] == 0)
{
	$t->parse("MAIN.FORGUEST");
}

$t->parse('MAIN');
$module_body = $t->text('MAIN');