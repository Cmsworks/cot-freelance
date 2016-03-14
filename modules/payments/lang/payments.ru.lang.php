<?php
/**
 * Payments module
 *
 * @package payments
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_balance_enabled'] = array('Включить внутренние счета');
$L['cfg_valuta'] = array('Валюта сайта');
$L['cfg_transfers_enabled'] = array('Включить переводы между пользователями');
$L['cfg_transfertax'] = array('Комиссия за переводы между пользователями', '%');
$L['cfg_transfermin'] = array('Минимальная сумма перевода между пользователями', $cfg['payments']['valuta']);
$L['cfg_transfermax'] = array('Максимальная сумма перевода между пользователями', $cfg['payments']['valuta']);
$L['cfg_transfertaxfromrecipient'] = array('Удерживать комиссию с получателя перевода');
$L['cfg_payouts_enabled'] = array('Включить заявки на вывод со счета');
$L['cfg_payouttax'] = array('Комиссия за вывод со счета', '%');
$L['cfg_payoutmin'] = array('Минимальная сумма для вывода со счета', $cfg['payments']['valuta']);
$L['cfg_payoutmax'] = array('Максимальная сумма для вывода со счета', $cfg['payments']['valuta']);
$L['cfg_clearpaymentsdays'] = array('Очищать базу от неоплаченных платежек через', 'дней');

$L['info_desc'] = 'Система оплаты';

$L['payments_mybalance'] = 'Мой счет';
$L['payments_balance'] = 'На счету';
$L['payments_paytobalance'] = 'Пополнить счет';
$L['payments_history'] = 'История операций';
$L['payments_history_empty'] = 'Операций нет';
$L['payments_payouts'] = 'Вывод со счета';
$L['payments_balance_payouts_button'] = 'Новая заявка';
$L['payments_balance_payout_list'] = 'Заявки на вывод средств со счета';
$L['payments_balance_payout_title'] = 'Заявка на вывод со счета';
$L['payments_balance_payout_desc'] = 'Вывод со счета по заявке';
$L['payments_balance_payout_cancel_desc'] = 'Отмена заявки на вывод';
$L['payments_balance_payout_summ'] = 'Укажите сумму';
$L['payments_balance_payout_tax'] = "Комиссия";
$L['payments_balance_payout_total'] = "Сумма к списанию";
$L['payments_balance_payout_details'] = 'Реквизиты счета или кошелька';
$L['payments_balance_payout_error_details'] = 'Не указаны реквизиты';
$L['payments_balance_payout_error_emptysumm'] = 'Не указана сумма';
$L['payments_balance_payout_error_wrongsumm'] = 'Сумма не может быть отрицательной';
$L['payments_balance_payout_error_balance'] = 'Указанная сумма превышает баланс вашего счета';
$L['payments_balance_payout_error_min'] = 'Сумма для вывода не должна быть меньше %1$s %2$s';
$L['payments_balance_payout_error_max'] = 'Сумма для вывода не должна быть больше %1$s %2$s';

$L['payments_balance_payout_status_process'] = 'Обрабатывается';
$L['payments_balance_payout_status_done'] = 'Обработана';
$L['payments_balance_payout_status_canceled'] = 'Отменена';

$L['payments_balance_billing_desc'] = 'Пополнение счета';
$L['payments_balance_billing_summ'] = 'Укажите сумму';
$L['payments_balance_billing_error_emptysumm'] = 'Не указана сумма';
$L['payments_balance_billing_error_wrongsumm'] = 'Сумма не может быть отрицательной';

$L['payments_balance_billing_admin_subject'] = 'Пополнение счета на сайте';
$L['payments_balance_billing_admin_body'] = 'Здравствуйте,

Пользователь %1$s произвел пополнение счета на сайте.

Подробная информация:

Сумма: %2$s
Номер операции: %3$s.
Дата операции: %4$s.

';

$L['payments_balance_payout_admin_subject'] = 'Заявка на вывод со счета';
$L['payments_balance_payout_admin_body'] = 'Здравствуйте,

Пользователь %1$s оставил заявку на вывод денег с его счета на сайте.

Подробная информация:

Сумма: %2$s
Номер заявки: %3$s
Дата подачи заявки: %4$s
Реквизиты: %5$s.

';

$L['payments_balance_payout_cancel_subject'] = 'Заявка на вывод отменена';
$L['payments_balance_payout_cancel_body'] = 'Здравствуйте, %1$s

Заявка на вывод денег со счета №%2$s была отменена. Для уточнения причины свяжитесь с администрацией.';

$L['payments_balance_transfer_admin_subject'] = 'Перевод пользователю';
$L['payments_balance_transfer_admin_body'] = 'Здравствуйте,

Пользователь %1$s осуществил перевод на счет пользователя %2$s.

Подробная информация:

Сумма перевода: %3$s %7$s
Комиссия: %4$s %7$s
Списано с отправителя: %5$s %7$s
Начислено получателю: %6$s %7$s
Дата перевода: %8$s
Комментарий: %9$s

';

$L['payments_balance_transfer_recipient_subject'] = 'Перевод от пользователя';
$L['payments_balance_transfer_recipient_body'] = 'Здравствуйте, %2$s

Пользователь %1$s осуществил перевод на ваш счет на сайте.

Подробная информация:

Сумма перевода: %3$s %7$s
Комиссия: %4$s %7$s
Вам начислено: %6$s %7$s
Дата перевода: %8$s
Комментарий: %9$s

';

$L['payments_balance_transfer_cancel_subject'] = 'Перевод отменен';
$L['payments_balance_transfer_cancel_body'] = 'Здравствуйте, %1$s

Перевод №%2$s был отменен. Для уточнения причины свяжитесь с администрацией.';

$L['payments_transfer'] = 'Перевод пользователю';
$L['payments_transfers'] = 'Переводы';
$L['payments_balance_transfers_list'] = 'Переводы';
$L['payments_balance_transfers_button'] = 'Создать перевод';
$L['payments_balance_transfers_from'] = 'От';
$L['payments_balance_transfers_for'] = 'Для';
$L['payments_balance_transfer_desc'] = "Перевод от %1\$s для %2\$s (%3\$s)";
$L['payments_balance_transfer_cancel_desc'] = "Отмена заявки на перевод №%1\$s";
$L['payments_balance_transfer_comment'] = "Комментарий";
$L['payments_balance_transfer_summ'] = "Укажите сумму";
$L['payments_balance_transfer_tax'] = "Комиссия";
$L['payments_balance_transfer_total'] = "Сумма к списанию";
$L['payments_balance_transfer_username'] = "Логин получателя";
$L['payments_balance_transfer_error_username'] = "Такого пользователя не существует";
$L['payments_balance_transfer_error_yourself'] = "Нельзя выполнить перевод самому себе";
$L['payments_balance_transfer_error_emptysumm'] = 'Не указана сумма';
$L['payments_balance_transfer_error_wrongsumm'] = 'Сумма не может быть отрицательной';
$L['payments_balance_transfer_error_balance'] = 'Сумма превышает баланс вашего счета';
$L['payments_balance_transfer_error_comment'] = 'Не указаны комментарии к переводу';
$L['payments_balance_transfer_error_min'] = 'Сумма для перевода не должна быть меньше %1$s %2$s';
$L['payments_balance_transfer_error_max'] = 'Сумма для перевода не должна быть больше %1$s %2$s';

$L['payments_balance_transfer_status_process'] = 'Обрабатывается';
$L['payments_balance_transfer_status_done'] = 'Обработана';
$L['payments_balance_transfer_status_canceled'] = 'Отменена';

$L['payments_billing_title'] = 'Способы оплаты';
$L['payments_emptybillings'] = 'На данный момент способы оплаты недоступны. Пожалуйста, попробуйте выполнить оплату позже.';

$L['payments_allusers'] = 'Все пользователи';
$L['payments_siteinvoices'] = 'Счет на сайте';
$L['payments_debet'] = 'дебет';
$L['payments_credit'] = 'кредит';
$L['payments_allpayments'] = 'Сумма всех платежей';
$L['payments_area'] = 'Тип';
$L['payments_code'] = 'Код';
$L['payments_desc'] = 'Назначение';
$L['payments_summ'] = 'Сумма';

$L['payments_error_message_'] = 'Произошла ошибка в запросе! Пожалуйста, свяжитесь с администрацией сайта и сообщите какие действия привели вас к этому сообщению об ошибке.';
$L['payments_error_message_1'] = 'Такой страницы не существует! Пожалуйста, свяжитесь с администрацией сайта и сообщите какие действия привели вас к этому сообщению об ошибке.';
$L['payments_error_message_2'] = 'Недопустимая операция! Пожалуйста, свяжитесь с администрацией сайта и сообщите какие действия привели вас к этому сообщению об ошибке.';
$L['payments_error_message_3'] = 'Сумма к оплате не соответствует стоимости услуги! Пожалуйста, свяжитесь с администрацией сайта и сообщите какие действия привели вас к этому сообщению об ошибке.';

?>