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
$L['cfg_cost'] = array('Стоимость за день размещения', '');

$L['paymarkettop_buy_title'] = (isset($L['paymarkettop_buy_title'])) ? $L['paymarkettop_buy_title'] : 'Закрепить товар';
$L['paymarkettop_buy_paydesc'] = (isset($L['paymarkettop_buy_paydesc'])) ? $L['paymarkettop_buy_paydesc'] : 'Услуга "Закрепленный товар"';
$L['paymarkettop_costofday'] = (isset($L['paymarkettop_costofday'])) ? $L['paymarkettop_costofday'] : 'Стоимость за день';
$L['paymarkettop_error_days'] = (isset($L['paymarkettop_error_days'])) ? $L['paymarkettop_error_days'] : 'Укажите срок действия услуги';

$L['paymarkettop_buy'] = (isset($L['paymarkettop_buy'])) ? $L['paymarkettop_buy'] : 'Купить';
$L['paymarkettop_day'] = (isset($L['paymarkettop_day'])) ? $L['paymarkettop_day'] : 'день';

$L['paymarkettop_buy_prodlit'] = (isset($L['paymarkettop_buy_prodlit'])) ? $L['paymarkettop_buy_prodlit'] : "Закреплен до %1\$s. <a href=\"%2\$s\">Продлить</a>";