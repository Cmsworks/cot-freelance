<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('paypro', 'plug');
require_once cot_incfile('payments', 'module');

global $db_users_pro, $db_payments, $db_payments_services;

$db->query("CREATE TABLE IF NOT EXISTS `cot_payments_services` (
  `service_id` int(10) unsigned NOT NULL auto_increment,
  `service_area` varchar(20) NOT NULL,
  `service_userid` int(11) NOT NULL,
  `service_expire` int(11) NOT NULL,
  PRIMARY KEY  (`service_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$allpro = $db->query("SELECT * FROM $db_users_pro")->fetchAll();
foreach($allpro as $pro)
{
	$rservice['service_area'] = 'pro';
	$rservice['service_userid'] = $pro['pro_userid'];
	$rservice['service_expire'] = $pro['pro_expire'];
	$db->insert($db_payments_services, $rservice);
}

$db->query("DROP TABLE IF EXISTS $db_users_pro");

?>