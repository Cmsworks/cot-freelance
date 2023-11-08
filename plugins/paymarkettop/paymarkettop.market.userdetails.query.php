<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.userdetails.query
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paymarkettop', 'plug');

$orderby = 'item_top DESC, '.$orderby;