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
$L['cfg_cost'] = array('Стоимость за день размещения', '');

$L['payprjtop_buy_title'] = (isset($L['payprjtop_buy_title'])) ? $L['payprjtop_buy_title'] : 'Закрепить проект';
$L['payprjtop_buy_paydesc'] = (isset($L['payprjtop_buy_paydesc'])) ? $L['payprjtop_buy_paydesc'] : 'Услуга "Закрепленный проект"';
$L['payprjtop_costofday'] = (isset($L['payprjtop_costofday'])) ? $L['payprjtop_costofday'] : 'Стоимость за день';
$L['payprjtop_error_days'] = (isset($L['payprjtop_error_days'])) ? $L['payprjtop_error_days'] : 'Укажите срок действия услуги';

$L['payprjtop_buy'] = (isset($L['payprjtop_buy'])) ? $L['payprjtop_buy'] : 'Купить';
$L['payprjtop_day'] = (isset($L['payprjtop_day'])) ? $L['payprjtop_day'] : 'день';

$L['payprjtop_buy_prodlit'] = (isset($L['payprjtop_buy_prodlit'])) ? $L['payprjtop_buy_prodlit'] : "Закреплен до %1\$s. <a href=\"%2\$s\">Продлить</a>";

?>