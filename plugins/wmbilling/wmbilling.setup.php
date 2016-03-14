<?php

/**
 * [BEGIN_COT_EXT]
 * Code=wmbilling
 * Name=Wmbilling
 * Category=Payments
 * Description=Webmoney billing system
 * Version=1.1.2
 * Date=
 * Author=CMSWorks Team
 * Copyright=Copyright (c) CMSWorks.ru
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=payments
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * webmoney_purse=01:string:::Webmoney-кошелек
 * webmoney_wmid=02:string:::Webmoney WMID
 * webmoney_skey=03:string:::Webmoney Sekret key
 * webmoney_mode=04:radio::1:Test mode
 * webmoney_hashmethod=05:select:MD5,SHA256:SHA256:Hash method
 * webmoney_rate=06:string::1:Exchange rage
 * [END_COT_EXT_CONFIG]
 */

/**
 * Webmoney billing Plugin
 *
 * @package wmbilling
 * @version 1.1.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
?>