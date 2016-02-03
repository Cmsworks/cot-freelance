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

$country = cot_import('country', 'G', 'TXT');

/* @var $db CotDB */
/* @var $cache Cache */
/* @var $t Xtemplate */

if ($a == 'del')
{
	$rid = cot_import('rid', 'G', 'INT');
	$db->delete($db_ls_regions, "region_id=" . (int)$rid);
	$db->delete($db_ls_cities, "city_region=" . (int)$rid);

	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&d=' . $d_url, '', true));
	exit;
}

if ($a == 'add')
{
	$rinput['region_name'] = cot_import('rname', 'P', 'TXT');
	$rinput['region_country'] = $country;

	if (!empty($rinput['region_name']))
	{
		$db->insert($db_ls_regions, $rinput);
		$cache && $cache->clear();
		cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&d=' . $d_url, '', true));
		exit;
	}
}

if ($a == 'edit')
{
	$rnames = cot_import('rname', 'P', 'ARR');

	foreach ($rnames as $rid => $rname)
	{
		$rinput = array();
		$rinput['region_name'] = cot_import($rname, 'D', 'TXT');
		if (!empty($rinput['region_name']))
		{
			$db->update($db_ls_regions, $rinput, "region_id=" . (int)$rid);
		}
		else
		{
			$db->delete($db_ls_regions, "region_id=" . (int)$rid);
			$db->delete($db_ls_cities, "city_region=" . (int)$rid);
		}
	}
	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&d=' . $d_url, '', true));
	exit;
}

$t = new XTemplate(cot_tplfile('locationselector.region', 'plug', true));

$totalitems = $db->query("SELECT COUNT(*) FROM $db_ls_regions WHERE region_country='" . $db->prep($country)."'")->fetchColumn();
$sql = $db->query("SELECT * FROM $db_ls_regions WHERE region_country='" . $db->prep($country) . "' ORDER by region_name ASC LIMIT $d, " . $cfg['maxrowsperpage']);

$pagenav = cot_pagenav('admin', "m=other&p=locationselector&n=region&country=" . $country, $d, $totalitems, $cfg['maxrowsperpage']);

$jj = 0;
while ($item = $sql->fetch())
{
	$jj++;

	$t->assign(array(
		"REGION_ROW_NAME" => cot_inputbox('text', 'rname[' . $item['region_id'] . ']', $item['region_name']),
		"REGION_ROW_URL" => cot_url('admin', 'm=other&p=locationselector&n=city&id=' . $item['region_id']),
		"REGION_ROW_DEL_URL" => cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&a=del&rid=' . $item['region_id']),
		"REGION_ROW_NUM" => $jj,
		"REGION_ROW_ODDEVEN" => cot_build_oddeven($jj)
	));

	$t->parse("MAIN.ROWS");
}
if ($jj == 0)
{
	$t->parse("MAIN.NOROWS");
}

$t->assign(array(
	"ADD_FORM_ACTION_URL" => cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&a=add'),
	"ADD_FORM_NAME" => cot_inputbox('text', 'rname', ''),
));
$t->parse("MAIN.ADDFORM");

$t->assign(array(
	"EDIT_FORM_ACTION_URL" => cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country . '&a=edit&d=' . $d_url),
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"COUNTRY_NAME" => $cot_countries[$country],
));

$adminpath[] = array(cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $country), $cot_countries[$country]);

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");
?>
