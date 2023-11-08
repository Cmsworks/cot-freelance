<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

/**
 * Verification of the identity of the freelancers. Checks the scanned passport.
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_langfile('verification', 'plug');
require_once cot_incfile('verification', 'plug', 'resources');

if(is_array($user_data)){
    $temp_array['VRF_TITLE'] = ($user_data['user_verification_status']) ?  $L['ver_vrf_status']:'';
    $temp_array['VRF_STATUS'] = ($user_data['user_verification_status']) ? cot_rc('vrf_activ_icon',array('title' => $L['ver_checked_user'])).$L['ver_txt4'] : $L['ver_nochecked'];
    $temp_array['VRF_ICON'] = ($user_data['user_verification_status']) ? cot_rc('vrf_activ_icon',array('title' => $L['ver_checked_user'])):'';
}