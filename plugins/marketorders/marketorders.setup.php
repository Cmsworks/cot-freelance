<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Code=marketorders
 * Name=Market orders
 * Category=Payments
 * Description=Заказы в магазине
 * Version=1.0.6.1
 * Date=12 Dec 2016
 * Author=CMSWorks Team
 * Copyright=Copyright (c) CMSWorks.ru
 * Notes=Плагин для оплаты товаров/услуг опубликованных в модуле Market. Позволяет оплачивать товары/услуги с указанной ценой. После оплаты Продавец уведомляется по email. При этом сумма за покупку резервируется на счету сайта на гарантийный срок (например 14 дней), чтобы обеспечить безопасность проведения подобного рода продаж через сайт.
 * Auth_guests=
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345A
 * Requires_modules=payments,market
 * [END_COT_EXT]
 *
 * [BEGIN_COT_EXT_CONFIG]
 * warranty=01:string::14:Warranty period
 * tax=02:string::10:Selling commission
 * ordersperpage=03:select:0,1,2,3,4,5,10,15,20,25,30,35,40,45,50:20:Число заказов на странице
 * filepath=04:string::datas/marketfiles:File path
 * adminid=04:string::0:Admin id
 * showneworderswithoutpayment=05:radio::1:Show new orders without payment
 * acceptzerocostorders=06:radio::1:Accept orders with 0 price
 * [END_COT_EXT_CONFIG]
 */

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.5
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
?>
