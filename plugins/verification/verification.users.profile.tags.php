<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=users.profile.tags
Tags=users.profile.tpl:{USERS_PROFILE_VRF_TITLE},{USERS_PROFILE_VRF_STATUS}
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

	$t->assign(array(
	    'USERS_PROFILE_VRF_TITLE' => $L['ver_vrf_status'],
		'USERS_PROFILE_VRF_STATUS' => ($urr['user_verification_status']) ? cot_rc('vrf_activ_icon',array('title' => $L['ver_checked_user'])).$L['ver_txt4'] : $L['ver_nochecked']
	));

