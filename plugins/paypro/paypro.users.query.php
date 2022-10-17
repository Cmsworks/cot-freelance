<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.query
 * Order=1
 * [END_COT_EXT]
 */
/**
 * PayPro plugin
 *
 * @package paypro
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

if (!isset($join_columns)) {
    $join_columns = '';
}
$join_columns .= ', (user_pro > 0) as ispro';
$sqlorder = "ispro DESC";
