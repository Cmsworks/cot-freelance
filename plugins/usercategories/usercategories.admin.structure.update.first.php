<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=admin.structure.update.first
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if (!empty($editconfig) && $n == 'usercategories')
{
	$optionslist = cot_config_list('plug', $n, $editconfig);

	foreach ($optionslist as $key => $val)
	{
		$data = cot_import($key, 'P', sizeof($cot_import_filters[$key]) ? $key : 'NOC');
		if ($optionslist[$key]['config_value'] != $data)
		{
			if (is_null($optionslist[$key]['config_subdefault']))
			{
				$optionslist[$key]['config_value'] = $data;
				$optionslist[$key]['config_subcat'] = $editconfig;
				$db->insert($db_config, $optionslist[$key]);
			}
			else
			{
				$db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
				AND config_cat = ?  AND config_subcat = ?)", array($key, $o, $p, $editconfig));
			}
		}
	}
}