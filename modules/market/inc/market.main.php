<?php

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', 'any', 'RWA');
cot_block($usr['auth_read']);

$id = cot_import('id', 'G', 'INT');
$al = $db->prep(cot_import('al', 'G', 'TXT'));
$c = cot_import('c', 'G', 'TXT');

/* === Hook === */
foreach (cot_getextplugins('market.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($id > 0 || !empty($al))
{
	$where = (!empty($al)) ? "item_alias='".$al."'" : 'item_id='.$id;
	$sql = $db->query("SELECT p.*, u.* FROM $db_market AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE $where LIMIT 1");
}

if (!$id && empty($al) || !$sql || $sql->rowCount() == 0)
{
	cot_die_message(404, TRUE);
}
$item = $sql->fetch();

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('market', $item['item_cat'], 'RWA');
cot_block($usr['auth_read']);

if ($item['item_state'] != 0 && !$usr['isadmin'] && $usr['id'] != $item['item_userid'])
{
	cot_log("Attempt to directly access an un-validated", 'sec');
	cot_redirect(cot_url('message', "msg=930", '', true));
	exit;
}

if ($usr['id'] != $item['item_userid'] && (!$usr['isadmin'] || $cfg['market']['count_admin']))
{
	$item['item_count']++;
	$db->update($db_market, array('item_count' => $item['item_count']), "item_id=" . (int)$item['item_id']);
}

$title_params = array(
	'TITLE' => empty($item['item_metatitle']) ? $item['item_title'] : $item['item_metatitle'],
	'CATEGORY' => $structure['market'][$item['item_cat']]['title'],
);
cot::$out['subtitle'] = cot_title(cot::$cfg['market']['title_market'], $title_params);

cot::$out['desc'] = (!empty($item['item_metadesc'])) ?
    $item['item_metadesc'] :
    cot_cutstring(strip_tags(cot_parse($item['item_text'], cot::$cfg['market']['markup'], $item['item_parser'])), 160);

if (!empty($item['item_keywords'])) {
    cot::$out['meta_keywords'] = $item['item_keywords'];
} elseif (
    !empty(cot::$structure['market'][$item['item_cat']]) &&
    !empty(cot::$structure['market'][$item['item_cat']]['keywords'])
) {
    cot::$out['meta_keywords'] = cot::$structure['market'][$item['item_cat']]['keywords'];
}

// Building the canonical URL
$pageurl_params = array('c' => $item['item_cat']);
empty($al) ? $pageurl_params['id'] = $id : $pageurl_params['al'] = $al;
$out['canonical_uri'] = cot_url('market', $pageurl_params);

$mskin = cot_tplfile(array('market', $structure['market'][$item['item_cat']]['tpl']));

/* === Hook === */
foreach (cot_getextplugins('market.main') as $pl)
{
	include $pl;
}
/* ===== */
$t = new XTemplate($mskin);

$t->assign(cot_generate_usertags($item, 'PRD_OWNER_'));
$t->assign(cot_generate_markettags($item, 'PRD_', $cfg['market']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

/* === Hook === */
foreach (cot_getextplugins('market.tags') as $pl)
{
	include $pl;
}
/* ===== */


if ($usr['isadmin'])
{
	$t->parse('MAIN.PRD_ADMIN');
}

$t->parse('MAIN');
$module_body = $t->text('MAIN');