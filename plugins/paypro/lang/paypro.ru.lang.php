<?php
/**
 * Paypro plugin
 *
 * @package paypro
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_cost'] = array('Стоимость в месяц', '');
$L['cfg_offerslimit'] = array('Лимит ответов на проекты для обычных пользователей', '');
$L['cfg_projectslimit'] = array('Лимит проектов для обычных пользователей', '');

$L['info_desc'] = 'Pro-аккаунты';

$L['paypro_forpro'] = 'Только для PRO';

$L['paypro_buypro_title'] = 'Покупка PRO';
$L['paypro_buypro_paydesc'] = 'Покупка PRO';
$L['paypro_costofmonth'] = 'Стоимость за месяц';
$L['paypro_error_months'] = 'Укажите срок действия услуги';

$L['paypro_buy'] = 'Купить';
$L['paypro_month'] = 'месяц';

$L['paypro_header_buy'] = 'Купить PRO';
$L['paypro_header_expire'] = 'PRO действует до';
$L['paypro_header_expire_short'] = 'PRO до';
$L['paypro_header_extend'] = 'Продлить услугу';

$L['paypro_warning_projectslimit_empty'] = 'Вы больше не можете публиковать проекты. Максимальное число проектов для публикации составляет: '.$cfg['plugin']['paypro']['projectslimit'].' в сутки. Чтобы снять это ограничение, воспользуйтесь услугой PRO-аккаунт.';
$L['paypro_warning_offerslimit_empty'] = 'Вы больше не можете оставлять предложения по проектам. Максимальное число откликов на проекты составляет: '.$cfg['plugin']['paypro']['offerslimit'].' в сутки. Чтобы снять это ограничение, воспользуйтесь услугой PRO-аккаунт.';
$L['paypro_warning_onlyforpro'] = 'Вы не можете оставлять предложения по данному проекту, так как он доступен только для пользователей с PRO-аккаунтом. Чтобы снять это ограничение, воспользуйтесь услугой PRO-аккаунт.';

$L['paypro_error_username'] = 'Не указан логин пользователя';
$L['paypro_error_userempty'] = 'Такого пользователя не существует';
$L['paypro_error_monthsempty'] = 'Срок действия услуги не указан';
$L['paypro_addproacc'] = 'Добавление PRO-аккаунта для пользователя';

$L['paypro_giftpro'] = 'Подарить PRO-аккаунт';
$L['paypro_giftfor'] = 'Подарить пользователю';
$L['paypro_giftpro_paydesc'] = 'Покупка PRO в подарок для ';
$L['paypro_error_user'] = 'Пользователь не найден';
