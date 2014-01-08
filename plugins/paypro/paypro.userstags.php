<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */
/**
 * PayPro plugin
 *
 * @package paypro
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

$temp_array['ISPRO'] = (!empty($user_data)) ? cot_getuserpro($user_data) : false;

if(cot_auth('plug', 'paypro', 'A'))
{
	$temp_array['SET_PRO_1M'] = cot_url('plug', 'e=paypro&usrid='.$user_data['user_id'].'&months=1&a=setpro&'.cot_xg());
}

?>