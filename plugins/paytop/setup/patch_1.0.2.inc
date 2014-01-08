<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('paytop', 'plug');
require_once cot_incfile('payments', 'module');

global $db_payments_services, $sys;

$service_expire = $sys['now'] + 30*60*60*24;
$db->query("UPDATE $db_payments_services SET service_area='paytop.top', service_expire=$service_expire
	WHERE service_area='top'");

?>