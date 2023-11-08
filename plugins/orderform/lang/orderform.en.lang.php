<?php

/**
 * Orderform
 *
 * @version 1.00
 * @author  devkont
 * @copyright (c) 2014 CMSWorks Team
 */

defined('COT_CODE') or die('Wrong URL.');

$L['orderform_title'] = 'Заказ товара';
$L['orderform_buy'] = 'Заказать';
$L['orderform_sendorder'] = 'Отправить заказ';

$L['orderform_form_email'] = 'Email';
$L['orderform_form_name'] = 'Ваше имя';
$L['orderform_form_phone'] = 'Телефон';
$L['orderform_form_quantity'] = 'Количество';
$L['orderform_form_comment'] = 'Комментарий';

$L['orderform_error_email'] = 'Пожалуйста, проверьте email';
$L['orderform_error_name'] = 'Не указано имя';
$L['orderform_error_phone'] = 'Не указан телефон';
$L['orderform_error_quantity'] = 'Не указано количество';

$L['orderform_sent'] = 'Ваш запрос принят! В ближайшее время продавец свяжется с Вами.';

$L['orderform_subject_seller'] = 'Заказ';
$L['orderform_body_seller'] = 'Здравствуйте! 
Вам поступил заказ с сайта {$sitetitle} ({$siteurl})
Подробная информация:
Имя: {$name}
Email: {$email}
Телефон: {$phone}
Наименование товара: {$product_title} ({$product_url})
Количество: {$quantity}

Комментарий: {$comment}';

$L['orderform_subject_customer'] = 'Ваш заказ';
$L['orderform_body_customer'] = 'Здравствуйте! 
Вы оформили заказ на сайте {$sitetitle} ({$siteurl}). В ближайшее время с вами свяжется продавец.
Подробная информация:
Имя: {$name}
Email: {$email}
Телефон: {$phone}
Наименование товара: {$product_title} ({$product_url})
Количество: {$quantity}

Комментарий: {$comment}';

$L['orderform_subject_admin'] = 'Информация о заказе';
$L['orderform_body_admin'] = 'Здравствуйте! 
Был оформлен заказ на сайте {$sitetitle} ({$siteurl}).
Подробная информация:
Имя: {$name}
Email: {$email}
Телефон: {$phone}
Наименование товара: {$product_title} ({$product_url})
Количество: {$quantity}

Комментарий: {$comment}';
