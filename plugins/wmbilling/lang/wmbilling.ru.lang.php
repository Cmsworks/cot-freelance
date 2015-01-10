<?php
/**
 * wmbilling plugin
 *
 * @package wmbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */
$L['cfg_webmoney_purse'] = array('Webmoney кошелек');
$L['cfg_webmoney_wmid'] = array('Webmoney WMID');
$L['cfg_webmoney_skey'] = array('Webmoney Sekret key');
$L['cfg_webmoney_mode'] = array('Тестовый режим');
$L['cfg_webmoney_hashmethod'] = array('Hash method');
$L['cfg_webmoney_rate'] = array('Соотношение к валюте сайта');

$L['wmbilling_title'] = 'Webmoney';

$L['wmbilling_formtext'] = 'Сейчас вы будете перенаправлены на сайт платежной системы Webmoney для проведения оплаты. Если этого не произошло, нажмите кнопку "Перейти к оплате".';
$L['wmbilling_formbuy'] = 'Перейти к оплате';
$L['wmbilling_error_paid'] = 'Оплата прошла успешно. В ближайшее время услуга будет активирована!';
$L['wmbilling_error_done'] = 'Оплата прошла успешно.';
$L['wmbilling_error_incorrect'] = 'Некорректная подпись';
$L['wmbilling_error_otkaz'] = 'Отказ от оплаты.';
$L['wmbilling_error_title'] = 'Результат операции оплаты';
$L['wmbilling_error_fail'] = 'Оплата не произведена! Пожалуйста, повторите попытку. Если ошибка повторится, обратитесь к администратору сайта';

$L['wmbilling_redirect_text'] = 'Сейчас произойдет редирект на страницу оплаченной услуги. Если этого не произошло, перейдите по <a href="%1$s">ссылке</a>.';