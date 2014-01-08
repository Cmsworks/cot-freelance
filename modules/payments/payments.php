<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=module
 * [END_COT_EXT]
 */
/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

if (!in_array($m, array('billing', 'balance', 'error')))
{
	$msg = 1;
	$m = 'error';
}

$out['subtitle'] = $L['payments_mybalance']; 


require_once cot_incfile('payments', 'module', $m);

require_once $cfg['system_dir'] . '/header.php';
echo $module_body;
require_once $cfg['system_dir'] . '/footer.php';
?>