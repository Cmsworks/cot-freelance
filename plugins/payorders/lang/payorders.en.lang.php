<?php
/**
 * payorders plugin
 *
 * @package payorders
 * @version 1.0.0
 * @author Bulat Yusupov
 * @copyright Copyright (c) CMSWorks Team 2015
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */

$L['info_desc'] = 'Выставление счетов';

$L['payorders_buy_title'] = 'Оплата счета';

$L['payorders_date_create'] = 'Дата выставления';
$L['payorders_date_paid'] = 'Дата оплаты';
$L['payorders_status'] = 'Статус';

$L['payorders_cost'] = 'Стоимость';
$L['payorders_buy'] = 'Оплатить';

$L['payorders_neworder_title'] = 'Выставить счет';


$L['payorders_email_neworderinfo_subject'] = 'Счет на оплату';
$L['payorders_email_neworderinfo_body'] = 'Здравствуйте, %1$s!

Вам был выставлен счет на оплату №%2$s (%3$s). 
Вы можете оплатить его на нашем сайте %4$s.

Спасибо!

';




$L['payorders_email_orderinfo_subject'] = 'Информация об оплате';
$L['payorders_email_orderinfo_body'] = 'Здравствуйте, %1$s,

Оплата прошла успешно!.

Подробная информация:

Наименование услуги: %2$s
Стоимость: %3$s руб.
Номер заказа: %4$s
Дата оплаты: %5$s.

';

$L['payorders_email_orderinfo_admin_subject'] = 'Информация об оплате';
$L['payorders_email_orderinfo_admin_body'] = 'Здравствуйте,

Пользователь %1$s произвел оплату услуги на сайте.

Подробная информация:

Наименование услуги: %2$s
Стоимость: %3$s руб.
Номер заказа: %4$s
Дата оплаты: %5$s.

';