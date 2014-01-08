<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=module
 * [END_COT_EXT]
 */

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');

if (!in_array($m, array('add', 'edit', 'preview')))
{
	if (isset($_GET['id']) || isset($_GET['al']))
	{
		$m = 'main';
	}
	else
	{
		$m = 'list';
	}
}

require_once cot_incfile('market', 'module', $m);

require_once $cfg['system_dir'].'/header.php';
echo $module_body;
require_once $cfg['system_dir'].'/footer.php';
