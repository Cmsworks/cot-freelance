<?php
/**
 * 2.5.5
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects, $db_projects_offers, $cfg;

if (!$db->fieldExists($db_projects, "item_performer")){
	if($db->query("ALTER TABLE `$db_projects` ADD COLUMN `item_performer` INT( 11 ) NOT NULL")){
		$offers = $db->query("SELECT * FROM $db_projects_offers WHERE item_choise='performer'")->fetchAll();
		if(is_array($offers)){
			foreach($offers as $offer){
				$db->update($db_projects, array('item_performer' => $offer['item_userid']), "item_id=".$offer['item_pid']);
			}
		}
	}
}