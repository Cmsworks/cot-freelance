<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('paypro', 'plug');
require_once cot_incfile('payments', 'module');

global $db_users, $db_payments_services;

// Add field if missing
if (!$db->fieldExists($db_users, "user_pro"))
{
	$dbres = $db->query("ALTER TABLE `$db_users` ADD COLUMN `user_pro` int(10) NOT NULL");
}

$allpro = $db->query("SELECT * FROM $db_payments_services 
	WHERE service_area='pro'")->fetchAll();

foreach($allpro as $pro)
{
	$db->query("UPDATE $db_users SET user_pro=".$pro['service_expire']." WHERE user_id=".$pro['service_userid']);
}

?>