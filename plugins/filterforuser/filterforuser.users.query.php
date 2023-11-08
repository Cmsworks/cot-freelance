<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.query
[END_COT_EXT]
==================== */

/**
 * filterforuser plugins
 *
 * @package filterforuser
 * @copyright (c) CrazyFreeMan
 */
defined('COT_CODE') or die('Wrong URL');

if($f == 'search')
{
	$db_filterforuser = (isset($db_filterforuser)) ? $db_filterforuser : $db_x . 'filterforuser';
	// Extra fields for users
	foreach($cot_extrafields[$db_users] as $exfld)
	{	
		if ($db->query("SELECT COUNT(*) FROM $db_filterforuser WHERE fu_fieldname = '$exfld[field_name]'")->fetchColumn() == 1) {	
				$uname = strtolower($exfld['field_name']);
				$fieldtext = isset($L['user_'.$exfld['field_name'].'_title']) ? $L['user_'.$exfld['field_name'].'_title'] : $exfld['field_description'];	
				$extfl = trim(cot_import('fu_'.$uname, 'G', 'TXT'));
				$extfl = ($extfl == '0') ? '' : $extfl;			
				if (!empty($extfl)) {
					if ($exfld['field_type'] == 'checklistbox') {
						$where[$exfld['field_name']] = "user_$exfld[field_name] LIKE '%".$extfl."%'";	
					}else{
						$where[$exfld['field_name']] = "user_$exfld[field_name] = '".$extfl."'";	
					}
				}	
			}
	}
}