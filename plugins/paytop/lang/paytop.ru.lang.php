<?php
/**
 * Paytop plugin
 *
 * @package paytop
 * @version 1.0.3
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_cost'] = array('Стоимость размещения', '');
$L['cfg_limit'] = array('Лимит на вывод пользователей на платном месте', '');

$L['info_desc'] = 'Рекламные места для пользователей';

$L['paytop_admin_config_area'] = 'Рекламный блок';
$L['paytop_admin_config_name'] = 'Название';
$L['paytop_admin_config_cost'] = 'Стоимость за период';
$L['paytop_admin_config_period'] = 'Период размещения';
$L['paytop_admin_config_count'] = 'Количество для вывода';

$L['paytop_buytop_title'] = 'Покупка рекламного места';
$L['paytop_buytop_paydesc'] = 'Покупка рекламного места';

$L['paytop_cost'] = 'Стоимость';
$L['paytop_buy'] = 'Купить';
$L['paytop_period'] = 'на срок';

$L['paytop_how'] = 'Как сюда попасть?';
$L['paytop_default_text'] = 'Место для рекламы';

$L['paytop_header_buy'] = 'Купить рекламное место';
$L['paytop_header_extend'] = 'Продлить услугу';

$L['paytop_error_username'] = 'Не указан логин пользователя';
$L['paytop_error_userempty'] = 'Такого пользователя не существует';
$L['paytop_error_timesempty'] = 'Срок действия услуги не указан';
$L['paytop_error_areaempty'] = 'Не указано рекламное место';
$L['paytop_area'] = 'рекламное место';

$L['paytop_addtopaccaunt'] = 'Добавление TOP-аккаунта для пользователя';

$L['paytop_month'] = 'месяц';
$L['paytop_week'] = 'неделя';
$L['paytop_day'] = 'день';
$L['paytop_hour'] = 'час';

$L['paytop_mail_admin_subject'] = 'Покупка рекламного места';
$L['paytop_mail_admin_body'] = 'Здравствуйте,

Пользователь %1$s произвел оплату рекламного места.

Подробная информация:

Рекламное место: %2$s
Номер операции: %3$s.
Дата операции: %4$s.

';

$L['paytop_my_area'] = 'Рекламное место';
$L['paytop_my_until'] = 'Срок действия';