<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('marketorders', 'plug');
require_once cot_incfile('market', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('extrafields');

// Mode choice
if (!in_array($m, array('sales', 'purchases', 'addclaim', 'pay')))
{
	if (isset($_GET['id']))
	{
		$m = 'order';
	}
	else
	{
		$m = 'neworder';
	}
}

require_once cot_incfile('marketorders', 'plug', $m);

?>
