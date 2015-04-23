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

require_once cot_incfile('projects', 'module');

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$type = cot_import('type', 'G', 'INT');
$c = cot_import('c', 'G', 'ALP');
$state = cot_import('state', 'G', 'INT');
$id = cot_import('id', 'G', 'INT');
$ajax = cot_import('ajax', 'G', 'INT');
$ajax = empty($ajax) ? 0 : (int)$ajax;

$sq = cot_import('sq', 'G', 'TXT');

$mass_act = cot_import('prj_action', 'P', 'TXT');
$prj_arr = cot_import('prj_arr', 'P', 'ARR');
/* === Hook === */
foreach (cot_getextplugins('projects.admin.list.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'validate')
{

	/* === Hook === */
    foreach (cot_getextplugins('projects.admin.validate.first') as $pl)
    {
        include $pl;
    }
    /* ===== */
	
	$sql = $db->query("SELECT * FROM $db_projects AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE item_id='$id' LIMIT 1");
	cot_die($sql->rowCount() == 0);
	$item = $sql->fetch();

	$db->update($db_projects, array('item_state' => 0), "item_id=?", array($id));

	cot_projects_sync($item['item_cat']);

	$rbody = cot_rc($L['project_added_mail_body'], array(
		'user_name' => $item['user_name'],
		'prj_name' => $item['item_title'],
		'sitename' => $cfg['maintitle'],
		'link' => COT_ABSOLUTE_URL.cot_url('projects', 'id='.$id, '', true)
	));
	cot_mail($item['user_email'], $L['project_added_mail_subj'], $rbody);

	/* === Hook === */
    foreach (cot_getextplugins('projects.admin.validate.done') as $pl)
    {
        include $pl;
    }
    /* ===== */
	
	cot_redirect(cot_url('admin', 'm=projects&p=default'));
}

if ($a == 'delete')
{

	cot_projects_delete($id);
}

if(count($prj_arr)>0 && in_array($mass_act,array('delete','validate'))){
		switch ($mass_act) {
			case 'delete':
				foreach ($prj_arr as $prj_id) {
					cot_projects_delete($prj_id);
				}		
				cot_redirect(cot_url('admin', 'm=projects&p=default','',true));
				break;
			case 'validate':
						/* === Hook === */
						$extpl = cot_getextplugins('projects.admin.multiple.validate.first');
						$extpl1 = cot_getextplugins('projects.admin.multiple.validate.done');
						/* ===== */

						foreach ($prj_arr as $prj_id) {									
							 		/* === Hook: Part 1 === */
							 	    foreach ($extpl as $pl)
							 	    {
							 	        include $pl;
							 	    }
							 	    /* ===== */							 		
							 		$sql = $db->query("SELECT * FROM $db_projects AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid WHERE item_id='$prj_id' LIMIT 1");
							 		cot_die($sql->rowCount() == 0);
							 		$item = $sql->fetch();

							 		$db->update($db_projects, array('item_state' => 0), "item_id=?", array($prj_id));

							 		cot_projects_sync($item['item_cat']);

							 		$rbody = cot_rc($L['project_added_mail_body'], array(
							 			'user_name' => $item['user_name'],
							 			'prj_name' => $item['item_title'],
							 			'sitename' => $cfg['maintitle'],
							 			'link' => COT_ABSOLUTE_URL.cot_url('projects', 'id='.$prj_id, '', true)
							 		));
							 		cot_mail($item['user_email'], $L['project_added_mail_subj'], $rbody);

							 		/* === Hook: Part 2 === */
							 	    foreach ($extpl1 as $pl)
							 	    {
							 	        include $pl;
							 	    }
							 	    /* ===== */
					 	    }
					 	cot_redirect(cot_url('admin', 'm=projects&p=default','',true));		
				break;
			
			default:
				cot_redirect(cot_url('admin', 'm=projects&p=default','',true));
				break;
		}
}

$t = new XTemplate(cot_tplfile('projects.admin.default', 'module'));

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
	$catsub = cot_structure_children('market', $c);
	$where['cat'] = "item_cat IN ('".implode("','", $catsub)."')";
}

if (!empty($type))
{
	$where['type'] .= "item_type=".$type."";
}

if (!empty($sq))
{
	$words = explode(' ', $sq);
	$sqlsearch = '%'.implode('%', $words).'%';

	$where['search'] = "(item_title LIKE '".$db->prep($sqlsearch)."' OR item_text LIKE '".$db->prep($sqlsearch)."')";
}

$list_url_path = array('m' => 'projects', 'c' => $c, 'type'=> $type, 'sort' => $sort, 'sq' => $sq);

/* === Hook === */
foreach (cot_getextplugins('projects.admin.list.query') as $pl)
{
	include $pl;
}
/* ===== */

$where = ($where) ? 'WHERE '.implode(' AND ', $where) : '';
$order = ($order) ? 'ORDER BY '.implode(', ', $order) : '';

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projects 
	".$where."")->fetchColumn();

$sqllist = $db->query("SELECT * FROM $db_projects AS p LEFT JOIN $db_users AS u ON u.user_id=p.item_userid
	".$where." 
	".$order." 
	LIMIT $d, ".$cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', $list_url_path, $d, $totalitems, $cfg['maxrowsperpage']);

if (is_array($projects_types))
{
	foreach ($projects_types as $i => $pr_type)
	{
		$t->assign(array(
			"TYPE_ROW_TITLE" => $pr_type,
			"TYPE_ROW_URL" => cot_url('admin', 'm=projects&c='.$c.'&type='.$i),
			"TYPE_ROW_ACT" => ($type == $i) ? 'act' : ''
		));
		$t->parse("MAIN.TYPES.TYPES_ROWS");
	}
}

$t->assign(array(
	'TYPE_ALL_URL' => cot_url('admin', 'm=projects&c='.$c),
	'TYPE_ALL_ACT' => (empty($type)) ? 'act' : ''
));

$t->parse('MAIN.TYPES');

$t->assign(array(
	"SEARCH_ACTION_URL" => cot_url('admin', "m=projects&c=".$c."&type=".$type, '', true),
	"SEARCH_SQ" => cot_inputbox('text', 'sq', $sq, 'class="schstring"'),
	"SEARCH_STATE" => cot_radiobox($state, 'state', array(0, 1, 2), array('опубликованные', 'скрытые', 'на проверке')),
	"SEARCH_CAT" => cot_projects_selectcat($c, 'c'),
	"SEARCH_SORTER" => cot_selectbox($sort, "sort", array('', 'costasc', 'costdesc'), array($L['projects_mostrelevant'], $L['projects_costasc'], $L['projects_costdesc']), false),
	'TYPES_EDIT' => cot_url('admin', 'm=projects&p=types'),
	'PAGENAV_PAGES' => $pagenav['main'],
	'PAGENAV_PREV' => $pagenav['prev'],
	'PAGENAV_NEXT' => $pagenav['next'],
	'CATALOG' => cot_build_structure_projects_tree('', array($c)),
	'CATTITLE' => (!empty($c)) ? ' / '.(!empty($c)) ? ' / '.htmlspecialchars($structure['projects'][$c]['title']) : ''  : ''
));

$sqllist_rowset = $sqllist->fetchAll();
$sqllist_idset = array();
foreach ($sqllist_rowset as $item)
{
	$sqllist_idset[$item['item_id']] = $item['item_alias'];
}

/* === Hook === */
$extp = cot_getextplugins('projects.admin.list.loop');
/* ===== */

foreach ($sqllist_rowset as $item)
{
	$jj++;

	$t->assign(cot_generate_usertags($item, 'PRJ_ROW_OWNER_'));
	$t->assign(cot_generate_projecttags($item, 'PRJ_ROW_', $cfg['projects']['shorttextlen'], $usr['isadmin'], $cfg['homebreadcrumb']));

	$t->assign(array(
		'PRJ_ROW_ODDEVEN' => cot_build_oddeven($jj),
		'PRJ_ROW_EDIT_URL' => cot_url('projects', 'm=edit&id='.$item['item_id']),
		'PRJ_ROW_VALIDATE_URL' => cot_url('admin', 'm=projects&p=default&a=validate&id='.$item['item_id']),
		'PRJ_ROW_DELETE_URL' => cot_url('admin', 'm=projects&p=default&a=delete&id='.$item['item_id'])
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->parse("MAIN.PRJ_ROWS");
}

/* === Hook === */
$extp = cot_getextplugins('projects.admin.list.tags');
foreach ($extp as $pl)
{
	include $pl;
}
/* ===== */

$t->parse("MAIN");
$adminmain = $t->text("MAIN");
