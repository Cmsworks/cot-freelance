<?php 

defined('COT_CODE') or die('Wrong URL');

global $db_config, $cfg;

if(is_array($cfg['plugin']['userpoints']))
{
	foreach($cfg['plugin']['userpoints'] as $cname => $value)
	{
		if($value > 0 && $value <1)
		{
			$rdata['config_value'] = $value*100;
			$rdata['config_value'] .= '%';
			$rdata['config_default'] = $value*100;
			$rdata['config_default'] .= '%';
			
			$db->update($db_config, $rdata, "config_cat='userpoints' AND config_name='".$cname."'");
		}
	}
}
