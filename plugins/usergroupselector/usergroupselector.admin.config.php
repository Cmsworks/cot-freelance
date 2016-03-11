<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.loop
[END_COT_EXT]
==================== */
/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('usergroupselector', 'plug');
$adminhelp = $L['usergroupselector_help'];

if ($p == 'usergroupselector' && $row['config_name'] == 'groups' && $cfg['jquery'])
{
	$sskin = cot_tplfile('usergroupselector.admin.config', 'plug', true);
	$tt = new XTemplate($sskin);

	$row['config_value'] = (!empty($row['config_value'])) ? $row['config_value'] : cot_import($row['config_name'], 'P', 'NOC');
	$tpaset = explode(",", $row['config_value']);

	$jj = 0;
	foreach ($tpaset as $k)
	{
		$tt->assign(array(
			'ADDNUM' => $jj,
			'ADDGROUP' => cot_selectbox_groups($k, 'group' . $jj, array(1,2,3,5,6))
		));
		$tt->parse('MAIN.ADDITIONAL');
		$jj++;
	}

	$jj++;
	$tt->assign(array(
		'CATNUM' => $jj
	));
	$tt->parse('MAIN');
	
	$t->assign(array(
		'ADMIN_CONFIG_ROW_CONFIG' => cot_config_input($row).$tt->text('MAIN'),
	));
}