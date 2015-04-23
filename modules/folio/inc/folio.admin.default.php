<?php

/**
 * folio module
 *
 * @package folio
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('folio', 'module');

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$type = cot_import('type', 'G', 'INT');
$c = cot_import('c', 'G', 'ALP');
$state = cot_import('state', 'G', 'INT');
$id = cot_import('id', 'G', 'INT');
$ajax = cot_import('ajax', 'G', 'INT');
$ajax = empty($ajax) ? 0 : (int)$ajax;

$sq = cot_import('sq', 'G', 'TXT');

$mass_act = cot_import('prd_action', 'P', 'TXT');
$prd_arr = cot_import('prd_arr', 'P', 'ARR');
/* === Hook === */
foreach (cot_getextplugins('folio.admin.list.first') as $pl)
{
	include $pl;
}
/* ===== */

/* === Hook === */
$extpl = cot_getextplugins('folio.admin.validate.first');
$extpl1 = cot_getextplugins('folio.admin.validate.done');
/* ===== */
if ($a == 'validate')
{

	/* === Hook: Part 1 === */
	foreach ($extpl as $pl)
	{
	    include $pl;
	}
	/* ===== */	
	
	$sql = $db->query("SELECT * FROM $db_folio AS f LEFT JOIN $db_users AS u ON u.user_id=f.item_userid WHERE item_id='$id' LIMIT 1");
	cot_die($sql->rowCount() == 0);
	$item = $sql->fetch();

	$db->update($db_folio, array('item_state' => 0), "item_id=?", array($id));

	cot_folio_sync($item['item_cat']);

	$rbody = cot_rc($L['folio_added_mail_body'], array(
		'user_name' => $item['user_name'],
		'prd_name' => $item['item_title'],
		'sitename' => $cfg['maintitle'],
		'link' => COT_ABSOLUTE_URL.cot_url('folio', 'id='.$id, '', true)
	));
	cot_mail($item['user_email'], $L['folio_added_mail_subj'], $rbody);

	/* === Hook: Part 2 === */
	foreach ($extpl1 as $pl)
	{
	    include $pl;
	}
	/* ===== */

	cot_redirect(cot_url('admin', 'm=folio&p=default'));
}

if ($a == 'delete')
{
	cot_folio_delete($id);
}
if(count($prd_arr)>0 && in_array($mass_act,array('delete','validate'))){
		switch ($mass_act) {
			case 'delete':
				foreach ($prd_arr as $prd_id) {
					cot_folio_delete($prd_id);
				}		
				cot_redirect(cot_url('admin', 'm=folio&p=default','',true));
				break;
			case 'validate':
						foreach ($prd_arr as $prd_id) {									
							 		/* === Hook: Part 1 === */
							 	    foreach ($extpl as $pl)
							 	    {
							 	        include $pl;
							 	    }
							 	    /* ===== */							 		
									 $sql = $db->query("SELECT * FROM $db_folio AS f LEFT JOIN $db_users AS u ON u.user_id=f.item_userid WHERE item_id='$prd_id' LIMIT 1");
									 cot_die($sql->rowCount() == 0);
									 $item = $sql->fetch();

									 $db->update($db_folio, array('item_state' => 0), "item_id=?", array($prd_id));

									 cot_folio_sync($item['item_cat']);

									 $rbody = cot_rc($L['folio_added_mail_body'], array(
									 	'user_name' => $item['user_name'],
									 	'prd_name' => $item['item_title'],
									 	'sitename' => $cfg['maintitle'],
									 	'link' => COT_ABSOLUTE_URL.cot_url('folio', 'id='.$prd_id, '', true)
									 ));
									 cot_mail($item['user_email'], $L['folio_added_mail_subj'], $rbody);
							 
							 		/* === Hook: Part 2 === */
							 	    foreach ($extpl1 as $pl)
							 	    {
							 	        include $pl;
							 	    }
							 	    /* ===== */
					 	    }
					 	cot_redirect(cot_url('admin', 'm=folio&p=default','',true));		
				break;
			
			default:
				cot_redirect(cot_url('admin', 'm=folio&p=default','',true));
				break;
		}
}

$t = new XTemplate(cot_tplfile('folio.admin.default', 'module'));

$where = array();

if (!empty($state))
{
	$where['state'] = "item_state=".$state;
}
else
{
	$where['state'] = "item_state=0";
}

if (!empty($c))
{
	$catsub = cot_structure_children('folio', $c);
	$where['cat'] = "item_cat IN ('".implode("','", $catsub)."')";
}

if (!empty($sq))
{
	$words = explode(' ', $sq);
	$sqlsearch = '%'.implode('%', $words).'%';

	$where['search'] = "(item_title LIKE '".$db->prep($sqlsearch)."' OR item_text LIKE '".$db->prep($sqlsearch)."')";
}

$list_url_path = array('m' => 'folio', 'c' => $c, 'sort' => $sort, 'sq' => $sq);

$order['date'] = 'item_date DESC';

/* === Hook === */
foreach (cot_getextplugins('folio.admin.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE '.implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY '.implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_folio 
	".$where."")->fetchColumn();

$sqllist = $db->query("SELECT * FROM $db_folio AS m LEFT JOIN $db_users AS u ON u.user_id=m.item_userid
	".$where." 
	".$order." 
	LIMIT $d, ".$cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', $list_url_path, $d, $totalitems, $cfg['maxrowsperpage']);

$t->assign(array(
	"SEARCH_ACTION_URL" => cot_url('admin', "m=folio&c=".$c, '', true),
	"SEARCH_SQ" => cot_inputbox('text', 'sq', $sq, 'class="schstring"'),
	"SEARCH_STATE" => cot_radiobox($state, 'state', array(0, 1, 2), array('опубликованные', 'скрытые', 'на проверке')),
	"SEARCH_CAT" => cot_folio_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['folio_mostrelevant'], $L['folio_costasc'], $L['folio_costdesc']), false),
	'PAGENAV_PAGES' => $pagenav['main'],
	'PAGENAV_PREV' => $pagenav['prev'],
	'PAGENAV_NEXT' => $pagenav['next'],
	"PAGENAV_COUNT" => $totalitems,
	'CATALOG' => cot_build_structure_folio_tree('', array($c)),
	'CATTITLE' => (!empty($c)) ? ' / '.(!empty($c)) ? ' / '.htmlspecialchars($structure['folio'][$c]['title']) : ''  : ''
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach ($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('folio.admin.list.loop');
/* ===== */

foreach ($sqllist_rowset as $item)
{
	$jj++;

	$t->assign(cot_generate_usertags($item, 'PRD_ROW_OWNER_'));
	$t->assign(cot_generate_foliotags($item, 'PRD_ROW_', $cfg['folio']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

	$t->assign(array(
		'PRD_ROW_ODDEVEN' => cot_build_oddeven($jj),
		'PRD_ROW_EDIT_URL' => cot_url('folio', 'm=edit&id='.$item['item_id']),
		'PRD_ROW_VALIDATE_URL' => cot_url('admin', 'm=folio&p=default&a=validate&id='.$item['item_id']),
		'PRD_ROW_DELETE_URL' => cot_url('admin', 'm=folio&p=default&a=delete&id='.$item['item_id'])
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.PRD_ROWS");
}

/* === Hook === */
$extp = cot_getextplugins('folio.admin.list.tags');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$t->parse("MAIN");
$adminmain = $t->text("MAIN");
