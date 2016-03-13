<?php


/**
 * [BEGIN_COT_EXT]
 * Code=usergroupselector
 * Name=User Group Selector
 * Category=post-install
 * Description=Users can select their main group
 * Version=1.0.3
 * Date=2013-09-05
 * Author=CMSWorks Team
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * allowchange=01:radio::0:Разрешить пользователям изменять свою группу в профиле
 * required=02:radio::1:Указывать группу обязательно
 * groups=03:textarea::4,7:Пользовательские группы
 * grptitle=04:radio::1:Включить вывод названия группы в Title
 * [END_COT_EXT_CONFIG]
 * 
 *  */

/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.3
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *  */

defined('COT_CODE') or die('Wrong URL');
