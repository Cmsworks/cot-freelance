<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.filters
Tags=users.tpl:{USERS_TOP_FILTER_FU_XXX},{USERS_TOP_FILTER_FU_XXX_TITLE}
[END_COT_EXT]
==================== */

/**
 * filterforuser plugins
 *
 * @package filterforuser
 * @copyright (c) CrazyFreeMan
 */
defined('COT_CODE') or die('Wrong URL');
$db_filterforuser = (isset($db_filterforuser)) ? $db_filterforuser : $db_x . 'filterforuser';
// Extra fields for users
foreach($cot_extrafields[$db_users] as $exfld)
{	
	if ($db->query("SELECT COUNT(*) FROM $db_filterforuser WHERE fu_fieldname = '$exfld[field_name]'")->fetchColumn() == 1) {	
			$uname = strtolower($exfld['field_name']);			
			$fieldtext = isset($L['user_'.$exfld['field_name'].'_title']) ? $L['user_'.$exfld['field_name'].'_title'] : $exfld['field_description'];			
			$cs = (cot_import('fu_'.$uname, 'G', 'TXT')) ? cot_import('fu_'.$uname, 'G', 'TXT') : '';
			if (!is_array($exfld['field_variants']))
				{
					$titles = explode(',', $exfld['field_variants']);
				}			
			foreach ($titles as $key => $value) {
				$titles_select[$value] = $value;
			}		
			$titles_select = ($cfg['plugin']['filterforuser']['fu_usetitle_for_first']) ?  array(0 => $fieldtext) + $titles_select : array(0 => '---') + $titles_select ;	
			
			$t->assign('USERS_TOP_FILTER_FU_'.strtoupper($uname), cot_selectbox($cs, "fu_".strtolower($exfld['field_name']),  array_keys($titles_select), array_values($titles_select), $add_empty = false, $attrs = '', $custom_rc = '', $htmlspecialchars_bypass = false));
			$t->assign('USERS_TOP_FILTER_FU_'.strtoupper($uname).'_TITLE', $fieldtext);	
			unset($titles_select);
		}
	}
