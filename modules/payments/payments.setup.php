<?php
/**
 * [BEGIN_COT_EXT]
 * Code=payments
 * Name=Payments
 * Description=Платежный модуль
 * Version=1.1.4
 * Date=
 * Author=CMSWorks Team
 * Copyright=Copyright (c) CMSWorks.ru, littledev.ru
 * Notes=
 * SQL=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=12345A
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * balance_enabled=01:radio::1:Включить внутренние счета
 * valuta=02:string::руб.:Название валюты сайта
 * clearpaymentsdays=03:string::0:Очищать базу от неоплаченных платежек через (дней)
 * [END_COT_EXT_CONFIG]
 */

/**
 * Payments module
 *
 * @package payments
 * @version 1.1.4
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

?>