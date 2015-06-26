<?php
/**
 * 2.5.6
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects_offers, $cfg;

$sql = $db->query("SHOW COLUMNS FROM $db_projects_offers");
while($column = $sql->fetch()){
	$new_field = 'offer_' . substr($column['Field'], 5);
	$column['Null'] = ($column['Null'] == 'NO') ? 'NOT NULL' : 'NULL';
	$db->query("ALTER TABLE  $db_projects_offers 
		CHANGE  ".$column['Field']."  ".$new_field." ".$column['Type']." ".$column['Null']." ".$column['Default']." ".$column['Extra'].";");
}