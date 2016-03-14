<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Code=ikassabilling
 * Name=Ikassabilling
 * Category=Payments
 * Description=Ikassa billing system
 * Version=2.0.2
 * Date=
 * Author=CMSWorks Team
 * Copyright=Copyright (c) CMSWorks.ru
 * Notes=
 * Auth_guests=RW
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=payments
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * shop_id=01:string:::Идентификатор магазина (Checkout ID)
 * test_key=02:string:::Тестовый ключ
 * secret_key=02:string:::Секретный ключ
 * enablepost=03:radio::0:Разрешить post запросы
 * currency=04:string::RUB:Код валюты (USD,RUB,EUR,GBP,YEN,CAD и др)
 * rate=05:string::1:Соотношение суммы к валюте сайта
 * [END_COT_EXT_CONFIG]
 */

/**
 * Ikassa billing Plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
?>