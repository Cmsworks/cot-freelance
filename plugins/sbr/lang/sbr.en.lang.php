<?php

/**
 * sbr module
 *
 * @package sbr
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$L['cfg_tax'] = array('Комиссия за оформление сделки c Заказчика (%)');
$L['cfg_tax_performer'] = array('Комиссия с Исполнителя (%)');
$L['cfg_mincost'] = array('Минимальный бюджет этапа (0 - не проверяется)');
$L['cfg_maxcost'] = array('Максимальный бюджет этапа (0 - не проверяется)');
$L['cfg_maxdays'] = array('Максимальный срок исполнения этапа (0 - не проверяется)');
$L['cfg_maxrowsperpage'] = array('Число сделок на странице');
$L['cfg_filepath'] = array('Путь к директории хранения прикрепленных файлов');
$L['cfg_extensions'] = array('Допустимые форматы файлов');
$L['cfg_adminid'] = array('ID пользователя для зачисления комиссии');

$L['sbr'] = 'Сделки';
$L['sbr_mydeals'] = 'Мои сделки';

$L['sbr_admin_home_all'] = 'Все сделки';
$L['sbr_admin_home_claims'] = 'Арбитраж';
$L['sbr_admin_home_done'] = 'Завершенные';

$L['sbr_createlink'] = 'Предложить сделку';
$L['sbr_addtitle'] = 'Оформление сделки';
$L['sbr_edittitle'] = 'Изменение условий сделки';

$L['sbr_nav_info'] = 'Информация о сделке<br/><b>Бюджет и сроки</b>';
$L['sbr_nav_stagenum'] = 'Этап №';

$L['sbr_title'] = 'Название сделки';
$L['sbr_employer'] = 'Заказчик';
$L['sbr_performer'] = 'Исполнитель';
$L['sbr_performer_placeholder'] = 'Введите логин исполнителя';
$L['sbr_stagetitle'] = 'Название';
$L['sbr_stagetext'] = 'Техническое задание';
$L['sbr_stagecost'] = 'Бюджет';
$L['sbr_stagedays'] = 'Сроки';
$L['sbr_stagefiles'] = 'Файлы';
$L['sbr_stagestart'] = 'Старт этапа';
$L['sbr_stagedone'] = 'Приемка этапа';
$L['sbr_stageexpiredays'] = 'Осталось';
$L['sbr_stageexpired'] = 'Срок исполнения истек!';
$L['sbr_stagemenu'] = 'Решение по этапу';
$L['sbr_mincost'] = 'минимальный бюджет';
$L['sbr_maxdays'] = 'отсчет времени начнется с момента резервирования денег, максимальное время этапа';

$L['sbr_sendtoconfirm'] = 'Отправить на согласование';

$L['sbr_info'] = 'Общая информация';
$L['sbr_stage'] = 'Этап';
$L['sbr_history'] = 'История сделки';
$L['sbr_calc_title'] = 'Расчет суммы сделки с учетом комиссии';
$L['sbr_calc_summ'] = 'Сумма сделки';
$L['sbr_calc_tax'] = 'Комиссия сервиса';
$L['sbr_calc_total'] = 'Итого к оплате';

$L['sbr_addstagelink'] = 'Добавить этап';

$L['sbr_status_title'] = 'Статус сделки';

$L['sbr_deals_all'] = 'Все сделки';
$L['sbr_deals_cancel'] = 'Отмененные';
$L['sbr_deals_refuse'] = 'Не согласованные';
$L['sbr_deals_new'] = 'На согласовании';
$L['sbr_deals_confirm'] = 'Оплатить';
$L['sbr_deals_process'] = 'В работе';
$L['sbr_deals_done'] = 'Завершенные';
$L['sbr_deals_claim'] = 'Арбитраж';

$L['sbr_status_cancel'] = 'Отмененная сделка';
$L['sbr_status_refuse'] = 'Не согласованная';
$L['sbr_status_new'] = 'На согласовании';
$L['sbr_status_confirm'] = 'Ожидает оплаты';
$L['sbr_status_process'] = 'В работе';
$L['sbr_status_done'] = 'Завершенная сделка';
$L['sbr_status_claim'] = 'Арбитраж';

$L['sbr_error_rsbrperformer'] = 'Пользователь с указанным логином не найден';
$L['sbr_error_rsbrperformernotyou'] = 'Вы не можете быть одновременно Исполнителем и Заказчиком';
$L['sbr_error_rsbrtitle'] = 'Не указано название сделки';
$L['sbr_error_rstagetitle'] = 'Не указано название';
$L['sbr_error_rstagetext'] = 'Не заполнено техническое задание';
$L['sbr_error_rstagecost'] = 'Не указан бюджет';
$L['sbr_error_rstagecostmin'] = 'Бюджет слишком маленький';
$L['sbr_error_rstagecostmax'] = 'Бюджет слишком большой';
$L['sbr_error_rstagedays'] = 'Не указаны сроки';
$L['sbr_error_rstagedaysmax'] = 'Сроки слишком большие';

$L['sbr_action_confirm'] = 'Согласиться';
$L['sbr_action_refuse'] = 'Отказаться';
$L['sbr_action_cancel'] = 'Отменить сделку';
$L['sbr_action_edit'] = 'Изменить';
$L['sbr_action_pay'] = 'Оплатить сделку';
$L['sbr_action_claim'] = 'Обратиться в арбитраж';
$L['sbr_action_stagedone'] = 'Принять работу по этапу';

$L['sbr_paydesc'] = 'Оплата сделки "{$sbr_title}"';

$L['sbr_mail_toperformer_new_header'] = 'Согласование сделки "{$sbr_title}"';
$L['sbr_mail_toperformer_new_body'] = 'Здравствуйте, {$performer_name}. '."\n\n".'
	Заказчик {$employer_name}, предлагает вам заключить безопастную сделку "{$sbr_title}" с общим бюджетом {$sbr_cost}. 
	Более подробно ознакомиться с условиями сделки можно по ссылке: {$link}';

$L['sbr_mail_toperformer_edited_header'] = 'Изменения в условиях сделки "{$sbr_title}"';
$L['sbr_mail_toperformer_edited_body'] = 'Здравствуйте, {$performer_name}. '."\n\n".'
	Заказчик {$employer_name}, изменил условия безопасной сделки "{$sbr_title}" и предлагает вам ознакомиться с ними. 
	Более подробно ознакомиться с условиями сделки можно по ссылке: {$link}';

$L['sbr_mail_posts_header'] = 'Новое сообщение по сделке № {$sbr_id} ({$sbr_title})';
$L['sbr_mail_posts_body'] = 'Здравствуйте, {$user_name}.<br/><br/>{$sender_name} отправил вам сообщение:<br/><br/>{$post_text}<br/><br/>Подробности смотрите по ссылке: {$link}';
	
$L['sbr_mail_notification_header'] = 'Уведомнение по сделке № {$sbr_id} ({$sbr_title})';
$L['sbr_mail_notification_body'] = 'Здравствуйте, {$user_name}.<br/><br/>{$post_text}<br/><br/>Подробности смотрите по ссылке: {$link}';
		
$L['sbr_posts_performer_new'] = 'Пожалуйста, ознакомьтесь с условиями сделки и подтвердите свое участие. После этого Заказчик произведет оплату сделки и вы сможете приступить к работе.';
$L['sbr_posts_employer_new'] = 'Сделка отправлена на согласование исполнителю. Как только исполнитель подтвердит свое участие, вы получите уведомление и сможете произвести оплату.';

$L['sbr_posts_performer_edited'] = 'Пожалуйста, ознакомьтесь с новыми условиями сделки и подтвердите свое участие. После этого Заказчик произведет оплату сделки и вы сможете приступить к работе.';
$L['sbr_posts_employer_edited'] = 'Сделка с изменеными условиями отправлена на согласование исполнителю. Как только исполнитель подтвердит свое участие, вы получите уведомление и сможете произвести оплату.';

$L['sbr_posts_performer_refuse'] = 'Вы отказались от сделки. Заказчик может пересмотреть условия сделки и повторить процедуру согласования.';
$L['sbr_posts_employer_refuse'] = 'Исполнитель отказался от сделки. Вы можете пересмотреть условия сделки и повторить процедуру согласования.';

$L['sbr_posts_performer_confirm'] = 'Ожидается оплата сделки Заказчиком.';
$L['sbr_posts_employer_confirm'] = 'Исполнитель подтвердил свое согласие с условиями сделки. Теперь вы можете произвести оплату, чтобы Исполнитель смог приступить к работе.';

$L['sbr_posts_performer_paid'] = 'Сделка оформлена. Можете приступать к работе. Сумма сделки зарезервирована на счету сервиса и будет выплачиваться вам по мере приемки Заказчиком этапов сделки.';
$L['sbr_posts_employer_paid'] = 'Сделка оформлена. Сумма сделки зарезервирована на счету сервиса и будет выплачиваться Исполнителю по мере вашей приемки этапов сделки.';

$L['sbr_posts_performer_stage_done'] = 'Заказчик принял работу по этапу №{$stage_num} ({$stage_title}). На ваш счет поступила оплата в размере: {$stage_cost} {$valuta}';
$L['sbr_posts_employer_stage_done'] = 'Вы приняли работы по этапу №{$stage_num} ({$stage_title}). На счет Исполнителя поступила оплата в размере: {$stage_cost} {$valuta}';

$L['sbr_posts_stage_claim'] = '<h4>Подана жалоба в арбитраж!</h4><br/><b>Текст жалобы:</b><br/>{$from_name}: {$claim_text}<br/><br/>Сделка будет рассмотрена арбитражной комиссией. Как только комиссия примет решение, вы получите уведомление по email.';

$L['sbr_posts_performer_stage_claim_decision_payment'] = '<h4>Решение арбитражной комиссии</h4><br/>По результатам рассмотрения жалобы по этапу №{$stage_num} ({$stage_title}) арбитражной комиссией было принято следующее решение:<br/><br/>{$decision}<br/><br/>Оплата Исполнителю: {$payperformer} {$valuta}<br/>Возврат Заказчику: {$payemployer} {$valuta}';
$L['sbr_posts_employer_stage_claim_decision_payment'] = '<h4>Решение арбитражной комиссии</h4><br/>По результатам рассмотрения жалобы по этапу №{$stage_num} ({$stage_title}) арбитражной комиссией было принято следующее решение:<br/><br/>{$decision}<br/><br/>Оплата Исполнителю: {$payperformer} {$valuta}<br/>Возврат Заказчику: {$payemployer} {$valuta}';

$L['sbr_posts_performer_cancel'] = 'Сделка отменена Заказчиком.';
$L['sbr_posts_employer_cancel'] = 'Сделка отменена вами.';

$L['sbr_posts_performer_done'] = 'Сделка завершена.';
$L['sbr_posts_employer_done'] = 'Сделка завершена.';

$L['sbr_posts_button'] = 'Отправить сообщение';

$L['sbr_posts_to'] = 'Кому';
$L['sbr_posts_to_all'] = 'Всем';
$L['sbr_posts_to_performer'] = 'Исполнителю';
$L['sbr_posts_to_employer'] = 'Заказчику';

$L['sbr_posts_error_textempty'] = 'Сообщение не должно быть пустым';

$L['sbr_posts_from'] = 'Сообщение от';
$L['sbr_posts_for'] = 'Сообщение для';

$L['sbr_stage_done_payments_desc'] = 'СБР: "{$sbr_title}": Оплата за этап №{$stage_num} ({$stage_title}).';
$L['sbr_stage_tax_payments_desc'] = 'Доход с СБР: "{$sbr_title}": этап №{$stage_num} ({$stage_title}).';
$L['sbr_stage_done_title'] = 'Принять работу по этапу';


$L['sbr_claim_msg'] = 'Подана жалоба в арбитраж!';
$L['sbr_claim_error_cost'] = 'Сумма выплат не соответствует общей стоимости этапа данной сделки';
$L['sbr_claim_add_title'] = 'Обращение в арбитраж';
$L['sbr_claim_add_error_text'] = 'Не указана причина обращения в арбитраж';

$L['sbr_claim_payments_performer_desc'] = 'СБР: "{$sbr_title}": Оплата за этап №{$stage_num} ({$stage_title}), согласно решению арбитражной комиссии.';
$L['sbr_claim_payments_employer_desc'] = 'СБР: "{$sbr_title}": Возврат за этап №{$stage_num} ({$stage_title}), согласно решению арбитражной комиссии.';
$L['sbr_claim_payments_admin_desc'] = 'Доход с СБР: "{$sbr_title}": этап №{$stage_num} ({$stage_title}), согласно решению арбитражной комиссии.';

$L['sbr_claim_decision_button'] = 'Принять решение';
$L['sbr_claim_decision_title'] = 'Решение арбитражной комиссии';
$L['sbr_claim_decision_pay_performer'] = 'Оплатить исполнителю';
$L['sbr_claim_decision_pay_employer'] = 'Вернуть Заказчику';

$L['sbr_claim_decision_error_text'] = 'Не заполнено пояснение к решению арбитражной комиссии';
$L['sbr_claim_decision_error_pay'] = 'Сумма выплат не соответствует бюджету этапа';