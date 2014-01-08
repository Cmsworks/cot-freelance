<?php
/**
 * Payprjtop plugin
 *
 * @package payprjtop
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_cost'] = array('Cost of day', '');

$L['payprjtop_buy_title'] = (isset($L['payprjtop_buy_title'])) ? $L['payprjtop_buy_title'] : 'Activate Top-project';
$L['payprjtop_buy_paydesc'] = (isset($L['payprjtop_buy_paydesc'])) ? $L['payprjtop_buy_paydesc'] : 'Top-project';
$L['payprjtop_costofday'] = (isset($L['payprjtop_costofday'])) ? $L['payprjtop_costofday'] : 'Cost of day';
$L['payprjtop_error_days'] = (isset($L['payprjtop_error_days'])) ? $L['payprjtop_error_days'] : 'Period';

$L['payprjtop_buy'] = (isset($L['payprjtop_buy'])) ? $L['payprjtop_buy'] : 'Buy';
$L['payprjtop_day'] = (isset($L['payprjtop_day'])) ? $L['payprjtop_day'] : 'day';

$L['payprjtop_buy_prodlit'] = (isset($L['payprjtop_buy_prodlit'])) ? $L['payprjtop_buy_prodlit'] : "Top by %1\$s. <a href=\"%2\$s\">Extend</a>";

?>