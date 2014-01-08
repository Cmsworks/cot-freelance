<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('paytop', 'plug');
require_once cot_incfile('payments', 'module');

global $db_users_top, $db_payments, $db_payments_services;

$db->query("CREATE TABLE IF NOT EXISTS `cot_payments_services` (
  `service_id` int(10) unsigned NOT NULL auto_increment,
  `service_area` varchar(20) NOT NULL,
  `service_userid` int(11) NOT NULL,
  `service_expire` int(11) NOT NULL,
  PRIMARY KEY  (`service_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$alltop = $db->query("SELECT * FROM $db_users_top")->fetchAll();
foreach($alltop as $top)
{
	$rservice['service_area'] = 'top';
	$rservice['service_userid'] = $top['top_userid'];
	$db->insert($db_payments_services, $rservice);
}

$db->query("DROP TABLE IF EXISTS $db_users_top");

?>