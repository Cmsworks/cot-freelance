<?php

/**
 * support module
 *
 * @package support
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$L['plu_title'] = 'Техническая поддержка';
$L['support'] = 'Техническая поддержка';

$L['support_addtitle'] = 'Создание заявки';

$L['support_tickets_add_button'] = 'Создать заявку';
$L['support_tickets_close_button'] = 'Закрыть заявку';

$L['support_tickets'] = 'Заявки на техподдержку';
$L['support_tickets_number'] = 'Заявка';
$L['support_tickets_open'] = 'Активные';
$L['support_tickets_closed'] = 'Закрытые';

$L['support_tickets_new'] = 'Новое обращение';
$L['support_tickets_notanswered'] = 'В обработке';
$L['support_tickets_answered'] = 'Ответ отправлен';
$L['support_tickets_waiting_answer'] = 'Ожидает вашего ответа';
$L['support_tickets_answer'] = 'Получен ответ';
$L['support_tickets_closed'] = 'Закрыто';

$L['support_tickets_lastpost_from'] = 'Последний ответ от';
$L['support_tickets_lastpost_when'] = 'Когда';

$L['support_tickets_opentext'] = 'Актуальных';

$Ls['support_tickets'] = array('обращение', 'обращения', 'обращений');

$L['support_tickets_wait_alert'] = 'Ваше обрашение отправлено, ожидайте ответа!';
$L['support_tickets_closed_alert'] = 'Эта заявка уже исполнена. Если вам необходимо задать другой вопрос, то создайте пожалуйста новую заявку.';

$L['support_notify_newticket_title'] = "Новая заявка #%1\$s";
$L['support_notify_newticket_body'] = "Здравствуйте!\nПоступила новая заявка от пользователя %1\$s. Ссылка для просмотра:\n%2\$s";

$L['support_notify_newmsg_admin_title'] = "Ответ по заявке #%1\$s";
$L['support_notify_newmsg_admin_body'] = "Здравствуйте!\nВам поступил ответ по заявке #%1\$s. Ссылка для просмотра:\n%2\$s";
$L['support_notify_newmsg_user_title'] = "Ответ по заявке #%1\$s";
$L['support_notify_newmsg_user_body'] = "Здравствуйте, %1\$s!\nВам поступил ответ по заявке #%2\$s. Ссылка для просмотра:\n%3\$s";

$L['support_newticket_title'] = 'Заголовок обращения';
$L['support_newticket_name'] = 'Ваше имя';
$L['support_newticket_email'] = 'E-mail';

$L['support_error_rtickettitle'] = 'Не указан заголовок обращения';
$L['support_error_rtickettitlelong'] = 'Слишком длинный заголовок обращения';
$L['support_error_rticketname'] = 'Пожалуйста, укажите ваше имя';
$L['support_error_rticketemail'] = 'Пожалуйста, укажите ваш email';

$L['support_error_rmsgtext'] = 'Не указаны подробности обращения';

$L['support_tickets_message_error_textempty'] = 'Не указан текст сообщения';
$L['support_tickets_message_error_closed'] = 'Данное обращение уже закрыто. Чтобы задать новый вопрос, пожалуйста, создайте новое обращение.';