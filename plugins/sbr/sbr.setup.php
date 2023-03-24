<?php

/* ====================
 * [BEGIN_COT_EXT]
 * Code=sbr
 * Name=Sbr
 * Category=Payments
 * Description=Сделки
 * Version=1.0.8
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
 * tax=05:string::5:Комиссия за оформление сделки c Заказчика
 * tax_performer=10:string::0:Комиссия с Исполнителя
 * stages_on=15:radio::1:
 * mincost=20:string::0:Минимальный бюджет
 * maxcost=25:string::0:Максимальный бюджет
 * maxdays=30:string::0:Максимальный срок исполнения этапа сделки
 * maxrowsperpage=35:string::30:Число сделок на страницу
 * filepath=40:string::datas/sbr:Директория для файлов
 * extensions=45:string::jpg,jpeg,png,gif,bmp,txt,doc,docx,xls,pdf,rar,zip:Допустимые расширения файлов
 * adminid=50:string::0:Admin id
 * [END_COT_EXT_CONFIG]
 */

/**
 * sbr plugin
 *
 * @package sbr
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
