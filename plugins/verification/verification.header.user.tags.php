<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
Tags=header.tpl:{HEADER_USER_VRF_ICON}
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

require_once cot_incfile('verification', 'plug', 'resources');

if($usr['profile']['user_verification_status'])$t->assign("HEADER_USER_VRF_ICON" ,cot_rc('vrf_activ_icon',array('title' => $L['ver_checked_user'])));

