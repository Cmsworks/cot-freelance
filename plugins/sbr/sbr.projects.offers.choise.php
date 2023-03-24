<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.choise
 * [END_COT_EXT]
 */

/**
 * Sbr plugin
 *
 * @package sbr
 * @version 1.0.3
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('sbr', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

if($offers['item_choise'] != 'refuse')
{
	$t_o->assign(array(
		"OFFER_ROW_SBRCREATELINK" => cot_url('sbr', 'm=add&pid=' . $id . '&uid=' . $offer['offer_userid'] . '&' . cot_xg()),
	));
}

?>