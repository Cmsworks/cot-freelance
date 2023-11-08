<?php
/**
 * paymarkettop plugin
 *
 * @package paymarkettop
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_cost'] = array('Cost of day', '');

$L['paymarkettop_buy_title'] = (isset($L['paymarkettop_buy_title'])) ? $L['paymarkettop_buy_title'] : 'Activate Top-product';
$L['paymarkettop_buy_paydesc'] = (isset($L['paymarkettop_buy_paydesc'])) ? $L['paymarkettop_buy_paydesc'] : 'Top-product';
$L['paymarkettop_costofday'] = (isset($L['paymarkettop_costofday'])) ? $L['paymarkettop_costofday'] : 'Cost of day';
$L['paymarkettop_error_days'] = (isset($L['paymarkettop_error_days'])) ? $L['paymarkettop_error_days'] : 'Period';

$L['paymarkettop_buy'] = (isset($L['paymarkettop_buy'])) ? $L['paymarkettop_buy'] : 'Buy';
$L['paymarkettop_day'] = (isset($L['paymarkettop_day'])) ? $L['paymarkettop_day'] : 'day';

$L['paymarkettop_buy_prodlit'] = (isset($L['paymarkettop_buy_prodlit'])) ? $L['paymarkettop_buy_prodlit'] : "Top by %1\$s. <a href=\"%2\$s\">Extend</a>";