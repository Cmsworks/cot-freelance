<?php

/**
 * folio module
 *
 * @package folio
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
$L['cfg_foliositemap'] = 'Включить в Sitemap';
$L['cfg_foliositemap_freq'] = 'Частота изменения в Sitemap';
$L['cfg_foliositemap_freq_params'] = $sitemap_freqs;
$L['cfg_foliositemap_prio'] = array('Приоритет в Sitemap');
$L['cfg_description'] = array('Description');
$L['cfg_foliosearch'] = array('Включить в общий поиск');
$L['cfg_notiffolio_admin_moderate'] = array('Уведомлять о новых портфолио на проверке','Отправка уведомления на системный email о новых портфолио на премодерации');
$L['cfg_folioeditor'] = 'Выбор конфигурации визуального редактора';
$L['cfg_folioeditor_params'] = 'Минимальный набор кнопок,Стандартный набор кнопок,Расширенный набор кнопок'; 

$L['info_desc'] = 'Портфолио пользователей';

$L['folio_select_cat'] = "Выберите раздел";
$L['folio_locked_cat'] = "Выбранная категория заблокирована";
$L['folio_empty_title'] = "Название не может быть пустым";
$L['folio_empty_text'] = "Описание не может быть пустым";
$L['folio_large_img'] = "Изображение слишком большое";

$L['folio_forreview'] = 'Ваша работа находится на проверке. Модератор утвердит ее публикацию в ближайшее время.';

$L['folio'] = 'Портфолио';
$L['folio_catalog'] = 'Каталог';
$L['folio_add_to_catalog'] = 'Добавить работу';
$L['folio_add_work'] = 'Добавить работу';
$L['folio_edit_work'] = 'Редактировать работу';
$L['folio_add_work_title'] = 'Добавление работы в портфолио';
$L['folio_edit_work_title'] = 'Редактирование работы из портфолио';

$L['folio_hidden'] = 'Работа не опубликована';
$L['folio_location'] = 'Местоположение';
$L['folio_price'] = 'Бюджет работы';
$L['folio_image_limit'] = 'Разрешенные форматы JPEG, GIF, JPG, PNG. Максимальный размер 1Мб.';
$L['folio_aliascharacters'] = 'Недопустимо использование символов \'+\', \'/\', \'?\', \'%\', \'#\', \'&\' в алиасах';
$L['folio_costasc'] = 'Цена по возрастанию';
$L['folio_costdesc'] = 'Цена по убыванию';
$L['folio_mostrelevant'] = 'Наиболее актуальные';

$L['folio_notfound'] = 'Работы не найдены';
$L['folio_empty'] = 'Работ нет';

$L['folio_added_mail_subj'] = 'Работа добавлена в Портфолио';
$L['folio_senttovalidation_mail_subj'] = 'Ваша новая работа из Портфолио была отправлена на проверку';
$L['folio_admin_home_valqueue'] = 'На проверке';
$L['folio_admin_home_public'] = 'Опубликовано';
$L['folio_admin_home_hidden'] = 'Скрытые';

$L['folio_added_mail_body'] = 'Здравствуйте, {$user_name}. '."\n\n".'Работа "{$prd_name}" была добавлена в ваше Портфолио на сайте {$sitename} - {$link}';
$L['folio_senttovalidation_mail_body'] = 'Здравствуйте, {$user_name}.'."\n\n".'Ваша работа "{$prd_name}" из Портфолио была отправлена на проверку. Модератор утвердит ее публикацию в ближайшее время.';

$L['folio_notif_admin_moderate_mail_subj'] = 'Новое портфолио на проверку';
$L['folio_notif_admin_moderate_mail_body'] = 'Здравствуйте, '."\n\n".'Пользователь {$user_name} отправил на проверку новое портфолио "{$prd_name}".'."\n\n".'{$link}';

$L['folio_status_published'] = 'Опубликовано';
$L['folio_status_moderated'] = 'На проверке';
$L['folio_status_hidden'] = 'Скрыто';

$L['plu_folio_set_sec'] = 'Категории работ';
$L['plu_folio_res_sort1'] = 'Дате публикации';
$L['plu_folio_res_sort2'] = 'Названию';
$L['plu_folio_res_sort3'] = 'Популярности';
$L['plu_folio_res_sort3'] = 'Категории';
$L['plu_folio_search_names'] = 'Поиск в названиях';
$L['plu_folio_search_text'] = 'Поиск в описании';
$L['plu_folio_set_subsec'] = 'Поиск в подразделах';

$Ls['folio_headermoderated'] = "портфолио на проверке,портфолио на проверке,портфолио на проверке";