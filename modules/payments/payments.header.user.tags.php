<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=header.user.tags
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
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payments', 'module');

if ($cfg['payments']['balance_enabled'])
{
	$t->assign(array(
		'HEADER_USER_BALANCE' => cot_payments_getuserbalance($usr['id']),
		'HEADER_USER_BALANCE_URL' => cot_url('payments', 'm=balance'),
	));
}
?>