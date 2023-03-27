<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('sbr', 'plug');
require_once cot_incfile('payments', 'module');
require_once cot_incfile('projects', 'module');

// Проверяем платежки на оплату сделок. Если есть то активируем сделки.
if ($sbrpays = cot_payments_getallpays('sbr', 'paid'))
{
	foreach ($sbrpays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			if($sbr = $db->query("SELECT * FROM $db_sbr WHERE sbr_id=" . $pay['pay_code'])->fetch()){

				// Запуск сделки на исполнение
				if($db->update($db_sbr, array('sbr_status' => 'process', 'sbr_begin' => $sys['now']), "sbr_id=" . $pay['pay_code'])){

					// Выбираем исполнителем, если сделка привязана к проекту
					if($sbr['sbr_pid'] > 0){
						
						// находим предыдущего выбранного исполнителя, если есть
						$lastperformer = $db->query("SELECT u.* FROM $db_projects_offers AS o
							LEFT JOIN $db_users AS u ON u.user_id=o.offer_userid 
							WHERE offer_pid=" . (int)$sbr['sbr_pid'] . " AND offer_choise='performer'")->fetch();

						if($db->update($db_projects_offers, array("offer_choise" => 'performer', "offer_choise_date" => (int)$sys['now']), "offer_pid=" . (int)$sbr['sbr_pid'] . " AND offer_userid=" . (int)$sbr['sbr_performer'])){
							if ($db->fieldExists($db_projects, "item_performer")){
								if($db->update($db_projects, array("item_performer" => $sbr['sbr_performer']), "item_id=" . (int)$sbr['sbr_pid'])){
									/* === Hook === */
									foreach (cot_getextplugins('sbr.pay.setperformer') as $pl)
									{
										include $pl;
									}
									/* ===== */
								}
							}
						}
					}

					// Активируем на исполнение первый этап сделки
					$db->update($db_sbr_stages, array('stage_status' => 'process', 'stage_begin' => $sys['now']), "stage_sid=" . $pay['pay_code'] . " AND stage_num=1");

					// Отправка уведомлений
					cot_sbr_sendpost($pay['pay_code'], $L['sbr_posts_performer_paid'], $sbr['sbr_performer'], 0, 'success', true);
					cot_sbr_sendpost($pay['pay_code'], $L['sbr_posts_employer_paid'], $sbr['sbr_employer'], 0, 'success', true);

					/* === Hook === */
					foreach (cot_getextplugins('sbr.pay.done') as $pl)
					{
						include $pl;
					}
					/* ===== */
				}
			}
		}
	}
}

?>