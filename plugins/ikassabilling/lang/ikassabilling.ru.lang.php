<?php
/**
 * ikassabilling plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_shop_id'] = array('Идентификатор магазина (Checkout ID)', '');
$L['cfg_test_key'] = array('Тестовый ключ', '');
$L['cfg_secret_key'] = array('Секретный ключ', '');
$L['cfg_enablepost'] = array('Включить post запросы');
$L['cfg_rate'] = array('Соотношение суммы к валюте сайта', '');
$L['cfg_currency'] = array('Валюта платежек', '');

$L['ikassabilling_title'] = 'Интеркасса';

$L['ikassabilling_formtext'] = 'Сейчас вы будете перенаправлены на сайт платежной системы Interkassa для проведения оплаты. Если этого не произошло, нажмите кнопку "Перейти к оплате".';
$L['ikassabilling_formbuy'] = 'Перейти к оплате';
$L['ikassabilling_error_paid'] = 'Оплата прошла успешно. В ближайшее время услуга будет активирована!';
$L['ikassabilling_error_done'] = 'Оплата прошла успешно.';
$L['ikassabilling_error_incorrect'] = 'Некорректная подпись';
$L['ikassabilling_error_otkaz'] = 'Отказ от оплаты.';
$L['ikassabilling_error_title'] = 'Результат операции оплаты';
$L['ikassabilling_error_wait'] = 'Платеж ожидает обработки. Пожалуйста, подождите.';
$L['ikassabilling_error_canceled'] = 'Платеж отменен платежной системой. Пожалуйста, повторите попытку. Если ошибка повторится, обратитесь к администратору сайта.';
$L['ikassabilling_error_fail'] = 'Оплата не произведена! Пожалуйста, повторите попытку. Если ошибка повторится, обратитесь к администратору сайта.';

$L['ikassabilling_redirect_text'] = 'Сейчас произойдет редирект на страницу оплаченной услуги. Если этого не произошло, перейдите по <a href="%1$s">ссылке</a>.';