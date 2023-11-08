<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.query, market.index.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paymarkettop', 'plug');

$ordertop['top'] = 'item_top DESC';

$order = $ordertop + $order;