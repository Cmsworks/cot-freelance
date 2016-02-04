<?php

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$id = cot_import('id', 'G', 'INT');

cot_block($id);

if ($a == 'del')
{
	$cid = cot_import('cid', 'G', 'INT');
	$db->delete($db_ls_cities, "city_id=" . (int)$cid);
	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id, '', true));
	exit;
}

if ($a == 'add')
{
	$rnames = cot_import('rname', 'P', 'TXT');
	$rnames = str_replace("\r\n", "\n", $rnames);
	$rnames = explode("\n", $rnames);

	if (count($rnames) > 0)
	{

		$region = $db->query("SELECT * FROM $db_ls_regions WHERE region_id=" . $id . "")->fetch();
		foreach ($rnames as $rname)
		{
			if (!empty($rname))
			{
				$rinput = array();
				$rinput['city_name'] = cot_import($rname, 'D', 'TXT');
				$rinput['city_region'] = (int)$id;
				$rinput['city_country'] = $region['region_country'];
				$db->insert($db_ls_cities, $rinput);
			}
		}

		$cache && $cache->clear();
		cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id, '', true));
		exit;
	}
}

if ($a == 'edit')
{
	$rnames = cot_import('rname', 'P', 'ARR');

	foreach ($rnames as $rid => $rname)
	{
		$rinput = array();
		$rinput['city_name'] = cot_import($rname, 'D', 'TXT');
		if(!empty($rinput['city_name']))
		{
			$db->update($db_ls_cities, $rinput, "city_id=".(int)$rid);
		}
		else
		{
			$db->delete($db_ls_cities, "city_id=".(int)$rid);
		}
	}

	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id, '', true));
	exit;	
}

$t = new XTemplate(cot_tplfile('locationselector.city', 'plug', true));

$totalitems = $db->query("SELECT COUNT(*) FROM $db_ls_cities WHERE city_region=" . $id)->fetchColumn();
$sql = $db->query("SELECT * FROM $db_ls_cities WHERE city_region=" . $id . " ORDER by city_name ASC LIMIT $d, " . $cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', "m=other&p=locationselector&n=city&id=" . $id, $d, $totalitems, $cfg['maxrowsperpage']);

$region = $db->query("SELECT * FROM $db_ls_regions WHERE region_id=" . (int)$id)->fetch();

$jj = 0;
while ($item = $sql->fetch())
{
	$jj++;

	$t->assign(array(
		"CITY_ROW_NAME" => cot_inputbox('text', 'rname[' . $item['city_id'] . ']', $item['city_name']),
		"CITY_ROW_DEL_URL" => cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id . '&a=del&cid=' . $item['city_id']),
	));

	$t->parse("MAIN.ROWS");
}
if ($jj == 0)
{
	$t->parse("MAIN.NOROWS");
}

$t->assign(array(
	"ADD_FORM_NAME" => cot_textarea('rname', '', 10, 60),
	"ADD_FORM_ACTION_URL" => cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id . '&a=add', '', true),
	"ADD_FORM_TITLE" => $title,
));
$t->parse("MAIN.ADDFORM");

$t->assign(array(
	"EDIT_FORM_ACTION_URL" => cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $id . '&a=edit&d=' . $d_url, '', true),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"COUNTRY_NAME" => $cot_countries[$region['region_country']],
	"REGION_NAME" => $region['region_name']
));

$adminpath[] = array(cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $region['region_country']), 
	$cot_countries[$region['region_country']]);
$adminpath[] = array(cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $region['region_name']), $region['region_name']);
$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");
?>
