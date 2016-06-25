<?php
/* ====================
 * [BEGIN_COT_EXT]
 * Code=folio
 * Name=Folio
 * Description=Портфолио
 * Version=2.5.14
 * Date=24.11.2012
 * Author=CMSWorks Team
 * Copyright=Copyright &copy; CMSWorks.ru, littledev.ru
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=
 * Requires_plugins=
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * markup=01:radio::1:
 * parser=02:callback:cot_get_parsers():html:* 
 * shorttextlen=03:string::200:Обрезка текста в категориях
 * prevalidate=04:radio::0:Включить предварительную модерацию
 * preview=05:radio::1:Включить предварительный просмотр
 * foliositemap=06:radio::1:Включить вывод в sitemap
 * foliositemap_freq=07:select:default,always,hourly,daily,weekly,monthly,yearly,never:default:Частота изменений для sitemap
 * foliositemap_prio=08:select:0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0:0.5:Приоритет для sitemap
 * foliosearch=09:radio::1:Включить в общий поиск
 * title_folio=10:string::{TITLE} - {CATEGORY}:
 * count_admin=11:radio::0: 
 * notiffolio_admin_moderate=12:radio::1:Уведомлять о новых портфолио на проверке
 * folioeditor=13:select:minieditor,medieditor,editor:medieditor:
 * [END_COT_EXT_CONFIG]
 * 
 * [BEGIN_COT_EXT_CONFIG_STRUCTURE]
 * order=01:callback:cot_folio_config_order():date:
 * way=02:select:asc,desc:asc:
 * maxrowsperpage=03:string::30:
 * truncatetext=04:string::0:
 * allowemptytext=05:radio::0:
 * keywords=06:string:::
 * metatitle=07:string:::
 * metadesc=08:string:::
 * [END_COT_EXT_CONFIG_STRUCTURE]
*/

/**
 * folio module
 *
 * @package folio
 * @version 2.5.14
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
