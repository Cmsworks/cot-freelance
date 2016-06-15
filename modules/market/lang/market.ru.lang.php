<?php

/**
 * market module
 *
 * @package market
 * @version 2.5.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_pagelimit'] = array('Число записей в списках');
$L['cfg_shorttextlen'] = array('Количество символов в списках');
$L['cfg_prevalidate'] = array('Включить предварительную модерацию');
$L['cfg_preview'] = array('Включить предварительный просмотр');
$L['cfg_marketsitemap'] = 'Включить в Sitemap';
$L['cfg_marketsitemap_freq'] = 'Частота изменения в Sitemap';
$L['cfg_marketsitemap_freq_params'] = $sitemap_freqs;
$L['cfg_marketsitemap_prio'] = array('Приоритет в Sitemap');
$L['cfg_description'] = array('Description');
$L['cfg_marketsearch'] = array('Включить в общий поиск');
$L['cfg_warranty'] = array('Гарантийный срок (дней)');
$L['cfg_tax'] = array('Комиссия за продажи (%)');
$L['cfg_ordersperpage'] = array('Число заказов на странице');
$L['cfg_notifmarket_admin_moderate'] = array('Уведомлять о новых товарах на проверке','Отправка уведомления на системный email о новых товарах на премодерации');
$L['cfg_prdeditor'] = 'Выбор конфигурации визуального редактора';
$L['cfg_prdeditor_params'] = 'Минимальный набор кнопок,Стандартный набор кнопок,Расширенный набор кнопок'; 

$L['info_desc'] = 'Ветрина товаров и услуг';

$L['market_select_cat'] = "Выберите раздел";
$L['market_locked_cat'] = "Выбранная категория заблокирована";
$L['market_empty_title'] = "Название не может быть пустым";
$L['market_empty_text'] = "Описание не может быть пустым";
$L['market_large_img'] = "Изображение слишком большое";

$L['market_forreview'] = 'Ваш товар находится на проверке. Модератор утвердит его публикацию в ближайшее время.';

$L['market'] = 'Магазин';
$L['market_myproducts'] = 'Мои товары';

$L['market_catalog'] = 'Каталог';
$L['market_add_product'] = 'Добавить товар';
$L['market_edit_product'] = 'Редактировать товар';
$L['market_add_product_title'] = 'Добавление товара в магазин';
$L['market_edit_product_title'] = 'Редактирование товара из магазина';

$L['market_hidden'] = 'Товар не опубликован';
$L['market_location'] = 'Местоположение';
$L['market_price'] = 'Цена';
$L['market_image_limit'] = 'Разрешенные форматы JPEG, GIF, JPG, PNG. Максимальный размер 1Мб.';
$L['market_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';

$L['market_costasc'] = 'Цена по возрастанию';
$L['market_costdesc'] = 'Цена по убыванию';
$L['market_mostrelevant'] = 'Наиболее актуальные';

$L['market_notfound'] = 'Товары не найдены';
$L['market_empty'] = 'Товаров нет';

$L['market_added_mail_subj'] = 'Ваш товар опубликован';
$L['market_senttovalidation_mail_subj'] = 'Ваш товар отправлен на проверку';
$L['market_admin_home_valqueue'] = 'На проверке';
$L['market_admin_home_public'] = 'Опубликовано';
$L['market_admin_home_hidden'] = 'Скрытые';

$L['market_added_mail_body'] = 'Здравствуйте, {$user_name}. '."\n\n".'Ваш товар "{$prd_name}" был опубликован на сайте {$sitename} - {$link}';
$L['market_senttovalidation_mail_body'] = 'Здравствуйте, {$user_name}.'."\n\n".'Ваш товар "{$prd_name}" был отправлен на проверку. Модератор утвердит его публикацию в ближайшее время.';

$L['market_notif_admin_moderate_mail_subj'] = 'Новый товар на проверку';
$L['market_notif_admin_moderate_mail_body'] = 'Здравствуйте, '."\n\n".'Пользователь {$user_name} отправил на проверку новый товар "{$prd_name}".'."\n\n".'{$link}';

$L['market_status_published'] = 'Опубликовано';
$L['market_status_moderated'] = 'На проверке';
$L['market_status_hidden'] = 'Скрыто';

$L['plu_market_set_sec'] = 'Категории товаров';
$L['plu_market_res_sort1'] = 'Дате публикации';
$L['plu_market_res_sort2'] = 'Названию';
$L['plu_market_res_sort3'] = 'Популярности';
$L['plu_market_res_sort3'] = 'Категории';
$L['plu_market_search_names'] = 'Поиск в названиях товаров';
$L['plu_market_search_text'] = 'Поиск в описании';
$L['plu_market_set_subsec'] = 'Поиск в подразделах';

$Ls['market_headermoderated'] = "товар на проверке,товара на проверке,товаров на проверке";