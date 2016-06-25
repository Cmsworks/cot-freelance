<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=admin.config.edit.loop
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');
$adminhelp = $L['usercategories_help'];

if ($p == 'usercategories' && $row['config_name'] == 'catslimit' && $cfg['jquery'])
{
	$sskin = cot_tplfile('usercategories.admin.config', 'plug', true);
	$tt = new XTemplate($sskin);
	
	$tpaset = str_replace("\r\n", "\n", $row['config_value']);
	$tpaset = explode("\n", $tpaset);
	$jj = 0;
	foreach ($tpaset as $lineset)
	{
		$lines = explode("|", $lineset);
		$lines[0] = (int)trim($lines[0]);
		$lines[1] = (int)trim($lines[1]);
		$lines[2] = (int)trim($lines[2]);

		if ($lines[0] > 0)
		{
			$tt->assign(array(
				'ADDNUM' => $jj,
				'ADDGROUP' => cot_selectbox_groups($lines[0], 'groupid' . $jj, array(1,2,3,5,6), 'class="area_groupid"'),
				'ADDLIMIT1' => cot_inputbox('text', 'limit1', $lines[1], 'class="area_limit1"'),
				'ADDLIMIT2' => cot_inputbox('text', 'limit2', $lines[2], 'class="area_limit2"'),
			));
			$tt->parse('MAIN.ADDITIONAL');
			$jj++;
		}
	}
	
	if($jj == 0){
		$tt->assign(array(
			'ADDNUM' => $jj,
			'ADDGROUP' => cot_selectbox_groups('', 'groupid' . $jj, array(1,2,3,5,6), 'class="area_groupid"'),
			'ADDLIMIT1' => cot_inputbox('text', 'limit1', 0, 'class="area_limit1"'),
			'ADDLIMIT2' => cot_inputbox('text', 'limit2', 0, 'class="area_limit2"'),
		));
		$tt->parse('MAIN.ADDITIONAL');
	}

	$jj++;
	$tt->assign(array(
		'CATNUM' => $jj
	));
	$tt->parse('MAIN');

	$t->assign(array(
		'ADMIN_CONFIG_ROW_CONFIG_MORE' => $tt->text('MAIN') . '<div id="helptext">' . $config_more . '</div>'
	));
}

?>