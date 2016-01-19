<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=input
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$sql_config = $db->query("SELECT * FROM $db_config");
while ($row = $sql_config->fetch())
{
	if ($row['config_cat'] == 'usercategories')
	{
		if (empty($row['config_subcat']))
		{
			$cfg[$row['config_cat']][$row['config_name']] = $row['config_value'];
		}
		else
		{
			$cfg[$row['config_cat']]['cat_' . $row['config_subcat']][$row['config_name']] = $row['config_value'];
		}
	}
}
$sql_config->closeCursor();

$cot_modules['usercategories'] = array(
	'code' => 'usercategories',
	'title' => 'User Categories',
	'version' => '2.5.4'
);