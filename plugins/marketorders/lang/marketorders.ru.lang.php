<?php

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_warranty'] = array('Гарантийный срок (дней)');
$L['cfg_tax'] = array('Комиссия за продажи (%)');
$L['cfg_ordersperpage'] = array('Число заказов на странице');
$L['cfg_adminid'] = array('ID пользователя для зачисления комиссии');
$L['cfg_showneworderswithoutpayment'] = array('Показывать заказы ожидающие оплату');
$L['cfg_acceptzerocostorders'] = array('Разрешать покупку товаров с ценой 0 '.((is_array($cfg) && is_array($cfg['payments'])) ? $cfg['payments']['valuta'] : ''));

$L['marketorders'] = 'Заказы в магазине';

$L['marketorders_admin_home_all'] = 'Все заказы';
$L['marketorders_admin_home_claims'] = 'Проблемные заказы';
$L['marketorders_admin_home_done'] = 'Исполненные заказы';
$L['marketorders_admin_home_cancel'] = 'Отмененные заказы';

$L['marketorders_mysales'] = 'Мои продажи';
$L['marketorders_mypurchases'] = 'Мои покупки';

$L['marketorders_sales_title'] = 'Мои продажи';
$L['marketorders_purchases_title'] = 'Мои покупки';
$L['marketorders_empty'] = 'Заказов нет';

$L['marketorders_neworder_pay'] = 'Оплатить';

$L['marketorders_neworder_button'] = 'Купить сейчас';
$L['marketorders_neworder_title'] = 'Оформление заказа';
$L['marketorders_neworder_product'] = 'Наименование товара';
$L['marketorders_neworder_count'] = 'Количество';
$L['marketorders_neworder_comment'] = 'Комментарий к заказу';
$L['marketorders_neworder_total'] = 'Итого к оплате';
$L['marketorders_neworder_email'] = 'Email';

$L['marketorders_neworder_error_count'] = 'Не указано количество';
$L['marketorders_order_error_claimtext'] = 'Не заполнен текст жалобы';

$L['marketorders_title'] = 'Информация о заказе';
$L['marketorders_product'] = 'Наименование товара';
$L['marketorders_count'] = 'Количество';
$L['marketorders_comment'] = 'Комментарий к заказу';
$L['marketorders_cost'] = 'Сумма заказа';
$L['marketorders_paid'] = 'Дата оплаты';
$L['marketorders_warranty'] = 'Гарантийный срок';

$L['marketorders_buyers'] = 'Покупатели';

$L['marketorders_done_payments_desc'] = 'Выплата по заказу № {$order_id} ({$product_title})';
$L['marketorders_tax_payments_desc'] = 'Доход с продажи по заказу № {$order_id} ({$product_title})';

$L['marketorders_paid_mail_toseller_header'] = 'Новый заказ № {$order_id} ({$product_title})';
$L['marketorders_paid_mail_toseller_body'] = 'Поздравляем! Пользователь {$user_name}, оформил и оплатил заказ № {$order_id} ([{$product_id}] {$product_title}). Если у покупателя не будет претензий к приобретенному товару/услуге, то по истечению гарантийного срока ({$warranty} дней) на ваш счет поступит оплата в размере {$summ} с учетом комиссии сервиса {$tax}%. Подробности заказа смотрите по ссылке:  {$link}';

$L['marketorders_paid_mail_tocustomer_header'] = 'Заказ № {$order_id} оплачен';
$L['marketorders_paid_mail_tocustomer_body'] = 'Поздравляем! Вы оплатили заказ № {$order_id} ([{$product_id}] {$product_title}) на сумму {$cost}. Подробности заказа смотрите по ссылке:  {$link}';

$L['marketorders_done_mail_toseller_header'] = 'Выплата по заказу № {$order_id} ({$product_title})';
$L['marketorders_done_mail_toseller_body'] = 'Поздравляем! На ваш счет поступила оплата по заказу № {$order_id} ([{$product_id}] {$product_title}) в размере {$summ} с учетом комиссии сервиса {$tax}%. Подробности заказа смотрите по ссылке: {$link}';

$L['marketorders_sales_paidorders'] = 'Оплаченные заказы';
$L['marketorders_sales_doneorders'] = 'Исполненные заказы';
$L['marketorders_sales_claimorders'] = 'Проблемные заказы';
$L['marketorders_sales_cancelorders'] = 'Отмененные заказы';

$L['marketorders_purchases_paidorders'] = 'Оплаченные покупки';
$L['marketorders_purchases_doneorders'] = 'Исполненные покупки';
$L['marketorders_purchases_claimorders'] = 'Проблемные покупки';
$L['marketorders_purchases_cancelorders'] = 'Отмененные покупки';
$L['marketorders_purchases_new'] = 'Ожидают оплаты';

$L['marketorders_status_paid'] = 'Оплаченный';
$L['marketorders_status_done'] = 'Исполненный';
$L['marketorders_status_claim'] = 'Проблемный';
$L['marketorders_status_cancel'] = 'Отмененный';

$L['marketorders_addclaim_title'] = 'Подача жалобы по заказу';
$L['marketorders_addclaim_button'] = 'Подать жалобу в арбитраж';
$L['marketorders_claim_title'] = 'Жалоба';
$L['marketorders_claim_accept'] = 'Отменить заказ';
$L['marketorders_claim_cancel'] = 'Отказать в жалобе';

$L['marketorders_claim_payments_seller_desc'] = 'Выплата за заказ №{$order_id} ([ID {$product_id}] {$product_title}), согласно решению администрации сайта.';
$L['marketorders_claim_payments_customer_desc'] = 'Возврат за заказ №{$order_id} ([ID {$product_id}] {$product_title}), согласно решению администрации сайта.';

$L['marketorders_claim_error_cost'] = 'Сумма выплат не соответствует общей стоимости заказа';

$L['marketorders_addclaim_mail_toseller_header'] = 'Жалоба по заказу № {$order_id}';
$L['marketorders_addclaim_mail_toseller_body'] = 'Покупатель подал жалобу по заказу № {$order_id} ([ID {$product_id}] {$product_title}). Подробность смотрите по ссылке: {$link}';

$L['marketorders_addclaim_mail_toadmin_header'] = 'Жалоба по заказу № {$order_id}';
$L['marketorders_addclaim_mail_toadmin_body'] = 'Покупатель подал жалобу по заказу № {$order_id} ([ID {$product_id}] {$product_title}). Подробность смотрите по ссылке: {$link}';

$L['marketorders_acceptclaim_mail_toseller_header'] = 'Отмена заказа № {$order_id}';
$L['marketorders_acceptclaim_mail_toseller_body'] = 'Заказ № {$order_id} ([ID {$product_id}] {$product_title}) отменен в связи с тем, что покупатель подал жалобу. Подробности смотрите по ссылке: {$link}';

$L['marketorders_acceptclaim_mail_tocustomer_header'] = 'Отмена заказа № {$order_id}';
$L['marketorders_acceptclaim_mail_tocustomer_body'] = 'Заказ № {$order_id} ([ID {$product_id}] {$product_title}) отменен в связи с вашей жалобой. Подробности смотрите по ссылке: {$link}';

$L['marketorders_cancelclaim_mail_tocustomer_header'] = 'Жалобы по заказу № {$order_id} отклонена';
$L['marketorders_cancelclaim_mail_tocustomer_body'] = 'Ваша жалоба по заказу № {$order_id} ([ID {$product_id}] {$product_title}) отклонена администрацией сайта. Подробности смотрите по ссылке: {$link}';

$L['marketorders_file'] = 'Файлы для продажи';
$L['marketorders_file_for_download'] = 'Файлы для скачивания';
$L['marketorders_file_download'] = 'Скачать';
