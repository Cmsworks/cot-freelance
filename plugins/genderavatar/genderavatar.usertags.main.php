<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
Order=11
[END_COT_EXT]
==================== */
if($user_data['user_id'] > 0 && empty($user_data['user_avatar'])){
	switch ($user_data['user_gender']) {
		case 'M':
			$temp_array['AVATAR'] = cot_rc('ga_user_default_avatar_m');
			break;
		case 'F':
			$temp_array['AVATAR'] = cot_rc('ga_user_default_avatar_f');
			break;
		default:
			$temp_array['AVATAR'] = cot_rc('ga_user_default_avatar_u');
			break;
	}
}