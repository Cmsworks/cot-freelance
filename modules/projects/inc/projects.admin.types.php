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

$adminpath[] = array(cot_url('admin', 'm=' . $m . '&p=' . $p), $L['projects_types_edit']);

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$a = cot_import('a', 'G', 'TXT');
$id = cot_import('id', 'G', 'INT');

if ($a == 'delete')
{
	$db->delete($db_projects_types, "type_id=" . (int)$id);
	
	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=projects&p=types&d=' . $d_url, '#footer', true));
	exit;
}
if ($a == 'add')
{
	$rinput = array();
	$rinput['type_title'] = cot_import('rtitle', 'P', 'TXT');
	$rdefault = cot_import('rdefault', 'P', 'BOL');
	if (!empty($rinput['type_title']))
	{
		$db->insert($db_projects_types, $rinput);
		$id = $db->lastInsertId();
		
		if($rdefault)
		{
			$db->update($db_config, array('config_value' => $id), "config_name = ? 
				AND config_cat = ?", array('default_type', 'projects'));
		}
	}
	
	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=projects&p=types', '#footer', true));
	exit;
}
elseif ($a == 'edit')
{
	$rtitles = cot_import('rtitle', 'P', 'ARR');
	$rdefault = cot_import('rdefault', 'P', 'INT');
	foreach ($rtitles as $rid => $rtitle)
	{
		$rinput = array();
		$rinput['type_title'] = cot_import($rtitle, 'D', 'TXT');
		if (!empty($rinput['type_title']))
		{
			$db->update($db_projects_types, $rinput, "type_id=" . (int)$rid);
		}
		else
		{
			$db->delete($db_projects_types, "type_id=" . (int)$rid);
		}
	}
	
	if(!empty($rdefault))
	{
		$db->update($db_config, array('config_value' => $rdefault), "config_name = ? 
			AND config_cat = ?", array('default_type', 'projects'));
	}
	
	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=projects&p=types&d=' . $d_url, '#footer', true));
	exit;
}

$totalitems = $db->query("SELECT COUNT(*) FROM $db_projects_types")->fetchColumn();
$sql = $db->query("SELECT * FROM $db_projects_types ORDER by type_title ASC LIMIT $d, " . $cfg['maxrowsperpage']);
$pagenav = cot_pagenav('admin', 'm=projects&p=types', $d, $totalitems, $cfg['maxrowsperpage']);

$t = new XTemplate(cot_tplfile('projects.admin.types', 'module'));

$jj = 0;
while ($item = $sql->fetch())
{
	$jj++;

	$t->assign(array(
		'TYPE_ROW_ID' => cot_inputbox('text', 'rtitle[' . $item['type_id'] . ']', $item['type_title']),
		'TYPE_ROW_TITLE' => cot_inputbox('text', 'rtitle[' . $item['type_id'] . ']', $item['type_title']),
		'TYPE_ROW_DEFAULT' => cot_radiobox($cfg['projects']['default_type'], 'rdefault', $item['type_id']),
		'TYPE_ROW_DEL_URL' => cot_url('admin', 'm=projects&p=types&id=' . $item['type_id'] . '&a=delete'),
		'TYPE_ROW_NUM' => $jj,
		'TYPE_ROW_ODDEVEN' => cot_build_oddeven($jj)
	));

	$t->parse("MAIN.ROWS");
}
if ($jj == 0)
{
	$t->parse("MAIN.NOROWS");
}
$t->assign(array(
	"EDITFORM_ACTION_URL" => cot_url('admin', 'm=projects&p=types&a=edit&d=' . $d_url),
	"ADDFORM_ACTION_URL" => cot_url('admin', 'm=projects&p=types&a=add'),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"ADDFORM_TITLE" => cot_inputbox('text', 'rtitle', ''),
	"ADDFORM_DEFAULT" => cot_inputbox('checkbox', 'rdefault', 1)
));
$t->parse("MAIN.ADDFORM");
$t->parse("MAIN");
$adminmain = $t->text("MAIN");
