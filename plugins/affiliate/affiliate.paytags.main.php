<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=paytags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

if($item_data['pay_area'] == 'balance' && strstr($item_data['pay_code'],'affiliate:')){
	$temp_array['DESC'] = $L['affiliate_payment_paydesc'];
}