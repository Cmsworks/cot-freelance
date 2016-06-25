<?php
/* ====================
 * [BEGIN_COT_EXT]
 * Code=market
 * Name=Market
 * Description=Магазин
 * Version=2.5.13
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
 * pagelimit=03:select:1,2,3,4,5,10,15,20,25,30,35,40,45,50:20:Число записей на странице
 * shorttextlen=04:string::200:Обрезка текста в категориях
 * prevalidate=05:radio::0:Включить предварительную модерацию
 * preview=06:radio::1:Включить предварительный просмотр
 * marketsitemap=07:radio::1:Включить вывод в sitemap
 * marketsitemap_freq=08:select:default,always,hourly,daily,weekly,monthly,yearly,never:default:Частота изменений для sitemap
 * marketsitemap_prio=09:select:0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0:0.5:Приоритет для sitemap
 * description=10:string:::Описание модуля
 * marketsearch=11:radio::1:Включить в общий поиск
 * title_market=12:string::{TITLE} - {CATEGORY}:
 * count_admin=13:radio::0: 
 * notifmarket_admin_moderate=14:radio::1:Уведомлять о новых товарах на проверке
 * prdeditor=15:select:minieditor,medieditor,editor:medieditor:
 * [END_COT_EXT_CONFIG]
 * 
 * [BEGIN_COT_EXT_CONFIG_STRUCTURE]
 * order=01:callback:cot_market_config_order():date:
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
 * market module
 *
 * @package market
 * @version 2.5.13
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
