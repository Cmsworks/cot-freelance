<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.config.edit.loop
  [END_COT_EXT]
  ==================== */

/**
 * news admin usability modification
 *
 * @package news
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2012
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page', 'module');
$adminhelp = $L['news_help'];

if ($p == 'mavatars' && $row['config_name'] == 'set' && $cfg['jquery'])
{
	$sskin = cot_tplfile('mavatars.admin', 'plug', true);
	$tt = new XTemplate($sskin);

	$tpaset = str_replace("\r\n", "\n", $row['config_value']);
	$tpaset = explode("\n", $tpaset);
	$jj = 0;
	foreach ($tpaset as $k => $v)
	{
		$v = explode('|', $v);
		$v = array_map('trim', $v);
		$jj++;
		$tt->assign(array(
			'ADDNUM' => $jj,
			'ADDMODULE' => $v[0],
			'ADDCATEGORY' => $v[1],
			'ADDPATH' => $v[2],
			'ADDTHUMBPATH' => $v[3],
			'ADDREQ' => $v[4],
			'ADDEXT' => $v[5],
			'ADDMAX' => $v[6],
		));
		$tt->parse('MAIN.ADDITIONAL');
	}

	$jj++;
	$tt->assign(array(
		'CATNUM' => $jj
	));
	$tt->parse('MAIN');

	$t->assign(array(
		'ADMIN_CONFIG_ROW_CONFIG_MORE' => $tt->text('MAIN') . '<div id="helptext">' . $hint . '</div>'
	));
}