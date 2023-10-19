<?php

global $db_config, $cfg;

$db->update($db_config, 
	array(
		'config_value' => '0,'.$cfg['plugin']['affiliate']['levelpay'], 
		'config_default' => '0,'.$cfg['plugin']['affiliate']['levelpay']
	), 
	"config_owner='plug' AND config_cat='affiliate' AND config_name='levelpay'");