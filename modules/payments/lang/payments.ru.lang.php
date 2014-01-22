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
$L['cfg_clearpaymentsdays'] = array('Очищать базу от неоплаченных платежек через (дней)');

$L['payments_mybalance'] = 'Мой счет';
$L['payments_balance'] = 'На счету';
$L['payments_paytobalance'] = 'Пополнить счет';
$L['payments_history'] = 'История операций';
$L['payments_payouts'] = 'Вывод со счета';
$L['payments_balance_payouts_button'] = 'Новая заявка';
$L['payments_balance_payout_error_summ'] = 'Не указана сумма';
$L['payments_balance_payout_list'] = 'Заявки на вывод средств со счета';
$L['payments_balance_payout_title'] = 'Заявка на вывод со счета';
$L['payments_balance_payout_desc'] = 'Вывод со счета по заявке';
$L['payments_balance_payout_summ'] = 'Укажите сумму';
$L['payments_balance_payout_tax'] = "Комиссия";
$L['payments_balance_payout_total'] = "Сумма к списанию";
$L['payments_balance_payout_details'] = 'Реквизиты счета или кошелька';
$L['payments_balance_payout_error_details'] = 'Не указаны реквизиты';
$L['payments_balance_payout_error_balance'] = 'Указанная сумма превышает баланс вашего счета';

$L['payments_balance_billing_error_summ'] = 'Не указана сумма';
$L['payments_balance_billing_desc'] = 'Пополнение счета';
$L['payments_balance_billing_summ'] = 'Укажите сумму';

$L['payments_transfer'] = 'Перевод пользователю';
$L['payments_balance_transfer_desc'] = "Перевод от %1\$s для %2\$s (%3\$s)";
$L['payments_balance_transfer_comment'] = "Комментарий";
$L['payments_balance_transfer_summ'] = "Укажите сумму";
$L['payments_balance_transfer_tax'] = "Комиссия";
$L['payments_balance_transfer_total'] = "Сумма к списанию";
$L['payments_balance_transfer_username'] = "Логин получателя";
$L['payments_balance_transfer_error_username'] = "Такого пользователя не существует";
$L['payments_balance_transfer_error_summ'] = 'Не указана сумма';
$L['payments_balance_transfer_error_balance'] = 'Сумма превышает баланс вашего счета';
$L['payments_balance_transfer_error_comment'] = 'Не указаны комментарии к переводу';

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