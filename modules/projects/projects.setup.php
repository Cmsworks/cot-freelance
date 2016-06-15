<?php
/**
 * [BEGIN_COT_EXT]
 * Code=projects
 * Name=Projects
 * Description=Проекты
 * Version=2.5.15
 * Date=24.11.2012
 * Author=CMSWorks Team
 * Copyright=Copyright &copy; CMSWorks.ru, littledev.ru
 * Notes=
 * SQL=
 * Auth_guests=R
 * Lock_guests=2345A
 * Auth_members=RW1
 * Lock_members=
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * markup=01:radio::1:
 * parser=02:callback:cot_get_parsers():html:
 * indexlimit=03:select:1,2,3,4,5,10,15,20,25,30,35,40,45,50:10:Число записей на главной
 * shorttextlen=04:string::200:Обрезка текста в категориях
 * prevalidate=05:radio::0:Включить предварительную модерацию
 * preview=06:radio::1:Включить предварительный просмотр
 * prjsitemap=07:radio::1:Включить вывод проектов в sitemap
 * prjsitemap_freq=08:select:default,always,hourly,daily,weekly,monthly,yearly,never:default:Частота изменений для sitemap
 * prjsitemap_prio=09:select:0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0:0.5:Приоритет для sitemap
 * description=10:string:::Описание модуля
 * prjsearch=11:radio::1:Включить в общий поиск
 * default_type=12:string::0:Тип проекта по-умолчанию
 * title_projects=13:string::{TITLE} - {CATEGORY}:
 * offersperpage=14:string::0:Число предложений на странице
 * count_admin=15:radio::0:
 * notif_admin_moderate=16:radio::1:Уведомлять о новых проектах на проверке
 * prjeditor=17:select:minieditor,medieditor,editor:medieditor:
 * [END_COT_EXT_CONFIG]
 * 
 * [BEGIN_COT_EXT_CONFIG_STRUCTURE]
 * order=01:callback:cot_projects_config_order():date:
 * way=02:select:asc,desc:asc:
 * maxrowsperpage=03:string::30:
 * allowemptytext=05:radio::0:
 * keywords=06:string:::
 * metatitle=07:string:::
 * metadesc=08:string:::
 * [END_COT_EXT_CONFIG_STRUCTURE]
 */

/**
 * projects module
 *
 * @package projects
 * @version 2.5.15
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
