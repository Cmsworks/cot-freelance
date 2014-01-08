<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');

$a = cot_import('a', 'G', 'ALP');
$id = cot_import('id', 'G', 'INT');

if ($a == 'delete' && (int)$id > 0)
{
	$db->delete($db_usercategories, "cat_id=" . (int)$id);
	cot_redirect(cot_url('admin', 'm=other&p=usercategories', '#footer', true));
}
elseif ($a == 'add')
{
	$ritem['cat_code'] = cot_import('rcode', 'P', 'ALP');
	$ritem['cat_path'] = cot_import('rpath', 'P', 'TXT');
	$ritem['cat_desc'] = cot_import('rdesc', 'P', 'TXT');
	$ritem['cat_title'] = cot_import('rtitle', 'P', 'TXT');

	$cat_exists = (bool)$db->query("SELECT cat_id FROM $db_usercategories WHERE cat_code = ? LIMIT 1", array($ritem['cat_code']))->fetch();
	if (!$cat_exists && !empty($ritem['cat_code']) && !empty($ritem['cat_path']) && !empty($ritem['cat_title']))
	{
		$db->insert($db_usercategories, $ritem);
		$cache && $cache->clear();
	}
	cot_redirect(cot_url('admin', 'm=other&p=usercategories', '#footer', true));
}
elseif ($a == 'update')
{
	$rcode = cot_import('rcode', 'P', 'ARR');
	$rpath = cot_import('rpath', 'P', 'ARR');
	$rdesc = cot_import('rdesc', 'P', 'ARR');
	$rtitle = cot_import('rtitle', 'P', 'ARR');

	foreach ($rtitle as $rid => $rtitl)
	{
		$ritem = array();
		$ritem['cat_code'] = cot_import($rcode[$rid], 'D', 'ALP');
		$ritem['cat_path'] = cot_import($rpath[$rid], 'D', 'TXT');
		$ritem['cat_desc'] = cot_import($rdesc[$rid], 'D', 'TXT');
		$ritem['cat_title'] = cot_import($rtitle[$rid], 'D', 'TXT');
		
		if (!empty($ritem['cat_code']) && !empty($ritem['cat_title']))
		{
			$cat_exists = (bool)$db->query("SELECT cat_id FROM $db_usercategories WHERE cat_id!= ? AND cat_code = ? LIMIT 1", array($rid, $ritem['cat_code']))->fetch();
			if(!$cat_exists)
			{
				$cat = $db->query("SELECT cat_code FROM $db_usercategories WHERE cat_id=" . $rid)->fetchColumn();
				if($cat != $ritem['cat_code'])
				{
					$db->update($db_usercategories_users, array('ucat_cat' => $ritem['cat_code']), "ucat_cat='" . $cat . "'");
				}
			
				$db->update($db_usercategories, $ritem, "cat_id=" . (int)$rid);
			}
		}
	}

	$cache && $cache->clear();
	cot_redirect(cot_url('admin', 'm=other&p=usercategories', '#footer', true));
}

$t = new XTemplate(cot_tplfile('usercategories.admin', 'plug'));

$sql = $db->query("SELECT * FROM $db_usercategories ORDER BY cat_path ASC");
$ii = 0;
while ($item = $sql->fetch())
{
	$ii++;
	$t->assign(array(
		"ROW_CODE" => cot_inputbox('text', 'rcode[' . $item['cat_id'] . ']', $item['cat_code'], 'size="14"'),
		"ROW_PATH" => cot_inputbox('text', 'rpath[' . $item['cat_id'] . ']', $item['cat_path'], 'size="14"'),
		"ROW_TITLE" => cot_inputbox('text', 'rtitle[' . $item['cat_id'] . ']', $item['cat_title'], 'size="56"'),
		"ROW_DESC" => cot_inputbox('text', 'rdesc[' . $item['cat_id'] . ']', $item['cat_desc'], 'size="56"'),
		"ROW_DELETE" => cot_url('admin', 'm=other&p=usercategories&a=delete&id=' . $item['cat_id'])
	));
	$t->parse('MAIN.ROWS');
}
if ($ii == 0)
{
	$t->parse('MAIN.NOROWS');
}

// Создание новой категории
$t->assign(array(
	"EDITFORM_ACTION_URL" => cot_url('admin', 'm=other&p=usercategories&a=update', '', true),
	"ADDFORM_ACTION_URL" => cot_url('admin', 'm=other&p=usercategories&a=add'),
	"ADDFORM_CODE" => cot_inputbox('text', 'rcode', $ritem['cat_code'], 'size="14"'),
	"ADDFORM_PATH" => cot_inputbox('text', 'rpath', $ritem['cat_path'], 'size="14"'),
	"ADDFORM_TITLE" => cot_inputbox('text', 'rtitle', $ritem['cat_title'], 'size="56"'),
	"ADDFORM_DESC" => cot_inputbox('text', 'rdesc', $ritem['cat_desc'], 'size="56"')
));

$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");
