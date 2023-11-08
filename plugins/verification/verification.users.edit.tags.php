<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=users.edit.tags
Tags=users.edit.tpl:{USERS_EDIT_VRF_TITLE},{USERS_EDIT_VRF_STATUS}
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
// активация статуса верификации вручную
require_once cot_langfile('verification', 'plug');
require_once cot_incfile('verification', 'plug', 'resources');

	$t->assign(array(
	    'USERS_EDIT_VRF_TITLE' => $L['ver_checked_user'],
		'USERS_EDIT_VRF_STATUS' => cot_radiobox($urr['user_verification_status'], 'ruserverification_status', array(1, 0), array($L['Yes'], $L['No']))
	));
