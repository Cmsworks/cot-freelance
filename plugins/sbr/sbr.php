<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
 */

/**
 * Sbr plugin
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('sbr', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('extrafields');
require_once cot_incfile('uploads');
require_once cot_incfile('forms');

// Mode choice
if (!in_array($m, array('add', 'edit')))
{
	if (isset($_GET['id']))
	{
		$m = 'main';
	}
	else
	{
		$m = 'list';
	}
}

require_once cot_incfile('sbr', 'plug', $m);

?>