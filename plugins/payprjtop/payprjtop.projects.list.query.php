<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.query, projects.index.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprjtop', 'plug');

$ordertop['top'] = 'item_top DESC';

$order = $ordertop + $order;