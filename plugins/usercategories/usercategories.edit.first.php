<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.profile.update.first, users.edit.update.first, users.register.add.first
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('usercategories', 'plug');

$catslimit = cot_cfg_usercategories();

$rcats = cot_import('rcats', 'P', 'ARR');

if(is_array($rcats)){
	$rcats = array_filter($rcats);
	$ruser['user_cats'] = implode(',', $rcats);
	
	if($m == 'edit' || $m == 'profile'){
		$groupid = $urr['user_maingrp'];
	}else{
		$groupid = cot_import('ruserusergroup','P','INT');
	}

	if(!cot_plugin_active('paypro') || cot_plugin_active('paypro') && !cot_getuserpro($urr))
	{
		cot_check($catslimit[$groupid]['default'] > 0 && count($rcats) > $catslimit[$groupid]['default'], cot_rc($L['usercategories_error_catslimit'], array('limit' => $catslimit[$groupid]['default'])), 'rcats');
	}
	elseif(cot_plugin_active('paypro') && cot_getuserpro($urr))
	{
		cot_check($catslimit[$groupid]['pro'] > 0 && count($rcats) > $catslimit[$groupid]['pro'], cot_rc($L['usercategories_error_catslimit'], array('limit' => $catslimit[$groupid]['pro'])), 'rcats');
	}
}