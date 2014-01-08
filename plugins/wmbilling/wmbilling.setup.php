<?php

/**
 * [BEGIN_COT_EXT]
 * Code=wmbilling
 * Name=Wmbilling
 * Category=Payments
 * Description=Webmoney billing system
 * Version=1.0.2
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
 * webmoney_purse=01:string::R123456789101:Webmoney-кошелек
 * webmoney_wmid=02:string::111571805871:Webmoney WMID
 * webmoney_skey=03:string::hfdf8ddfdfgdfddfg:Webmoney Sekret key
 * webmoney_mode=04:radio::1:Test mode
 * webmoney_hashmethod=05:select:MD5,SIGN:MD5:Hash method
 * webmoney_rate=06:string::1:Exchange rage
 * [END_COT_EXT_CONFIG]
 */

/**
 * Webmoney billing Plugin
 *
 * @package wmbilling
 * @version 1.0.2
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
?>