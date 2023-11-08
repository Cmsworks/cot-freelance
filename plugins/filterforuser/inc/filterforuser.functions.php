<?php
/**
 * filterforuser plugins
 *
 * @package filterforuser
 * @copyright (c) CrazyFreeMan
 */
defined('COT_CODE') or die('Wrong URL');

function cot_get_fu_field(){
	global $db, $db_users;
	$array_fu = array();

		foreach($cot_extrafields[$db_users] as $exfld)
		{
			$array_fu[]['uname'] = strtoupper($exfld['field_name']);
			$array_fu[]['fieldtext'] = isset($L['user_'.$exfld['field_name'].'_title']) ? $L['user_'.$exfld['field_name'].'_title'] : $exfld['field_description'];
			
		}
		return $array_fu;
}

function cot_get_fu_option(){
	require_once cot_incfile('forms');
	return cot_checkbox('', 'opt', $title = 'Параметр', $attrs = '', $value = '1');	 
}